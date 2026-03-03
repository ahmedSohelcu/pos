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
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            $table->string('code')->nullable()->unique(); // optional customer code

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
    
            $table->decimal('opening_balance', 15, 2)
                ->default(0);

            $table->decimal('current_balance', 15, 2)
                ->default(0);
                
            $table->integer('loyalty_points')->default(0);
            $table->boolean('is_walkin')->default(false);
    
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
