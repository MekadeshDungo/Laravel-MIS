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
        Schema::table('adoption_pets', function (Blueprint $table) {
            $table->string('trait_1')->nullable()->after('traits');
            $table->string('trait_2')->nullable()->after('trait_1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adoption_pets', function (Blueprint $table) {
            $table->dropColumn(['trait_1', 'trait_2']);
        });
    }
};