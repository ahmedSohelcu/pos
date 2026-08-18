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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            // Multi tenant
            $table->foreignId('tenant_id')->nullable()->constrained()->cascadeOnDelete();            
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            $table->string('name')->nullable()->comment('Red / 500ml / XL');

            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();

            $table->decimal('purchase_price',12,2)->nullable()->comment('purchase price with other coast');
            $table->decimal('sale_price',12,2);

            $table->decimal('stock',12,2)->default(0);

            // 🔹 System control
            $table->foreignId('status_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            $table->string('thumbnail')->nullable()
                ->comment('thumbnail image url');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
