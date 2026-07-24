<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // Cloudflare Turnstile — anti-bot opt-in do formulário público de newsletter
    // (/newsletter/subscribe). Chaves criadas em dash.cloudflare.com -> Turnstile
    // (widget "Managed"). Vazias = camada desligada (honeypot/tempo/cooldown/teto
    // diário seguem ativos). Verificação server-side no NewsletterAbuseGuard.
    'turnstile' => [
        'site_key' => env('TURNSTILE_SITE_KEY'),
        'secret_key' => env('TURNSTILE_SECRET_KEY'),
    ],

    // Matomo Analytics (self-hosted em a.blue3.cloud). O snippet
    // (resources/views/partials/matomo.blade.php) só é injetado no <head> quando
    // 'enabled' é true E 'site_id' está definido. site_id 10 = AREA81 blog.
    'matomo' => [
        'enabled' => env('MATOMO_ENABLED', false),
        'url' => env('MATOMO_URL', 'https://a.blue3.cloud/'),
        'site_id' => env('MATOMO_SITE_ID'),
        'cookie_domain' => env('MATOMO_COOKIE_DOMAIN'),
    ],

];
