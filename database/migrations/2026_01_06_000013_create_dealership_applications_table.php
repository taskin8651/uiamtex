<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealershipApplicationsTable extends Migration
{
    public function up()
    {
        Schema::create('dealership_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('city_state')->nullable();
            $table->string('business_type')->nullable();
            $table->string('sales_focus')->nullable();
            $table->string('experience')->nullable();
            $table->string('status')->nullable();
            $table->longText('admin_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
