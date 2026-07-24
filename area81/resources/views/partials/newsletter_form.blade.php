{{-- Formulário de inscrição na newsletter. Inclua onde quiser: @include('partials.newsletter_form') --}}
@php
    // Guard anti-abuso (list bombing): resolvido aqui para o partial ser
    // autossuficiente onde quer que seja incluído (não depende do controller).
    $newsletterGuard = app(\App\Services\Newsletter\NewsletterAbuseGuard::class);
@endphp
<div class="cp-glass-card" style="padding:32px; max-width:480px;">
    <h3 style="font-family:'Inter', sans-serif; font-size:1.1rem; font-weight:600; color:#f1f5f9; margin-bottom:8px;">
        Receba por e-mail
    </h3>
    <p style="font-family:'Inter', sans-serif; font-size:0.9rem; color:#94a3b8; line-height:1.6; margin-bottom:20px;">
        As novidades do blog direto na sua caixa de entrada. Sem spam.
    </p>

    @if (session('newsletter_status'))
        <p style="font-family:'JetBrains Mono', monospace; font-size:0.8rem; color:#34d399; margin-bottom:16px;">
            // {{ session('newsletter_status') }}
        </p>
    @endif

    @error('name')
        <p style="font-family:'JetBrains Mono', monospace; font-size:0.8rem; color:#f87171; margin-bottom:12px;">// {{ $message }}</p>
    @enderror
    @error('email')
        <p style="font-family:'JetBrains Mono', monospace; font-size:0.8rem; color:#f87171; margin-bottom:12px;">// {{ $message }}</p>
    @enderror
    @error('turnstile')
        <p style="font-family:'JetBrains Mono', monospace; font-size:0.8rem; color:#f87171; margin-bottom:12px;">// {{ $message }}</p>
    @enderror

    <form method="POST" action="{{ route('newsletter.subscribe') }}">
        @csrf

        {{-- Honeypot anti-spam: escondido por CSS, humanos não veem. --}}
        <input type="text" name="{{ \App\Services\Newsletter\NewsletterAbuseGuard::HONEYPOT_FIELD }}"
               tabindex="-1" autocomplete="off" aria-hidden="true"
               style="position:absolute; left:-9999px; width:1px; height:1px; opacity:0;">

        {{-- Timestamp de render cifrado: barreira de tempo mínimo anti-bot. --}}
        <input type="hidden" name="{{ \App\Services\Newsletter\NewsletterAbuseGuard::FORM_TS_FIELD }}"
               value="{{ $newsletterGuard->formTimestamp() }}">

        <input type="text" name="name" value="{{ old('name') }}" placeholder="Seu nome" required
               style="width:100%; margin-bottom:12px; padding:12px 16px; background:#0d0d14; border:1px solid rgba(99,102,241,0.25); border-radius:8px; color:#e2e8f0; font-family:'Inter', sans-serif;">

        <input type="email" name="email" value="{{ old('email') }}" placeholder="seu@email.com" required
               style="width:100%; margin-bottom:16px; padding:12px 16px; background:#0d0d14; border:1px solid rgba(99,102,241,0.25); border-radius:8px; color:#e2e8f0; font-family:'Inter', sans-serif;">

        @if (config('services.turnstile.site_key'))
            <div class="cf-turnstile" style="margin-bottom:16px;"
                 data-sitekey="{{ config('services.turnstile.site_key') }}"
                 data-theme="dark" data-language="pt-br"></div>
        @endif

        <button type="submit" class="button button-rounded"
                style="width:100%; margin:0; background:#6366f1; border-color:#6366f1; color:#fff; font-family:'Inter', sans-serif; font-weight:600;">
            Quero receber
        </button>
    </form>
</div>

@if (config('services.turnstile.site_key'))
    @push('scripts')
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    @endpush
@endif
