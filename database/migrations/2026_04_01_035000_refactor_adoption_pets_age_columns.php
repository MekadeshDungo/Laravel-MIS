<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Add new columns
        Schema::table('adoption_pets', function (Blueprint $table) {
            $table->date('date_of_birth')->nullable()->after('breed');
            $table->boolean('is_age_estimated')->default(false)->after('date_of_birth');
        });

        // Step 2: Migrate existing data from 'age' to 'date_of_birth'
        // Calculate approximate birth date: today minus (age in years)
        DB::statement("
            UPDATE adoption_pets 
            SET date_of_birth = DATE_SUB(CURDATE(), INTERVAL age YEAR),
                is_age_estimated = 1
            WHERE age IS NOT NULL
        ");

        // Step 3: Drop old columns
        Schema::table('adoption_pets', function (Blueprint $table) {
            $table->dropColumn('age');
            $table->dropColumn('estimated_age');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Step 1: Add back old columns
        Schema::table('adoption_pets', function (Blueprint $table) {
            $table->integer('age')->nullable();
            $table->string('estimated_age')->nullable();
        });

        // Step 2: Restore data from date_of_birth back to age
        // This is an approximation since we can't recover exact original values
        DB::statement("
            UPDATE adoption_pets 
            SET age = TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()),
                estimated_age = CASE 
                    WHEN is_age_estimated = 1 THEN CONCAT(TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()), ' years (estimated)')
                    ELSE CONCAT(TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()), ' years')
                END
            WHERE date_of_birth IS NOT NULL
        ");

        // Step 3: Drop new columns
        Schema::table('adoption_pets', function (Blueprint $table) {
            $table->dropColumn('date_of_birth');
            $table->dropColumn('is_age_estimated');
        });
    }
};