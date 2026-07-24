<?php

namespace App\Http\Controllers;

use App\Services\Newsletter\NewsletterAbuseGuard;
use App\Services\NewsletterService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsletterController extends Controller
{
    /**
     * MESMA mensagem neutra para todo desfecho não-erro (nova inscrição, reenvio
     * a um pendente, já inscrito E sinal de bot barrado). Anti-enumeração: não
     * revela se o endereço já estava inscrito nem qual barreira anti-abuso pegou.
     */
    private const NEUTRAL_STATUS = 'Quase lá! Se o e-mail for válido, enviamos um link de confirmação — verifique sua caixa de entrada (e o spam). O link vale por 2 dias.';

    public function __construct(
        private readonly NewsletterService $newsletter,
        private readonly NewsletterAbuseGuard $guard,
    ) {}

    /**
     * Página de inscrição na newsletter (mostra o formulário).
     */
    public function index(): View
    {
        return view('newsletter.index');
    }

    /**
     * Recebe o cadastro (nome + e-mail) e dispara o e-mail de confirmação.
     *
     * Blindado contra list bombing (mesmo padrão do SShvTerm): honeypot, tempo
     * mínimo, cooldown por endereço e teto diário global no NewsletterAbuseGuard;
     * o cooldown/teto só são consumidos quando o e-mail REALMENTE sai (no Service).
     */
    public function subscribe(Request $request): RedirectResponse
    {
        $emailInput = (string) $request->input('email');

        // Barreiras silenciosas (honeypot, tempo mínimo, cooldown por e-mail, teto
        // diário): qualquer sinal de bot recebe a MESMA tela de sucesso neutra, sem
        // enviar nada — preserva anti-enumeração e não revela qual barreira pegou.
        if (! $this->guard->passesBotChecks($request, $emailInput)) {
            return back()->with('newsletter_status', self::NEUTRAL_STATUS);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'string', 'email:rfc', 'max:255'],
        ], [], [
            'name' => 'nome',
            'email' => 'e-mail',
        ]);

        $email = mb_strtolower(trim($data['email']));

        // Descartável: erro visível (política de qualidade, não sinal de bot; o
        // aviso é sobre o domínio e não revela se o endereço já está inscrito).
        if ($this->guard->isDisposable($email)) {
            return back()
                ->withErrors(['email' => 'Use um e-mail permanente — endereços descartáveis não são aceitos.'])
                ->withInput();
        }

        // Turnstile por último (única barreira com chamada externa). Fail-closed:
        // indisponibilidade do Cloudflare bloqueia; o humano só tenta de novo.
        if (! $this->guard->passesTurnstile($request)) {
            return back()
                ->withErrors(['turnstile' => 'Não foi possível confirmar que você não é um robô. Tente novamente.'])
                ->withInput();
        }

        // Pedido legítimo. O Service envia (ou não, se já confirmado) e consome o
        // cooldown/teto apenas quando o e-mail de confirmação de fato sai.
        $this->newsletter->subscribe($data['name'], $email, $request->ip());

        // Sempre a MESMA resposta neutra (created | resent | already_confirmed).
        return back()->with('newsletter_status', self::NEUTRAL_STATUS);
    }

    /**
     * Confirma a inscrição a partir do token do link.
     */
    public function confirm(string $token): View
    {
        $result = $this->newsletter->confirm($token);

        return view('newsletter.status', ['result' => $result]);
    }
}
