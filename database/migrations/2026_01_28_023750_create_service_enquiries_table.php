<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('service_enquiries', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('premises_type')->nullable();      // Apartment / Office / Factory...
            $table->string('service_required')->nullable();   // AMC / Installation / Training...
            $table->string('name');
            $table->string('phone', 30);
            $table->string('email')->nullable();
            $table->string('city')->nullable();
            $table->text('message')->nullable();

            $table->string('status')->default('new'); // new/contacted/closed

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_enquiries');
    }
};
