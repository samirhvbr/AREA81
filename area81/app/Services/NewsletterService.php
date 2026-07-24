<?php

namespace App\Services;

use App\Mail\SubscriptionConfirmation;
use App\Models\Subscriber;
use App\Services\Newsletter\NewsletterAbuseGuard;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class NewsletterService
{
    /** Validade do link de confirmação, em dias. */
    private const TOKEN_TTL_DAYS = 2;

    public function __construct(private readonly NewsletterAbuseGuard $guard) {}

    /**
     * Inscreve (ou reenvia a confirmação) e dispara o e-mail de double opt-in.
     *
     * @return string Status do que aconteceu: created | resent | already_confirmed
     */
    public function subscribe(string $name, string $email, ?string $ip = null): string
    {
        $email = mb_strtolower(trim($email));
        $name = trim($name);
        $existing = Subscriber::where('email', $email)->first();

        // Já confirmado: não faz nada, só registra.
        if ($existing && $existing->isConfirmed()) {
            Log::channel('newsletter')->info('Inscrição ignorada: e-mail já confirmado', [
                'subscriber_id' => $existing->id,
                'email' => $email,
                'ip' => $ip,
            ]);

            return 'already_confirmed';
        }

        $token = Str::random(64);
        $expiresAt = now()->addDays(self::TOKEN_TTL_DAYS);

        if ($existing) {
            // Pendente que tentou de novo: gera token novo e reenvia.
            $existing->update([
                'name' => $name,
                'status' => 'pending',
                'confirmation_token' => $token,
                'token_expires_at' => $expiresAt,
                'subscribe_ip' => $ip,
            ]);
            $subscriber = $existing;
            $status = 'resent';

            Log::channel('newsletter')->info('Token de confirmação reenviado', [
                'subscriber_id' => $subscriber->id,
                'email' => $email,
                'ip' => $ip,
            ]);
        } else {
            $subscriber = Subscriber::create([
                'name' => $name,
                'email' => $email,
                'status' => 'pending',
                'confirmation_token' => $token,
                'token_expires_at' => $expiresAt,
                'subscribe_ip' => $ip,
            ]);
            $status = 'created';

            Log::channel('newsletter')->info('Nova inscrição pendente criada', [
                'subscriber_id' => $subscriber->id,
                'email' => $email,
                'ip' => $ip,
            ]);
        }

        // Envio do e-mail (logando sucesso e falha).
        try {
            Mail::to($subscriber->email)->send(new SubscriptionConfirmation($subscriber));

            // Envio REAL saiu: consome o cooldown do endereço e o teto diário
            // global (anti list bombing). Fica aqui — e não no controller — para
            // cobrir tanto 'created' quanto 'resent': o reenvio a um pendente a
            // cada POST é justamente o vetor de abuso. Falha no envio não chega
            // aqui, então nada é consumido para um e-mail que não saiu.
            $this->guard->registerSend($subscriber->email);

            Log::channel('newsletter')->info('E-mail de confirmação enviado', [
                'subscriber_id' => $subscriber->id,
                'email' => $email,
                'expires_at' => $expiresAt->toIso8601String(),
            ]);
        } catch (\Throwable $e) {
            Log::channel('newsletter')->error('Falha ao enviar e-mail de confirmação', [
                'subscriber_id' => $subscriber->id,
                'email' => $email,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }

        return $status;
    }

    /**
     * Confirma a inscrição a partir do token.
     *
     * @return string confirmed | expired | invalid
     */
    public function confirm(string $token): string
    {
        $subscriber = Subscriber::where('confirmation_token', $token)->first();

        if (! $subscriber) {
            Log::channel('newsletter')->warning('Tentativa de confirmação com token inválido', [
                'token_prefix' => Str::limit($token, 12, '...'),
            ]);

            return 'invalid';
        }

        if (! $subscriber->tokenIsValid()) {
            Log::channel('newsletter')->info('Confirmação com token expirado', [
                'subscriber_id' => $subscriber->id,
                'email' => $subscriber->email,
                'expired_at' => $subscriber->token_expires_at?->toIso8601String(),
            ]);

            return 'expired';
        }

        $subscriber->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
            'confirmation_token' => null,
            'token_expires_at' => null,
        ]);

        Log::channel('newsletter')->info('Inscrição confirmada', [
            'subscriber_id' => $subscriber->id,
            'email' => $subscriber->email,
        ]);

        return 'confirmed';
    }
}
