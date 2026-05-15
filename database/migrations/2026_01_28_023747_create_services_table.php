<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('category')->nullable(); // Assessment / Supply / Maintenance...
            $table->string('title');
            $table->text('short_description')->nullable();

            $table->string('cta_label')->nullable(); // e.g. "Request an assessment"
            $table->unsignedInteger('sort_order')->default(0);

            // Using yes/no like your other modules
            $table->string('is_active')->default('yes');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
