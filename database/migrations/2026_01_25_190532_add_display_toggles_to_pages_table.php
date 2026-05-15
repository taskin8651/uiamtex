<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->boolean('show_in_navbar')->default(false)->after('is_active');
            $table->boolean('show_in_footer')->default(false)->after('show_in_navbar');
            $table->boolean('show_in_footer_bottom')->default(false)->after('show_in_footer');

            $table->index(['is_active', 'show_in_navbar']);
            $table->index(['is_active', 'show_in_footer']);
            $table->index(['is_active', 'show_in_footer_bottom']);
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'show_in_navbar']);
            $table->dropIndex(['is_active', 'show_in_footer']);
            $table->dropIndex(['is_active', 'show_in_footer_bottom']);

            $table->dropColumn(['show_in_navbar', 'show_in_footer', 'show_in_footer_bottom']);
        });
    }
};
