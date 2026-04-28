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
        Schema::create('products', function (Blueprint $table) {
            $table->id();            

            // Basic info
            $table->string('name');
            $table->string('slug');

            // Product type (simple, variant, service)
            $table->enum('product_type', ['single', 'variant', 'service'])->default('single');

            // Multi tenant
            $table->foreignId('tenant_id')->nullable()->constrained()->cascadeOnDelete();

            // Relations
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();

            // Unit
            $table->foreignId('unit_id')->nullable()->constrained()->nullOnDelete();

            // Barcode / SKU
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();

            // Pricing
            $table->decimal('cost_price', 12, 2)->nullable()->comment('Purchase price with other costs');
            $table->decimal('selling_price', 12, 2)->nullable();

            // Stock
            $table->boolean('track_stock')->default(true);
            $table->decimal('alert_quantity', 12, 2)->nullable();

            // Extra
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();

            // System control
            $table->foreignId('status_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete()->comment('for later uses');

            $table->boolean('is_active')->nullable()->default(true);

            // Sorting
            $table->integer('sorting_order')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            // Unique per tenant
            $table->unique(['tenant_id','slug']);
            $table->unique(['tenant_id','sku']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
