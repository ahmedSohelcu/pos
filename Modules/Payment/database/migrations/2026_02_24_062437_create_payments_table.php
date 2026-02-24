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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // 🔹 Relations
            $table->foreignId('tenant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('subscription_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('plan_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // 🔹 Snapshot
            $table->string('plan_name')->comment('for keeping history');
            $table->decimal('plan_price', 10, 2)->comment('for keeping history');

            // 🔹 Payment Info
            $table->string('gateway')->comment('bkash, nagad, bank'); // bkash, nagad, bank

            $table->string('transaction_id')
                ->nullable()
                ->index()
                ->comment('returned by gateway');

            $table->string('invoice_no')->unique()->comment('auto generated unique invoice number');

            $table->decimal('amount', 10, 2);

            $table->string('currency')->default('BDT');

            // 🔹 Status
            $table->enum('status', [
                'pending',
                'paid',
                'failed',
                'cancelled',
                'refunded'
            ])->default('pending');

            $table->json('gateway_response')->nullable();

            $table->timestamp('paid_at')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
