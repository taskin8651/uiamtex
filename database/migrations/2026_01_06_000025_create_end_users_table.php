<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEndUsersTable extends Migration
{
    public function up()
    {
        Schema::create('end_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('password');
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
