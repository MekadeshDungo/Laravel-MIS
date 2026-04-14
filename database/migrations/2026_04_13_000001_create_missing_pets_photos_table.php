<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('missing_pets_photos', function (Blueprint $table) {
            $table->id('photo_id');
            $table->unsignedBigInteger('report_id');
            $table->foreign('report_id')->references('report_id')->on('missing_pets_reports')->onDelete('cascade');
            $table->string('photo_path');
            $table->enum('photo_type', ['main', 'body_marks', 'eye_color', 'collar_harness', 'other']);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('missing_pets_photos');
    }
};