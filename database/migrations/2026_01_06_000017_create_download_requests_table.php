<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDownloadRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('download_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('download')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('company')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
