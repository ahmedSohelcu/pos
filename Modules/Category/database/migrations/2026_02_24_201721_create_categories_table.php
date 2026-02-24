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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            // 🔹 Category info
            $table->string('name')->unique()->comment('Category name');
            $table->string('slug')->unique()->comment('URL slug or unique key');

            // ✅ Unique per tenant
            $table->unique(['tenant_id', 'name']);
            $table->unique(['tenant_id', 'slug']);

            
            $table->text('description')->nullable();

            // 🔹 Optional parent category (for subcategories)
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('categories')
                ->cascadeOnDelete();

            // 🔹 Tenant relation (multi-tenant)
            $table->foreignId('tenant_id')
                ->nullable() // nullable if some global categories
                ->constrained()
                ->cascadeOnDelete();

            // 🔹 System control
            $table->foreignId('status_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('sorting_order')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
