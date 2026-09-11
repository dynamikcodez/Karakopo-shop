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
        //
    }
}
