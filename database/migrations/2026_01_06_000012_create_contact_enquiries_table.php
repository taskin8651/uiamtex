<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactEnquiriesTable extends Migration
{
    public function up()
    {
        Schema::create('contact_enquiries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('enquiry_type');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->longText('message');
            $table->string('status')->nullable();
            $table->longText('admin_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
