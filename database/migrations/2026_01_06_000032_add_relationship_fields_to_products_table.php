<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('select_category_id')->nullable();
            $table->foreign('select_category_id', 'select_category_fk_10787177')->references('id')->on('categories');
        });
    }
}
