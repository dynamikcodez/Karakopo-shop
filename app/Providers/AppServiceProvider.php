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

        // Resilient Bcrypt hasher fallback for serverless environments
        \Illuminate\Support\Facades\Hash::extend('bcrypt', function ($app) {
            $rounds = config('hashing.bcrypt.rounds', 12);
            $rounds = (is_numeric($rounds) && (int) $rounds >= 4 && (int) $rounds <= 31) ? (int) $rounds : 12;

            return new class(['rounds' => $rounds, 'verify' => false]) extends \Illuminate\Hashing\BcryptHasher {
                public function make($value, array $options = [])
                {
                    $cost = $this->cost($options);
                    if (!is_int($cost) || $cost < 4 || $cost > 31) {
                        $options['rounds'] = 12;
                    }

                    try {
                        return parent::make($value, $options);
                    } catch (\Throwable) {
                        return password_hash($value, PASSWORD_DEFAULT);
                    }
                }

                public function needsRehash($hashedValue, array $options = [])
                {
                    return false;
                }

                public function check($value, $hashedValue, array $options = [])
                {
                    if (is_null($hashedValue) || (string) $hashedValue === '') {
                        return false;
                    }

                    try {
                        return parent::check($value, $hashedValue, $options);
                    } catch (\Throwable) {
                        return password_verify($value, $hashedValue);
                    }
                }
            };
        });
    }
}
