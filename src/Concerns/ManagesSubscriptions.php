<?php

namespace HelloFromSteve\Paystack\Concerns;

use HelloFromSteve\Paystack\Models\PaystackSubscription;
use HelloFromSteve\Paystack\SubscriptionBuilder;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait ManagesSubscriptions
{
    /**
     * Get the subscriptions relationship.
     */
    public function subscriptions(): MorphMany
    {
        return $this->morphMany(PaystackSubscription::class, 'billable');
    }

    /**
     * Check if currently subscribed.
     */
    public function subscribed(string $name = 'default'): bool
    {
        $subscription = $this->subscriptions()
            ->where('name', $name)
            ->first();

        return $subscription ? $subscription->active() : false;
    }

    /**
     * Fluent method to register a new subscription.
     */
    public function recordSubscription(string $name, string $plan, string $subId)
    {
        return $this->subscriptions()->create([
            'name' => $name,
            'paystack_plan' => $plan,
            'paystack_id' => $subId,
            'paystack_status' => 'active',
        ]);
    }

    /**
     * Begin creating a new subscription.
     */
    public function newSubscription(string $name, string $plan): SubscriptionBuilder
    {
        return new SubscriptionBuilder($this, $name, $plan);
    }
}
