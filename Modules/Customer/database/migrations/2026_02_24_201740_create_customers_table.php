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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();            

            // 🔹 Customer info
            $table->string('name')->comment('Customer full name');
            $table->string('email')->nullable()->comment('Customer email');
            $table->string('phone')->nullable()->index()->comment('Customer phone number');
            $table->string('company')->nullable()->comment('Company name');
            $table->string('profile_pic')
                ->nullable()
                ->comment('Customer profile picture path or URL');

                // 🔹 Tenant relation (multi-tenant)
            $table->foreignId('tenant_id')
                ->nullable() // nullable if global customers
                ->constrained()
                ->cascadeOnDelete();            

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete()
                ->comment('Which tenant user created this customer');

            // 🔹 Address
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable()->default('BD');
            $table->string('zip_code')->nullable();    

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
        Schema::dropIfExists('customers');
    }
};
