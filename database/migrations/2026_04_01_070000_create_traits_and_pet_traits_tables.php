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
        if (!Schema::hasTable('traits')) {
            Schema::create('traits', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('pet_traits')) {
            Schema::create('pet_traits', function (Blueprint $table) {
                $table->id();
                $table->foreignId('adoption_id')
                    ->constrained('adoption_pets')
                    ->onDelete('cascade');
                $table->foreignId('trait_id')
                    ->constrained('traits')
                    ->onDelete('cascade');
                $table->timestamps();
                
                $table->unique(['adoption_id', 'trait_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_traits');
        Schema::dropIfExists('traits');
    }
};