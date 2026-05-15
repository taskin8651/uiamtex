<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('qty');
            $table->string('price');
            $table->string('meta_snapshot')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
