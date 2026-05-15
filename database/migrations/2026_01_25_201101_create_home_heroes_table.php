<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('home_heroes', function (Blueprint $table) {
            $table->id();

            $table->string('badge_icon')->nullable();      // e.g. bi bi-shield-check
            $table->string('badge_text')->nullable();      // e.g. Fire Safety Awareness

            $table->string('title_line_1')->nullable();    // e.g. Introducing
            $table->string('title_highlight')->nullable(); // e.g. Water Mist Fire Extinguishers
            $table->text('subtitle')->nullable();

            $table->string('cta_text')->nullable();        // e.g. Know More
            $table->string('cta_url')->nullable();         // e.g. /products
            $table->string('meta_text')->nullable();       // e.g. Class A, B, C...

            $table->string('desktop_image')->nullable();
            $table->string('mobile_image')->nullable();

            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_heroes');
    }
};
