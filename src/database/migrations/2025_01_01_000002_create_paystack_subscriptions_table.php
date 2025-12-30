<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paystack_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->morphs('billable');
            $table->string('name');
            $table->string('paystack_id')->unique();
            $table->string('paystack_status');
            $table->string('paystack_plan')->nullable();
            $table->integer('quantity')->default(1);
            $table->string('email_token')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paystack_subscriptions');
    }
};