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
            $table->string('name')->unique(); // Brand name
            $table->string('slug')->unique()->nullable(); // Optional slug
            $table->text('description')->nullable(); // Optional description

            // unsignedInteger will never be negative and also helps to prevent SQL injection attacks
            $table->unsignedInteger('sort_order')->default(0); // sorting order

            // $table->unsignedBigInteger('status_id')->default(1); // active/inactive etc
            // $table->unsignedBigInteger('tenant_id')->nullable(); // for multi-tenan

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
