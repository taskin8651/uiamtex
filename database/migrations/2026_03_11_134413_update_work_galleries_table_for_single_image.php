<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_galleries', function (Blueprint $table) {
            if (!Schema::hasColumn('work_galleries', 'image')) {
                $table->string('image')->nullable()->after('title');
            }
        });

        Schema::table('work_galleries', function (Blueprint $table) {
            if (Schema::hasColumn('work_galleries', 'industry_id')) {
                $table->dropForeign(['industry_id']);
                $table->dropColumn('industry_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('work_galleries', function (Blueprint $table) {
            if (!Schema::hasColumn('work_galleries', 'industry_id')) {
                $table->unsignedBigInteger('industry_id')->nullable()->after('title');
            }

            if (Schema::hasColumn('work_galleries', 'image')) {
                $table->dropColumn('image');
            }
        });

        Schema::table('work_galleries', function (Blueprint $table) {
            if (Schema::hasColumn('work_galleries', 'industry_id')) {
                $table->foreign('industry_id')->references('id')->on('industries')->onDelete('set null');
            }
        });
    }
};