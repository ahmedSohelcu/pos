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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();

            // 🔹 Business Info
            $table->string('name')
                ->comment('Shop/Business name');    // Shop/Business name
                
            $table->string('subdomain')
                ->unique()
                ->nullable()
                ->comment('subdomain or unique identifier');      // subdomain or unique identifier
            
            $table->string('email')
                ->unique()
                ->nullable()
                ->comment('Business email');

            $table->string('phone')
                ->nullable()
                ->comment('Business phone')
                ->index(); // ✅ add index for faster search;

            // 🔹 Address
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable()->default('BD');

            // 🔹 System Control
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('status_id')->nullable()->constrained();
            $table->integer('sorting_order')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
