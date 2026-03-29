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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tenant_id')
                ->nullable() // nullable if you want global brands
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name', 100)->comment('Attribute name: Size, Color etc');
            $table->string('slug', 100)->comment('Attribute unique slug');

            $table->unique(['tenant_id', 'name'], 'uniq_tenant_attribute_name');
            $table->unique(['tenant_id', 'slug'], 'uniq_tenant_attribute_slug');               

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade');

            $table->integer('sorting_order')->nullable();

            $table->boolean('is_active')->nullable()->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
