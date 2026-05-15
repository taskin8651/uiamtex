<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantsTable extends Migration
{
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('capacity_label');
            $table->string('finish_label');
            $table->string('sku');
            $table->string('price');
            $table->string('compare_price');
            $table->string('stock_qty');
            $table->string('is_default');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
