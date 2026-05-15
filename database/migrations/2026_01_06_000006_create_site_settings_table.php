<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('site_name');
            $table->string('phone');
            $table->string('email');
            $table->longText('address');
            $table->string('whatsapp')->nullable();
            $table->longText('footer_about');
            $table->longText('map_embed')->nullable();
            $table->longText('facebook_url')->nullable();
            $table->longText('instagram_url')->nullable();
            $table->longText('linkedin')->nullable();
            $table->longText('youtube')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
