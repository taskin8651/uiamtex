<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFaqsTable extends Migration
{
    public function up()
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->unsignedBigInteger('select_category_id')->nullable();
            $table->foreign('select_category_id', 'select_category_fk_10787507')->references('id')->on('faq_categories');
        });
    }
}
