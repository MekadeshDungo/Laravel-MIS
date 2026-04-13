<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('clinical_actions', function (Blueprint $table) {
            $table->renameColumn('animal_id', 'pet_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinical_actions', function (Blueprint $table) {
            $table->renameColumn('pet_id', 'animal_id');
        });
    }
};
