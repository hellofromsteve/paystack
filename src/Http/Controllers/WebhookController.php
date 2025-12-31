<?php

namespace HelloFromSteve\Paystack\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use HelloFromSteve\Paystack\Events\WebhookReceived;
use HelloFromSteve\Paystack\Events\WebhookHandled;
use HelloFromSteve\Paystack\Events\PaymentSuccess;
use HelloFromSteve\Paystack\Events\SubscriptionCreated;
use HelloFromSteve\Paystack\Events\SubscriptionUpdated;
use HelloFromSteve\Paystack\Events\InvoiceCreated;
use HelloFromSteve\Paystack\Events\InvoiceUpdated;
use HelloFromSteve\Paystack\Events\InvoicePaymentFailed;
use HelloFromSteve\Paystack\Events\ChargeDisputeCreated;
use HelloFromSteve\Paystack\Events\TransferSuccess;
use HelloFromSteve\Paystack\Events\TransferFailed;
use HelloFromSteve\Paystack\Models\PaystackSubscription;

class WebhookController extends Controller
{
    /**
     * Handle a Paystack webhook call.
     *
     * @param Request $request
     * @return Response
     */
    public function handleWebhook(Request $request)
    {
        $payload = $request->all();
        $event = $payload['event'] ?? null;

        WebhookReceived::dispatch($payload);

        if ($event) {
            $method = 'handle' . Str::studly(str_replace('.', '_', $event));

            if (method_exists($this, $method)) {
                $this->{$method}($payload);
                
                WebhookHandled::dispatch($payload);
                
                return new Response('Webhook Handled', 200);
            }
        }

        return new Response('Webhook Received', 200);
    }

    /**
     * Handle a successful charge.
     *
     * @param  array  $payload
     * @return void
     */
    protected function handleChargeSuccess(array $payload)
    {
        PaymentSuccess::dispatch($payload);
    }

    /**
     * Handle a subscription creation.
     *
     * @param  array  $payload
     * @return void
     */
    protected function handleSubscriptionCreate(array $payload)
    {
        // We might want to update the subscription status if it exists but is pending
        $data = $payload['data'];
        $subscription = PaystackSubscription::query()->where('paystack_id', $data['subscription_code'])->first();

        if ($subscription) {
            $subscription->update([
                'paystack_status' => $data['status'],
            ]);
        }

        SubscriptionCreated::dispatch($payload);
    }

    /**
     * Handle a subscription disable event.
     *
     * @param  array  $payload
     * @return void
     */
    protected function handleSubscriptionDisable(array $payload)
    {
        $data = $payload['data'];
        $subscription = PaystackSubscription::query()->where('paystack_id', $data['subscription_code'])->first();

        if ($subscription) {
            // If disabled, it's effectively cancelled immediately or at the end of the period?
            // Usually "disabled" in Paystack means it's done.
            if (is_null($subscription->ends_at)) {
                $subscription->update([
                    'paystack_status' => 'disabled',
                    'ends_at' => now(),
                ]);
            }
        }

        SubscriptionUpdated::dispatch($payload);
    }

    /**
     * Handle a subscription not renewing event.
     *
     * @param  array  $payload
     * @return void
     */
    protected function handleSubscriptionNotRenew(array $payload)
    {
        $data = $payload['data'];
        $subscription = PaystackSubscription::query()->where('paystack_id', $data['subscription_code'])->first();

        if ($subscription) {
            $subscription->update([
                'paystack_status' => 'non-renewing',
            ]);
        }

        SubscriptionUpdated::dispatch($payload);
    }

    /**
     * Handle an invoice creation event.
     *
     * @param  array  $payload
     * @return void
     */
    protected function handleInvoiceCreate(array $payload)
    {
        InvoiceCreated::dispatch($payload);
    }

    /**
     * Handle an invoice update event.
     *
     * @param  array  $payload
     * @return void
     */
    protected function handleInvoiceUpdate(array $payload)
    {
        InvoiceUpdated::dispatch($payload);
    }

    /**
     * Handle an invoice payment failure event.
     *
     * @param  array  $payload
     * @return void
     */
    protected function handleInvoicePaymentFailed(array $payload)
    {
        InvoicePaymentFailed::dispatch($payload);
    }

    /**
     * Handle a charge dispute creation event.
     *
     * @param  array  $payload
     * @return void
     */
    protected function handleChargeDisputeCreate(array $payload)
    {
        ChargeDisputeCreated::dispatch($payload);
    }

    /**
     * Handle a transfer success event.
     *
     * @param  array  $payload
     * @return void
     */
    protected function handleTransferSuccess(array $payload)
    {
        TransferSuccess::dispatch($payload);
    }

    /**
     * Handle a transfer failure event.
     *
     * @param  array  $payload
     * @return void
     */
    protected function handleTransferFailed(array $payload)
    {
        TransferFailed::dispatch($payload);
    }
}
