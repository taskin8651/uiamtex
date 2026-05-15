<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('faq_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('sort_order');
            $table->string('is_active')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
