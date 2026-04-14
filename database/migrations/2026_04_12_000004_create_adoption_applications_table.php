<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adoption_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('mobile_number');
            $table->string('alt_mobile_number')->nullable();
            $table->string('blk_lot_ph');
            $table->string('street');
            $table->string('barangay');
            $table->date('birth_date')->nullable();
            $table->string('occupation')->nullable();
            $table->string('company');
            $table->string('social_media')->nullable();
            $table->enum('adopted_before', ['yes', 'no'])->default('no');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->json('alternate_contact')->nullable();
            $table->json('questionnaire')->nullable();
            $table->string('valid_id_path')->nullable();
            $table->enum('zoom_interview', ['Yes', 'No'])->nullable();
            $table->date('zoom_date')->nullable();
            $table->time('zoom_time')->nullable();
            $table->string('zoom_time_ampm')->nullable();
            $table->enum('shelter_visit', ['Yes', 'No'])->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('first_name');
            $table->index('last_name');
            $table->index('barangay');
            $table->index('adopted_before');
            $table->index('status');
            $table->index('zoom_interview');
            $table->index('zoom_date');
            $table->index('shelter_visit');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adoption_applications');
    }
};