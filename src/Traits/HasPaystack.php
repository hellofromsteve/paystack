<?php

namespace HelloFromSteve\Paystack\Traits;

use HelloFromSteve\Paystack\Concerns\ManagesCustomer;
use HelloFromSteve\Paystack\Concerns\ManagesSubscriptions;
use HelloFromSteve\Paystack\Concerns\ManagesTransactions;

trait HasPaystack
{
    use ManagesCustomer,
        ManagesSubscriptions,
        ManagesTransactions;
}
