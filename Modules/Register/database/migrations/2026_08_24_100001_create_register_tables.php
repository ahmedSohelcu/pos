<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('register_shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->comment('opened by')->constrained()->nullOnDelete();

            $table->string('register_name', 60)->default('Main Register');
            $table->decimal('opening_float', 12, 2)->default(0);
            $table->decimal('closing_counted', 12, 2)->nullable();
            $table->decimal('expected_cash', 12, 2)->nullable();
            $table->decimal('difference', 12, 2)->nullable();

            $table->string('status', 20)->default('open')->index(); // open|closed
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->string('note')->nullable();

            $table->timestamps();
        });

        Schema::create('register_cash_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('shift_id')->constrained('register_shifts')->cascadeOnDelete();

            $table->string('type', 20); // cash_in | cash_out
            $table->decimal('amount', 12, 2);
            $table->string('reason')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('register_cash_movements');
        Schema::dropIfExists('register_shifts');
    }
};
