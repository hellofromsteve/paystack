<?php

namespace HelloFromSteve\Paystack;

use Illuminate\Support\ServiceProvider;

class PaystackServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/paystack.php',
            'paystack'
        );

        $this->app->singleton(PaystackService::class, function ($app) {
            return new PaystackService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/paystack.php' => config_path('paystack.php'),
        ], 'paystack-config');
    }
}

