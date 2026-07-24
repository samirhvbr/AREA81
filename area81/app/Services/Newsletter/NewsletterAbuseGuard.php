<?php

namespace App\Services\Newsletter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

/**
 * Barreiras anti-abuso do formulário público de inscrição na newsletter.
 *
 * Contexto: o /newsletter/subscribe dispara um e-mail de confirmação (double
 * opt-in) para QUALQUER endereço informado. Sem travas por endereço, um bot usa
 * o formulário para bombardear caixas de terceiros com o e-mail de confirmação
 * e estoura a cota do provedor de SMTP — foi o incidente de list bombing sofrido
 * pelo site do SShvTerm (18-23/07/2026), e este formulário tem o MESMO vetor.
 *
 * Camadas, na ordem de custo: honeypot → tempo mínimo → cooldown por e-mail →
 * teto global diário → Turnstile (única com chamada externa). Sinal de bot
 * recebe a MESMA tela de sucesso do fluxo normal: preserva a anti-enumeração e
 * não ensina o bot qual barreira o pegou. Limites em config/newsletter.php.
 */
class NewsletterAbuseGuard
{
    /** Campo isca do formulário: humano não vê (CSS), bot preenche. */
    public const HONEYPOT_FIELD = 'website';

    /** Campo oculto com o timestamp cifrado de render do formulário. */
    public const FORM_TS_FIELD = 'fts';

    /** Valor do FORM_TS_FIELD para o render atual. */
    public function formTimestamp(): string
    {
        return Crypt::encryptString((string) now()->timestamp);
    }

    /**
     * Barreiras silenciosas. False = fingir sucesso e não enviar nada.
     */
    public function passesBotChecks(Request $request, string $email): bool
    {
        return match (true) {
            $this->honeypotTripped($request) => $this->deny('honeypot', $email, $request),
            $this->submittedTooFast($request) => $this->deny('too_fast', $email, $request),
            $this->emailOnCooldown($email) => $this->deny('cooldown', $email, $request),
            $this->dailyCapReached() => $this->deny('daily_cap', $email, $request),
            default => true,
        };
    }

    /**
     * Valida o token do Turnstile na API do Cloudflare. Sem chave configurada a
     * camada fica desligada (retorna true). Fail-closed: indisponibilidade do
     * Cloudflare bloqueia o envio — pro humano é só tentar de novo.
     */
    public function passesTurnstile(Request $request): bool
    {
        if (! $this->turnstileEnabled()) {
            return true;
        }

        try {
            $response = Http::asForm()->timeout(5)
                ->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                    'secret' => config('services.turnstile.secret_key'),
                    'response' => (string) $request->input('cf-turnstile-response'),
                    'remoteip' => $request->ip(),
                ]);

            if ($response->successful() && $response->json('success') === true) {
                return true;
            }

