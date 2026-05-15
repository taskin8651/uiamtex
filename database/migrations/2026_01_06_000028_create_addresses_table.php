<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('label');
            $table->string('line_1')->nullable();
            $table->string('line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode')->nullable();
            $table->string('country')->nullable();
            $table->string('is_default')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
