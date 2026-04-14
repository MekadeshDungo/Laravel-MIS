<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pet_traits', 'pet_id')) {
            Schema::table('pet_traits', function (Blueprint $table) {
                $table->unsignedBigInteger('pet_id')->nullable()->after('id');
                $table->index('pet_id');
            });
            
            $hasAdoptionIdColumn = Schema::hasColumn('pet_traits', 'adoption_id');
            $hasAdoptionPetIdColumn = Schema::hasColumn('pet_traits', 'adoption_pet_id');
            
            if ($hasAdoptionIdColumn) {
                DB::statement('UPDATE pet_traits pt
                    INNER JOIN pets p ON p.source_module = "adoption_pets" AND p.source_module_id = pt.adoption_id
                    SET pt.pet_id = p.pet_id');
            } elseif ($hasAdoptionPetIdColumn) {
                DB::statement('UPDATE pet_traits pt
                    INNER JOIN pets p ON p.source_module = "adoption_pets" AND p.source_module_id = pt.adoption_pet_id
                    SET pt.pet_id = p.pet_id');
            }
        }
    }

    public function down(): void
    {
        Schema::table('pet_traits', function (Blueprint $table) {
            $table->dropColumn('pet_id');
        });
    }
};