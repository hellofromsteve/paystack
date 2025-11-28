<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Paystack Secret Key
    |--------------------------------------------------------------------------
    |
    | Your Paystack secret key. You can get this from your Paystack dashboard.
    |
    */
    'secret' => env('PAYSTACK_SECRET_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Paystack Public Key
    |--------------------------------------------------------------------------
    |
    | Your Paystack public key. You can get this from your Paystack dashboard.
    |
    */
    'public' => env('PAYSTACK_PUBLIC_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Paystack API URL
    |--------------------------------------------------------------------------
    |
    | The base URL for the Paystack API. Defaults to the production URL.
    |
    */
    'url' => env('PAYSTACK_URL', 'https://api.paystack.co'),
];

