<?php

namespace Tests\Feature;

use App\Services\Newsletter\NewsletterAbuseGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * Barreiras anti-abuso do /newsletter/subscribe (list bombing — mesmo vetor do
 * incidente SShvTerm 07/2026).
 *
 * A costura observável é o Mail: barrado = nada é enviado; erro visível = nada é
 * enviado. Estes testes são propositalmente SEM banco — todo caminho barrado
 * retorna no NewsletterAbuseGuard antes de tocar o NewsletterService (que grava
 * Subscriber). Cache/RateLimiter usam o driver 'array' (phpunit.xml), então o
 * cooldown e o teto diário funcionam em memória, sem MariaDB.
 */
class NewsletterAbuseGuardTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
    }

    /** Timestamp de render cifrado, com idade controlada (padrão: humano plausível). */
    private function fts(int $ageSeconds = 10): string
    {
        return Crypt::encryptString((string) (time() - $ageSeconds));
    }

    private function postSubscribe(array $overrides = [])
    {
        return $this->post(route('newsletter.subscribe'), array_merge([
            'name' => 'Fulano de Tal',
            'email' => 'usuario.legitimo@gmail.com',
            NewsletterAbuseGuard::FORM_TS_FIELD => $this->fts(),
            NewsletterAbuseGuard::HONEYPOT_FIELD => '',
        ], $overrides));
    }

    public function test_requisicao_limpa_passa_pelas_barreiras_do_guard(): void
    {
        // Sem banco: valida no nível do guard que um pedido legítimo NÃO é
        // bloqueado (evita falso-positivo do teto/cooldown/tempo/honeypot).
        $request = Request::create('/newsletter/subscribe', 'POST', [
            'name' => 'Fulano de Tal',
            'email' => 'usuario.legitimo@gmail.com',
            NewsletterAbuseGuard::FORM_TS_FIELD => $this->fts(),
            NewsletterAbuseGuard::HONEYPOT_FIELD => '',
        ]);

        $guard = app(NewsletterAbuseGuard::class);

        $this->assertTrue($guard->passesBotChecks($request, 'usuario.legitimo@gmail.com'));
        // Turnstile sem chave configurada = camada desligada (passa).
        $this->assertTrue($guard->passesTurnstile($request));
    }

    public function test_honeypot_preenchido_finge_sucesso_sem_enviar(): void
    {
        $response = $this->postSubscribe([NewsletterAbuseGuard::HONEYPOT_FIELD => 'http://spam.example']);

        $response->assertRedirect();
        $response->assertSessionHas('newsletter_status');
        Mail::assertNothingSent();
    }

    public function test_submit_rapido_demais_finge_sucesso_sem_enviar(): void
    {
        $response = $this->postSubscribe([NewsletterAbuseGuard::FORM_TS_FIELD => $this->fts(0)]);

        $response->assertSessionHas('newsletter_status');
        Mail::assertNothingSent();
    }

    public function test_timestamp_forjado_ou_ausente_finge_sucesso_sem_enviar(): void
    {
        $response = $this->postSubscribe([NewsletterAbuseGuard::FORM_TS_FIELD => 'lixo-nao-cifrado']);

        $response->assertSessionHas('newsletter_status');
        Mail::assertNothingSent();
    }

    public function test_cooldown_por_email_bloqueia_reenvio_sem_enviar(): void
    {
        // Simula que um e-mail de confirmação JÁ saiu para este endereço (o
        // vetor do abuso: reenvio a um pendente a cada POST). O próximo POST
        // precisa cair no cooldown e não enviar nada.
        app(NewsletterAbuseGuard::class)->registerSend('usuario.legitimo@gmail.com');

        $response = $this->postSubscribe();

        $response->assertSessionHas('newsletter_status');
        Mail::assertNothingSent();
    }

    public function test_teto_diario_global_finge_sucesso_sem_enviar(): void
    {
        Cache::put(NewsletterAbuseGuard::dailyCounterKey(), (int) config('newsletter.daily_cap'), 600);

        $response = $this->postSubscribe();

        $response->assertSessionHas('newsletter_status');
        Mail::assertNothingSent();
    }

    public function test_dominio_descartavel_recebe_erro_sem_enviar(): void
    {
        $response = $this->postSubscribe(['email' => 'bot@yopmail.com']);

        $response->assertSessionHasErrors('email');
        Mail::assertNothingSent();
    }

    public function test_turnstile_reprovado_recebe_erro_sem_enviar(): void
    {
        config([
            'services.turnstile.site_key' => 'site-key-teste',
            'services.turnstile.secret_key' => 'secret-teste',
        ]);
        Http::fake([
            'challenges.cloudflare.com/*' => Http::response(['success' => false, 'error-codes' => ['invalid-input-response']]),
        ]);

        $response = $this->postSubscribe();

        $response->assertSessionHasErrors('turnstile');
        Mail::assertNothingSent();
    }

    public function test_form_timestamp_gera_token_decifravel(): void
    {
        $token = app(NewsletterAbuseGuard::class)->formTimestamp();

        $this->assertEqualsWithDelta(now()->timestamp, (int) Crypt::decryptString($token), 5);
    }
}
