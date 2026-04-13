<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        try {
            if (Schema::hasColumn('pets', 'owner_id')) {
                Schema::table('pets', function ($table) {
                    $table->dropForeign(['owner_id']);
                });
            }
        } catch (\Exception $e) {}

        try {
            Schema::dropIfExists('pet_owners');
        } catch (\Exception $e) {}
        
        try {
            Schema::dropIfExists('all_tables');
        } catch (\Exception $e) {}
    }

    public function down(): void
    {
    }
};
