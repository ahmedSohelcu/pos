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
        Schema::create('units', function (Blueprint $table) {
            $table->id();

            // 🔹 Tenant relation (multi-tenant)
            $table->foreignId('tenant_id')
                ->nullable() // nullable if global units
                ->constrained()
                ->cascadeOnDelete();

            // 🔹 Unit info
            $table->string('name')->comment('Full name, e.g. Kilogram, Liter');
            $table->string('short_name')->unique()->comment('Short name, e.g. kg, L, pc');

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
        Schema::dropIfExists('units');
    }
};
