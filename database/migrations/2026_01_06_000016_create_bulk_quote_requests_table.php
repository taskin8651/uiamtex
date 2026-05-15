<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBulkQuoteRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('bulk_quote_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product')->nullable();
            $table->string('variant')->nullable();
            $table->string('qty')->nullable();
            $table->string('company_name')->nullable();
            $table->string('city')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->longText('notes')->nullable();
            $table->string('status')->nullable();
            $table->longText('admin_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
