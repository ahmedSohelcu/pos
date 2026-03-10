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
        Schema::table('users', function (Blueprint $table) {            
            $table->enum('user_type',['system_admin', 'tenant_user', 'tenant_customer'])
                ->nullable()
                ->default('tenant_user')
                ->after('email_verified_at')
                ->comment('super_admin, tenant_user, tenant_customer');

            $table->foreignId('status_id')->after('user_type')->nullable()->constrained('statuses');
            $table->integer('sorting_order')->after('status_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['status_id']);
            $table->dropColumn(['status_id', 'sorting_order', 'user_type']);
        });
    }
};
