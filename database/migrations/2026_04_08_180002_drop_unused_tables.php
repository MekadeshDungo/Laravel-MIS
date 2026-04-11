<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        if (Schema::hasColumn('pets', 'owner_id')) {
            Schema::table('pets', function ($table) {
                $table->dropForeign(['owner_id']);
            });
        }

        Schema::dropIfExists('pet_owners');
        Schema::dropIfExists('all_tables');

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down(): void
    {
    }
};
