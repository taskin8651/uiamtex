<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('service_features', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('service_id');
            $table->string('feature_text');
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('cascade');

            $table->index(['service_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_features');
    }
};
