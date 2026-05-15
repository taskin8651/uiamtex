<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('work_gallery_images', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('work_gallery_id');
            $table->string('image'); // uploads/work-gallery/xxx.jpg
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('work_gallery_id')->references('id')->on('work_galleries')->cascadeOnDelete();
            $table->index(['work_gallery_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_gallery_images');
    }
};
