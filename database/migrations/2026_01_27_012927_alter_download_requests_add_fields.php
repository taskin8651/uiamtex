<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('download_requests', function (Blueprint $table) {
            // If you already have 'download' string column, keep it for now (optional),
            // but we will add proper download_id.
            if (!Schema::hasColumn('download_requests', 'download_id')) {
                $table->unsignedBigInteger('download_id')->nullable()->after('id');
            }

            if (!Schema::hasColumn('download_requests', 'city')) {
                $table->string('city')->nullable()->after('phone');
            }

            if (!Schema::hasColumn('download_requests', 'purpose')) {
                $table->string('purpose')->nullable()->after('city');
            }

            if (!Schema::hasColumn('download_requests', 'message')) {
                $table->text('message')->nullable()->after('purpose');
            }

            // Make sure email/company exist (your model has them)
            if (!Schema::hasColumn('download_requests', 'email')) {
                $table->string('email')->nullable()->after('name');
            }
            if (!Schema::hasColumn('download_requests', 'company')) {
                $table->string('company')->nullable()->after('email');
            }
        });
    }

    public function down(): void
    {
        Schema::table('download_requests', function (Blueprint $table) {
            $drop = [];
            foreach (['download_id','city','purpose','message','email','company'] as $col) {
                if (Schema::hasColumn('download_requests', $col)) $drop[] = $col;
            }
            if (!empty($drop)) $table->dropColumn($drop);
        });
    }
};
