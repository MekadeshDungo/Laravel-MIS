<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id('client_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('suffix')->nullable();
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->string('house_no')->nullable();
            $table->string('street')->nullable();
            $table->string('subdivision')->nullable();
            $table->unsignedBigInteger('barangay_id')->nullable();
            $table->string('city')->default('Dasmariñas');
            $table->string('province')->default('Cavite');
            $table->string('password');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->timestamps();

            $table->foreign('barangay_id')->references('barangay_id')->on('barangays')->nullOnDelete();

            $table->index('barangay_id');
            $table->index('status');
            $table->index('email');
        });

        Schema::create('animals', function (Blueprint $table) {
            $table->id('animal_id');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('animal_type');
            $table->string('name')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('sex', ['male', 'female', 'unknown'])->nullable();
            $table->string('color')->nullable();
            $table->string('breed')->nullable();
            $table->boolean('is_stray')->default(false);
            $table->enum('status', ['active', 'impounded', 'adopted', 'deceased'])->default('active');
            $table->timestamps();

            $table->foreign('client_id')->references('client_id')->on('clients')->nullOnDelete();

            $table->index('client_id');
            $table->index('animal_type');
            $table->index('is_stray');
            $table->index('status');
        });

        Schema::create('pets', function (Blueprint $table) {
            $table->id('pet_id');
            $table->unsignedBigInteger('owner_id');
            $table->foreign('owner_id')->references('owner_id')->on('pet_owners')->onDelete('cascade');
            $table->string('pet_name');
            $table->string('species');
            $table->string('breed');
            $table->string('sex');
            $table->date('birthdate')->nullable();
            $table->string('age')->nullable();
            $table->string('weight')->nullable();
            $table->string('color')->nullable();
            $table->string('vaccination_status')->nullable();
            $table->date('vaccination_date')->nullable();
            $table->date('next_vaccination_date')->nullable();
            $table->string('license_number')->nullable();
            $table->date('license_expiry')->nullable();
            $table->string('microchip_number')->nullable();
            $table->string('health_status')->nullable();
            $table->text('medical_history')->nullable();
            $table->text('notes')->nullable();
            $table->string('pet_image')->nullable();
            $table->text('body_mark_details')->nullable();
            $table->string('body_mark_image')->nullable();
            $table->string('is_neutered')->default('no');
            $table->string('is_crossbreed')->default('no');
            $table->json('training')->nullable();
            $table->json('insurance')->nullable();
            $table->json('behavior')->nullable();
            $table->json('likes')->nullable();
            $table->json('dislikes')->nullable();
            $table->json('diet')->nullable();
            $table->json('allergy')->nullable();
            $table->timestamps();

            $table->index('pet_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pets');
        Schema::dropIfExists('animals');
        Schema::dropIfExists('clients');
    }
};
