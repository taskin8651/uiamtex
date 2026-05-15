<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToWishlistsTable extends Migration
{
    public function up()
    {
        Schema::table('wishlists', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_10787563')->references('id')->on('end_users');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id', 'product_fk_10787564')->references('id')->on('products');
        });
    }
}
