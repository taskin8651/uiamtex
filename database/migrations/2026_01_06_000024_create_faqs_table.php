<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqsTable extends Migration
{
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('question');
            $table->longText('answer');
            $table->string('sort_order');
            $table->string('is_active')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
