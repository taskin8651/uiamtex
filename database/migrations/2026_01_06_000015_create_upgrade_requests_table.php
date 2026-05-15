<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpgradeRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('upgrade_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user')->nullable();
            $table->string('current_extinguisher_type')->nullable();
            $table->string('qty')->nullable();
            $table->string('city')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->longText('message')->nullable();
            $table->string('status')->nullable();
            $table->longText('admin_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
