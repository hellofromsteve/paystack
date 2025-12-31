<?php


namespace HelloFromSteve\Paystack\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \HelloFromSteve\Paystack\Resources\TransactionResource transaction()
 * @method static \HelloFromSteve\Paystack\Resources\PlanResource plan()
 * @method static \HelloFromSteve\Paystack\Resources\SubscriptionResource subscription()
 * @method static \HelloFromSteve\Paystack\Resources\CustomerResource customer()
 * @method static \HelloFromSteve\Paystack\Resources\PageResource page()
 * @method static \HelloFromSteve\Paystack\Resources\ProductResource product()
 * @method static \HelloFromSteve\Paystack\Resources\PaymentRequestResource paymentRequest()
 * @method static \HelloFromSteve\Paystack\Resources\SettlementResource settlement()
 * @method static \HelloFromSteve\Paystack\Resources\TransferRecipientResource transferRecipient()
 * @method static \HelloFromSteve\Paystack\Resources\TransferResource transfer()
 * @method static \HelloFromSteve\Paystack\Resources\TransferControlResource transferControl()
 * @method static \HelloFromSteve\Paystack\Resources\ChargeResource charge()
 * @method static \HelloFromSteve\Paystack\Resources\DisputeResource dispute()
 * @method static \HelloFromSteve\Paystack\Resources\RefundResource refund()
 * @method static \HelloFromSteve\Paystack\Resources\VerificationResource verification()
 * @method static \HelloFromSteve\Paystack\Resources\MiscellaneousResource miscellaneous()
 *
 *  @see \HelloFromSteve\Paystack\PaystackService
 */
class Paystack extends Facade
{
    /**
     * Get the registered name of the component.
     * * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'paystack';
    }
}