<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('missing_pets_reports', function (Blueprint $table) {
            $table->id('report_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('pet_id');
            $table->foreign('pet_id')->references('pet_id')->on('pets')->onDelete('cascade');
            $table->text('body_marks')->nullable();
            $table->string('eye_color');
            $table->string('collar_harness')->nullable();
            $table->timestamp('last_seen_at');
            $table->string('location_barangay');
            $table->text('location_description')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->enum('status', ['missing', 'found', 'reunited'])->default('missing');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('missing_pets_reports');
    }
};