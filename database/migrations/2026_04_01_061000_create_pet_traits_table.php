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
        if (Schema::hasTable('adoption_pets')) {
            if (Schema::hasColumn('adoption_pets', 'trait_1')) {
                Schema::table('adoption_pets', function (Blueprint $table) {
                    $table->dropColumn(['trait_1', 'trait_2']);
                });
            }
        }

        if (!Schema::hasTable('pet_traits')) {
            Schema::create('pet_traits', function (Blueprint $table) {
                $table->id();
                $table->foreignId('adoption_pet_id')->constrained('adoption_pets')->onDelete('cascade');
                $table->string('name');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_traits');
        
        // Add back the columns if rolled back
        Schema::table('adoption_pets', function (Blueprint $table) {
            $table->string('trait_1')->nullable();
            $table->string('trait_2')->nullable();
        });
    }
};