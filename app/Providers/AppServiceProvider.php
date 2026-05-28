<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider; // <-- Вот эта строка решает проблему

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
        // Безопасное включение HTTPS для Codespaces через проверку прокси-заголовка
        if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            URL::forceScheme('https');
        }
    }
}
