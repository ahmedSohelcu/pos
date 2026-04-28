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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();

            // 🔹 Tenant relation (multi-tenant)
            $table->foreignId('tenant_id')
                ->nullable() // nullable if you want global brands
                ->constrained()
                ->cascadeOnDelete();

            // 🔹 Brand info
            $table->string('name')->unique()->comment('Brand name');
            $table->string('slug')->unique()->comment('Brand slug or unique key');

            $table->unique(['tenant_id', 'name']);
            $table->unique(['tenant_id', 'slug']);

            
            $table->text('description')->nullable();
            $table->string('logo')->nullable()->comment('Brand logo image path');

            // 🔹 System control
            $table->foreignId('status_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete()->comment('for later uses');
                
            $table->boolean('is_active')->nullable()->default(true);

            $table->integer('sorting_order')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
