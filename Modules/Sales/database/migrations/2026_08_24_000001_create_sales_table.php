<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained()->cascadeOnDelete();

            $table->string('reference')->unique();

            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->comment('cashier')->constrained()->nullOnDelete();

            $table->decimal('subtotal', 12, 2)->default(0);
            $table->string('discount_type', 20)->default('fixed');
            $table->decimal('discount_value', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);

            $table->string('payment_method', 20)->default('cash');
            $table->decimal('amount_tendered', 12, 2)->default(0);
            $table->decimal('change_due', 12, 2)->default(0);

            $table->string('status', 20)->default('completed')->index();
            $table->timestamp('refunded_at')->nullable();
            $table->string('note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
