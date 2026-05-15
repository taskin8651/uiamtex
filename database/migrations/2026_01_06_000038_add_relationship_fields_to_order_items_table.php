<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToOrderItemsTable extends Migration
{
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id', 'order_fk_10787540')->references('id')->on('orders');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id', 'product_fk_10787541')->references('id')->on('products');
            $table->unsignedBigInteger('variant_id')->nullable();
            $table->foreign('variant_id', 'variant_fk_10787542')->references('id')->on('product_variants');
        });
    }
}
