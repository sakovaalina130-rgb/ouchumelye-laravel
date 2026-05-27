<?php

namespace App\Providers;

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
        // Если среда не локальная (или если это Codespaces), форсируем HTTPS
        if (env('APP_ENV') !== 'local' || isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            URL::forceScheme('https');
        }
    }
}
