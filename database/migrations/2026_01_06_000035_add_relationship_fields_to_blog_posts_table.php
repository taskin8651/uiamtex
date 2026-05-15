<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBlogPostsTable extends Migration
{
    public function up()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->unsignedBigInteger('select_category_id')->nullable();
            $table->foreign('select_category_id', 'select_category_fk_10787487')->references('id')->on('blog_categories');
        });
    }
}
