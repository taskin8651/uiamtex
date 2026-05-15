<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('work_galleries', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('title');
            $table->unsignedBigInteger('industry_id')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('is_active')->default('yes');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('industry_id')->references('id')->on('industries')->nullOnDelete();
            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_galleries');
    }
};
