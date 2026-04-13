<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        try {
            Schema::table('impounds', function (Blueprint $table) {
                $table->renameColumn('animal_id', 'pet_id');
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('impounds', function (Blueprint $table) {
                $table->foreign('pet_id')->references('pet_id')->on('pets')->onDelete('cascade');
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('medical_records', function (Blueprint $table) {
                $table->renameColumn('animal_id', 'pet_id');
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('medical_records', function (Blueprint $table) {
                $table->foreign('pet_id')->references('pet_id')->on('pets')->onDelete('set null');
            });
        } catch (\Exception $e) {}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->dropForeign(['pet_id']);
        });

        Schema::table('medical_records', function (Blueprint $table) {
            $table->renameColumn('pet_id', 'animal_id');
        });

        Schema::table('impounds', function (Blueprint $table) {
            $table->dropForeign(['pet_id']);
        });

        Schema::table('impounds', function (Blueprint $table) {
            $table->renameColumn('pet_id', 'animal_id');
        });
    }
};
