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
        Schema::create('expenses', function (Blueprint $table) {
             $table->id();

            // 🔹 Tenant (for SaaS)
            $table->foreignId('tenant_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            // 🔹 Category
            $table->foreignId('expense_category_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            // 🔹 Expense info
            $table->decimal('amount', 12, 2)->nullable();
            $table->date('expense_date')->nullable();;

            $table->string('reference')->nullable()->comment('Invoice or reference number');

            $table->text('note')->nullable();

            // 🔹 Payment method (optional)
            // $table->foreignId('payment_method_id')
            //     ->nullable()
            //     ->constrained()
            //     ->nullOnDelete();

            // 🔹 Attachment (receipt image/pdf)
            $table->string('attachment')->nullable();

            // 🔹 Status
            // 'pending','approved','rejected','draft'
            $table->foreignId('status_id')
                ->nullable()
                ->constrained('statuses')
                ->nullOnDelete();

            // 🔹 User tracking
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->integer('sorting_order')->nullable()->default(0);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
