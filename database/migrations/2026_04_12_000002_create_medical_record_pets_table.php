<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('medical_record_pets')) {
            Schema::create('medical_record_pets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medical_record_id');
            $table->foreign('medical_record_id')->references('id')->on('medical_records')->onDelete('cascade');
            $table->unsignedBigInteger('pet_id');
            $table->foreign('pet_id')->references('pet_id')->on('pets')->onDelete('cascade');
            $table->timestamps();

            $table->index('medical_record_id');
            $table->index('pet_id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_record_pets');
    }
};