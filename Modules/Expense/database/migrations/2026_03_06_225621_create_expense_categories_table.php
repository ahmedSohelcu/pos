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
        Schema::create('expense_categories', function (Blueprint $table) {
            $table->id();
            // 🔹 Tenant (for SaaS)
            $table->foreignId('tenant_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            // 🔹 Category Info
            $table->string('name')->comment('Category name');
            $table->string('slug')->comment('URL friendly slug');

            // Unique per tenant
            $table->unique(['tenant_id', 'name']);
            $table->unique(['tenant_id', 'slug']);

            $table->text('description')->nullable();

            // 🔹 Parent category (subcategory support)
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('expense_categories')
                ->cascadeOnDelete();

            // 🔹 System tracking
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            
            $table->string('icon')->nullable();
            // 🔹 Status
            $table->boolean('is_active')->default(true);

            // 🔹 Sorting order
            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_categories');
    }
};
