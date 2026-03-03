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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();

            // 📦 Basic Info
            $table->string('name');
            $table->string('slug')->unique();

            // 💰 Pricing
            $table->decimal('price', 10, 2);
            $table->string('currency')->default('BDT');

            // 🔁 Billing Logic
            $table->enum('billing_interval', ['month', 'year'])->comment('month, year');
            $table->integer('billing_duration')->default(1)->comment('number of billing intervals');            

            $table->integer('trial_days')->default(0);

            // 📊 Usage Limits
            $table->integer('max_users')->nullable();
            $table->integer('max_products')->nullable();
            $table->integer('max_branches')->nullable();

            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            
            $table->integer('sorting_order')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
