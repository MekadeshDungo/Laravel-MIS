<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('missing_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pet_id');
            $table->date('last_seen_date')->nullable();
            $table->text('last_seen_location')->nullable();
            $table->text('contact_info')->nullable();
            $table->unsignedBigInteger('source_missing_id')->nullable();
            $table->timestamp('created_at')->nullable();

            $table->index('pet_id');
            $table->index('source_missing_id');

            $table->foreign('pet_id')->references('pet_id')->on('pets')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('missing_reports');
    }
};