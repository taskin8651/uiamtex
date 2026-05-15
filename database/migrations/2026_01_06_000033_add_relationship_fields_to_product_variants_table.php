<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToProductVariantsTable extends Migration
{
    public function up()
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->unsignedBigInteger('select_product_id')->nullable();
            $table->foreign('select_product_id', 'select_product_fk_10787261')->references('id')->on('products');
        });
    }
}
