<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('logo')->nullable()->after('youtube');
            $table->string('favicon')->nullable()->after('logo');
        });
    }

    public function down()
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['logo', 'favicon']);
        });
    }
};
