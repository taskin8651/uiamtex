<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificationsTable extends Migration
{
    public function up()
    {
        Schema::create('certifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('sort_order');
            $table->string('is_active')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
