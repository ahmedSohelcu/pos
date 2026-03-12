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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();

            // 🔹 Relationships
            $table->foreignId('tenant_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->nullable()->constrained()->restrictOnDelete();

            // 🔹 Subscription Period
            $table->date('starts_at');
            $table->date('ends_at');

            // 🔹 Control Current Subscription
            $table->boolean('is_trial')->default(false)->comment('Is this a trial subscription?');
            $table->boolean('is_current')->default(true);
            
            // 🔹 Status (trial, active, expired, cancelled)  
            $table->foreignId('status_id')->nullable()->constrained()->restrictOnDelete();
            
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
