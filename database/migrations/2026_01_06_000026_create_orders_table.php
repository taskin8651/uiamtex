<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_no');
            $table->string('status')->nullable();
            $table->string('subtotal');
            $table->string('shipping');
            $table->string('tax');
            $table->string('total');
            $table->string('payment_status')->nullable();
            $table->string('payment_gateway')->nullable();
            $table->string('txn')->nullable();
            $table->string('address_snapshot')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
