<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained()->cascadeOnDelete();

            $table->foreignId('product_variant_id')->constrained()->cascadeOnDelete();

            $table->string('type', 20)->index(); // purchase|sale|adjustment|return|damage|opening
            $table->decimal('quantity', 12, 2); // signed delta
            $table->decimal('stock_before', 12, 2);
            $table->decimal('stock_after', 12, 2);

            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
