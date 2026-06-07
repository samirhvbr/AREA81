<?php

namespace App\Http\Controllers;

use App\Services\NewsletterService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class NewsletterController extends Controller
{
    public function __construct(private readonly NewsletterService $newsletter) {}

    /**
     * Recebe o cadastro (nome + e-mail) e dispara o e-mail de confirmação.
     */
    public function subscribe(Request $request): RedirectResponse
    {
        // Honeypot: o campo "website" fica escondido por CSS. Humano não preenche; bot sim.
        if (filled($request->input('website'))) {
            Log::channel('newsletter')->warning('Inscrição bloqueada pelo honeypot', [
                'ip' => $request->ip(),
            ]);
            // Responde como sucesso pra não dar pista ao bot.
            return back()->with('newsletter_status', 'Quase lá! Verifique seu e-mail.');
        }

        $data = $request->validate([
            'name'  => ['required', 'string', 'max:120'],
            'email' => ['required', 'string', 'email:rfc', 'max:255'],
        ], [], [
            'name'  => 'nome',
            'email' => 'e-mail',
        ]);

        $result = $this->newsletter->subscribe($data['name'], $data['email'], $request->ip());

        $message = match ($result) {
            'already_confirmed' => 'Você já está inscrito — tudo certo por aqui!',
            default             => 'Quase lá! Enviamos um e-mail de confirmação. O link vale por 2 dias.',
        };

        return back()->with('newsletter_status', $message);
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
