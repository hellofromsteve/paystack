<?php

use HelloFromSteve\Paystack\PaystackService;

if (!function_exists('paystack')) {
    /**
     * Get the Paystack service instance
     *
     * @param string|null $method
     * @param mixed ...$args
     * @return PaystackService|mixed
     */
    function paystack(?string $method = null, ...$args)
    {
        $service = app(PaystackService::class);
        
        if ($method === null) {
            return $service;
        }

        return $service->$method(...$args);
    }
}

