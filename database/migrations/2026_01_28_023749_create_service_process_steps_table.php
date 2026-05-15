<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('service_process_steps', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedTinyInteger('step_no')->default(1); // 1..4
            $table->string('title');
            $table->text('description')->nullable();

            $table->unsignedInteger('sort_order')->default(0);
            $table->string('is_active')->default('yes');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_process_steps');
    }
};
