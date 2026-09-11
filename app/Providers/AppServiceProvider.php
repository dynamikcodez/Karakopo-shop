<?php

namespace App\Providers;

require_once __DIR__ . '/../Helpers/helpers.php';

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Services\Payment\PaymentGatewayInterface::class,
            \App\Services\Payment\PaystackService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production') 
            || request()->header('x-forwarded-proto') === 'https' 
            || str_contains(request()->getHost() ?? '', 'vercel.app')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
