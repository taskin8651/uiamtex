<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDownloadsTable extends Migration
{
    public function up()
    {
        Schema::create('downloads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('description');
            $table->string('is_active')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
