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
        Schema::create('adoption_pets', function (Blueprint $table) {
            $table->id();
            $table->string('pet_name');
            $table->string('species'); // dog, cat, etc.
            $table->string('breed')->nullable();
            $table->integer('age'); // in years
            $table->string('gender'); // male, female
            $table->text('description')->nullable();
            $table->text('traits')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adoption_pets');
    }
};