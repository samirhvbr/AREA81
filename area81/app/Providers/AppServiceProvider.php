<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureRateLimiters();
    }

    /**
     * Buckets de rate limit nomeados (usados via middleware `throttle:<nome>`).
     */
    private function configureRateLimiters(): void
    {
        // Inscrição pública na newsletter (/newsletter/subscribe): 5/min E 20/dia
        // por IP — resposta ao list bombing. O cooldown por ENDEREÇO de destino
        // fica no NewsletterAbuseGuard (o bot troca de IP; o alvo não).
        RateLimiter::for('newsletter', function (Request $request) {
            return [
                Limit::perMinute(5)->by('newsletter-m:'.$request->ip()),
                Limit::perDay(20)->by('newsletter-d:'.$request->ip()),
            ];
        });
    }
}
