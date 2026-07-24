<?php

// Anti-abuso do formulário público de inscrição na newsletter (/newsletter/subscribe).
// Contexto: o endpoint dispara um e-mail de confirmação (double opt-in) para
// QUALQUER endereço. Sem travas por endereço um bot usa o formulário para
// bombardear caixas de terceiros e estourar a cota do provedor de SMTP (list
// bombing). As barreiras são aplicadas pelo App\Services\Newsletter\NewsletterAbuseGuard.
return [

    // Teto GLOBAL de e-mails de confirmação por dia (kill-switch). Atingido o teto,
    // novas inscrições recebem a tela de sucesso normal mas nada é enviado; o
    // fato é logado como critical e avisado por e-mail (se alert_email definido).
    'daily_cap' => (int) env('NEWSLETTER_DAILY_CAP', 50),

    // E-mail avisado (no máx. 1x/dia) quando o teto diário é atingido. Vazio = só log.
    'alert_email' => env('NEWSLETTER_ALERT_EMAIL'),

    // Tempo mínimo (s) entre o render do formulário e o submit — humano não
    // preenche e envia em menos que isso.
    'min_seconds' => 3,

    // Idade máxima (s) do formulário no submit — limita replay do timestamp.
    'max_form_age' => 21600,

    // Cooldown por ENDEREÇO de destino: no máx. 1 envio a cada 15 min e 3 por dia.
    // É a defesa central contra list bombing (o bot troca de IP; o alvo não).
    'cooldown_15min' => 1,
    'cooldown_day' => 3,

    // Domínios de e-mail descartáveis (match exato ou por sufixo).
    'disposable_domains' => [
        'immenseignite.info',
        '123mails.org',
        'mailinator.com',
        'yopmail.com',
        'guerrillamail.com',
        'guerrillamailblock.com',
        'sharklasers.com',
        'grr.la',
        'spam4.me',
        'pokemail.net',
        '10minutemail.com',
        'temp-mail.org',
        'temp-mail.io',
        'tempmail.com',
        'tempail.com',
        'tempmailo.com',
        'mytemp.email',
        'tempinbox.com',
        'tempr.email',
        'trashmail.com',
        'trash-mail.com',
        'getnada.com',
        'dispostable.com',
        'maildrop.cc',
        'mintemail.com',
        'throwawaymail.com',
        'fakeinbox.com',
        'mohmal.com',
        'moakt.com',
        'emailondeck.com',
        'discard.email',
        'mailnesia.com',
        'mailcatch.com',
        'harakirimail.com',
        '33mail.com',
        'mailsac.com',
        '1secmail.com',
        'emlhub.com',
        'emltmp.com',
        'mail-temp.com',
        'burnermail.io',
        'inboxkitten.com',
    ],
];
