<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adoption_selected_pets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('adoption_application_id');
            $table->foreign('adoption_application_id')->references('id')->on('adoption_applications')->onDelete('cascade');
            $table->unsignedBigInteger('adoption_pet_id');
            $table->foreign('adoption_pet_id')->references('adoption_id')->on('adoption_pets')->onDelete('cascade');
            $table->timestamps();

            $table->index('adoption_application_id');
            $table->index('adoption_pet_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adoption_selected_pets');
    }
};