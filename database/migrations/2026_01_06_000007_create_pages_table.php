<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug');
            $table->longText('content');
            $table->string('seo_title');
            $table->longText('seo_description')->nullable();
            $table->string('is_active');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
