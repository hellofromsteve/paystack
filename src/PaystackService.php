<?php

namespace HelloFromSteve\Paystack;

use Illuminate\Support\Facades\Http;

class PaystackService
{
    protected string $baseUrl;
    protected string $secret;

    public function __construct()
    {
        $this->secret = config('paystack.secret');
        $this->baseUrl = config('paystack.url', 'https://api.paystack.co');
    }

    protected function request()
    {
        return Http::withToken($this->secret)
            ->acceptJson()
            ->timeout(45);
    }

    /**
     * Get all plans
     */
    public function getPlans(): array
    {
        return $this->request()->get("$this->baseUrl/plan")->json();
    }

    /**
     * Create a new plan
     */
    public function createPlan(array $payload): array
    {
        return $this->request()->post("$this->baseUrl/plan", $payload)->json();
    }

    /**
     * Get all transactions
     */
    public function getTransactions(): array
    {
        return $this->request()->get("$this->baseUrl/transaction")->json();
    }

    /**
     * Initialize a transaction
     */
    public function initializeTransaction(array $payload): array
    {
        return $this->request()->post("$this->baseUrl/transaction/initialize", $payload)->json();
    }

    /**
     * Verify a transaction
     */
    public function verifyTransaction(string $reference): array
    {
        return $this->request()->get("$this->baseUrl/transaction/verify/$reference")->json();
    }

    /**
     * Create customer
     */
    public function createCustomer(array $payload): array
    {
        return $this->request()->post("$this->baseUrl/customer", $payload)->json();
    }

    /**
     * Charge authorization
     */
    public function chargeAuthorization(array $payload): array
    {
        return $this->request()->post("$this->baseUrl/transaction/charge_authorization", $payload)->json();
    }

    /**
     * Subscribe customer to a plan
     */
    public function createSubscription(array $payload): array
    {
        return $this->request()->post("$this->baseUrl/subscription", $payload)->json();
    }
}

