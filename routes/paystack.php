<?php

use Illuminate\Support\Facades\Route;
use HelloFromSteve\Paystack\Http\Controllers\WebhookController;
use HelloFromSteve\Paystack\Middleware\VerifyPaystackWebhook;

Route::post(config('paystack.webhook_path', 'paystack/webhook'), [WebhookController::class, 'handleWebhook'])
    ->name('paystack.webhook')
    ->middleware(VerifyPaystackWebhook::class);
