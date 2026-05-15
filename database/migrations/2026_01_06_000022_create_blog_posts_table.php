<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostsTable extends Migration
{
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug');
            $table->longText('excerpt');
            $table->longText('content');
            $table->string('read_time');
            $table->string('published_at')->nullable();
            $table->string('is_published')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