            Log::channel('newsletter')->warning('NewsletterAbuseGuard: Turnstile reprovou o submit', [
                'ip' => $request->ip(),
                'codes' => $response->json('error-codes'),
            ]);
        } catch (\Throwable $e) {
            Log::channel('newsletter')->warning('NewsletterAbuseGuard: Turnstile indisponível (fail-closed)', [
                'error' => $e->getMessage(),
            ]);
        }

        return false;
    }

    public function turnstileEnabled(): bool
    {
        return filled(config('services.turnstile.secret_key'));
    }

    /** Domínio descartável? Erro visível fica a cargo do controller. */
    public function isDisposable(string $email): bool
    {
        $domain = strtolower(substr(strrchr($email, '@') ?: '', 1));
        if ($domain === '') {
            return false;
        }

        foreach ((array) config('newsletter.disposable_domains') as $blocked) {
            if ($domain === $blocked || str_ends_with($domain, '.'.$blocked)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Registra um envio REAL: consome o cooldown do endereço e o teto global.
     * Chamar só quando o e-mail de confirmação vai mesmo sair (created | resent).
     */
    public function registerSend(string $email): void
    {
        [$key15, $keyDay] = $this->cooldownKeys($email);
        RateLimiter::hit($key15, 900);
        RateLimiter::hit($keyDay, 86400);

        $counter = self::dailyCounterKey();
        Cache::add($counter, 0, now()->addDays(2));
        $count = (int) Cache::increment($counter);

        if ($count >= (int) config('newsletter.daily_cap')) {
            $this->alertDailyCap($count);
        }
    }

    /** Chave do contador global de envios do dia (exposta p/ testes e admin). */
    public static function dailyCounterKey(): string
    {
        return 'newsletter:sent:'.now()->format('Y-m-d');
    }

    private function honeypotTripped(Request $request): bool
    {
        return filled($request->input(self::HONEYPOT_FIELD));
    }

    private function submittedTooFast(Request $request): bool
    {
        try {
            $renderedAt = (int) Crypt::decryptString((string) $request->input(self::FORM_TS_FIELD));
        } catch (\Throwable) {
            // Ausente ou forjado = não veio do nosso formulário.
            return true;
        }

        $elapsed = now()->timestamp - $renderedAt;

        return $elapsed < (int) config('newsletter.min_seconds')
            || $elapsed > (int) config('newsletter.max_form_age');
    }

    private function emailOnCooldown(string $email): bool
    {
        [$key15, $keyDay] = $this->cooldownKeys($email);

        return RateLimiter::tooManyAttempts($key15, (int) config('newsletter.cooldown_15min'))
            || RateLimiter::tooManyAttempts($keyDay, (int) config('newsletter.cooldown_day'));
    }

    private function dailyCapReached(): bool
    {
        return (int) Cache::get(self::dailyCounterKey(), 0) >= (int) config('newsletter.daily_cap');
    }

    /** @return array{0: string, 1: string} */
    private function cooldownKeys(string $email): array
    {
        $hash = sha1(mb_strtolower(trim($email)));

        return ['newsletter:cd15:'.$hash, 'newsletter:cdday:'.$hash];
    }

    private function deny(string $reason, string $email, Request $request): bool
    {
        Log::channel('newsletter')->warning('NewsletterAbuseGuard: inscrição barrada', [
            'reason' => $reason,
            'email' => $email,
            'ip' => $request->ip(),
        ]);

        if ($reason === 'daily_cap') {
            $this->alertDailyCap((int) Cache::get(self::dailyCounterKey(), 0));
        }

        return false;
    }

    /** Loga e avisa (1x/dia) que o teto global de confirmações foi atingido. */
    private function alertDailyCap(int $count): void
    {
        if (! Cache::add('newsletter:cap-alerted:'.now()->format('Y-m-d'), true, now()->addDays(2))) {
            return; // Já avisado hoje.
        }

        Log::channel('newsletter')->critical('NewsletterAbuseGuard: teto diário de e-mails de confirmação atingido', [
            'count' => $count,
            'cap' => (int) config('newsletter.daily_cap'),
        ]);

        $to = config('newsletter.alert_email');
        if (blank($to)) {
            return;
        }

        try {
            Mail::raw(
                "O formulário /newsletter/subscribe atingiu o teto diário de {$count} e-mails de confirmação.\n\n"
                ."Novas inscrições estão recebendo a tela de sucesso SEM envio até virar o dia.\n"
                ."Se não houver campanha legítima em andamento, é provável abuso — confira os logs\n"
                ."(canal newsletter) e o painel do provedor de e-mail.\n",
                fn ($message) => $message->to($to)->subject('[AREA81] Teto diário de confirmações de newsletter atingido')
            );
        } catch (\Throwable $e) {
            Log::channel('newsletter')->error('NewsletterAbuseGuard: falha ao enviar alerta de teto diário', ['error' => $e->getMessage()]);
        }
    }
}
