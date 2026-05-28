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
        // Вместо env('APP_ENV') !== 'local' используем красивый и безопасный метод Laravel
        if (!app()->isLocal() || isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            URL::forceScheme('https');
        }
    }
}
