<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('traits', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('pet_traits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adoption_id')->constrained('adoption_pets', 'adoption_id')->onDelete('cascade');
            $table->foreignId('trait_id')->constrained('traits')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pet_traits');
        Schema::dropIfExists('traits');
    }
};