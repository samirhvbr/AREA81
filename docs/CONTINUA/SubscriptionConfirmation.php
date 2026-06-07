<?php

namespace App\Mail;

use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Subscriber $subscriber) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirme sua inscrição na newsletter',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.subscription_confirmation',
            with: [
                'name'       => $this->subscriber->name,
                'confirmUrl' => route('newsletter.confirm', ['token' => $this->subscriber->confirmation_token]),
                'expiresAt'  => $this->subscriber->token_expires_at,
            ],
        );
    }
}
