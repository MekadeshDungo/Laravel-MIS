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
        // Use raw SQL for MariaDB/MySQL compatibility to rename the column
        DB::statement('ALTER TABLE adoption_pets CHANGE id adoption_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
        
        // Then, drop the traits column
        Schema::table('adoption_pets', function (Blueprint $table) {
            $table->dropColumn('traits');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back the traits column
        Schema::table('adoption_pets', function (Blueprint $table) {
            $table->text('traits')->nullable()->after('description');
        });

        // Rename adoption_id back to id
        DB::statement('ALTER TABLE adoption_pets CHANGE adoption_id id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
    }
};