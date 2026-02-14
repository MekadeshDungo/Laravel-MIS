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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->string('name', 100);
            $table->string('species', 50);
            $table->string('breed', 100)->nullable();
            $table->integer('age')->nullable();
            $table->enum('gender', ['male', 'female', 'unknown'])->default('unknown');
            $table->string('color', 100)->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->enum('vaccination_status', ['vaccinated', 'unvaccinated', 'pending'])->default('unvaccinated');
            $table->date('vaccination_date')->nullable();
            $table->date('next_vaccination_date')->nullable();
            $table->string('license_number', 50)->nullable();
            $table->date('license_expiry')->nullable();
            $table->string('microchip_number', 50)->nullable();
            $table->enum('health_status', ['healthy', 'sick', 'deceased'])->default('healthy');
            $table->text('medical_history')->nullable();
            $table->text('notes')->nullable();
            $table->string('photo_url', 255)->nullable();
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('owner_id');
            $table->index('species');
            $table->index('vaccination_status');
            $table->index('license_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
