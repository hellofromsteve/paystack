<?php

namespace HelloFromSteve\Paystack\Concerns;

use HelloFromSteve\Paystack\Models\PaystackTransaction;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait ManagesTransactions
{
    /**
     * Get the transactions relationship.
     */
    public function paystackTransactions(): MorphMany
    {
        return $this->morphMany(PaystackTransaction::class, 'billable');
    }
}
