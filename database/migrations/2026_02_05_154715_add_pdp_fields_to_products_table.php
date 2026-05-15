<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // 1) Tags before title
            $table->json('pdp_tags')->nullable()->after('description');

            // 2) 3 pointers after short description
            // Example: ["Stored pressure type", "Electronics friendly", "Eco-safe"]
            $table->json('pdp_pointers')->nullable()->after('pdp_tags');

            // 3) Key Highlights (multiple items)
            // Example item: { "icon":"bi bi-lightning-charge", "title":"Stored pressure type", "text":"Always ready..." }
            $table->json('pdp_key_highlights')->nullable()->after('pdp_pointers');

            // 4) Works on (multiple items)
            // Example item: { "icon":"bi bi-house-door", "title":"Class-A", "text":"Solid combustibles" }
            $table->json('pdp_works_on')->nullable()->after('pdp_key_highlights');

            // 5) Recommended for (two columns lists + small meta)
            $table->json('pdp_recommended_for_left')->nullable()->after('pdp_works_on');
            $table->json('pdp_recommended_for_right')->nullable()->after('pdp_recommended_for_left');
            $table->string('pdp_available_sizes')->nullable()->after('pdp_recommended_for_right');
            $table->string('pdp_available_variants')->nullable()->after('pdp_available_sizes');

            // 6) Technical & Performance Table
            // Structure:
            // {
            //   "columns": ["WATMIST(SP)/2", "WATMIST(SP)/4", ...],
            //   "rows": [
            //     {"parameter":"Capacity", "values":["2 Ltrs.","4 Ltrs.", ...]},
            //     ...
            //   ]
            // }
            $table->json('pdp_tech_table')->nullable()->after('pdp_available_variants');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'pdp_tags',
                'pdp_pointers',
                'pdp_key_highlights',
                'pdp_works_on',
                'pdp_recommended_for_left',
                'pdp_recommended_for_right',
                'pdp_available_sizes',
                'pdp_available_variants',
                'pdp_tech_table',
            ]);
        });
    }
};
