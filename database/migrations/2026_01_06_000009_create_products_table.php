<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->longText('short_desc');
            $table->longText('description');
            $table->string('base_price');
            $table->string('compare_price');
            $table->string('badge');
            $table->string('dispatch_text');
            $table->string('rating_avg')->nullable();
            $table->string('rating_count')->nullable();
            $table->string('sku')->nullable();
            $table->string('is_featured');
            $table->string('is_active');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
