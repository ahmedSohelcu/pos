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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            
            // polymorphic relation
            $table->morphs('mediable');

            // file info
            $table->string('file')->comment('file path ex: products/abc.jpg');

            // storage disk
            $table->string('disk')->default('public')->comment('directory name');

            // thumbnail / gallery / avatar etc
            $table->string('collection')->nullable()->comment('Ex: avatar, gallery, thumbnail, banner etc');

            // image / video / pdf
            $table->string('type')->nullable()->comment('Ex: image, video, pdf, audio etc');
            $table->string('mime_type')->nullable()->comment('Ex: image/jpeg, video/mp4, audio/mpeg, application/pdf etc');

            // optional sorting
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
