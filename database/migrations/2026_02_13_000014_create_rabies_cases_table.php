<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rabies_cases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barangay_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('case_number')->unique();
            $table->enum('case_type', ['positive', 'probable', 'suspect', 'negative']);
            $table->enum('species', ['dog', 'cat', 'other']);
            $table->string('animal_name')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('owner_contact')->nullable();
            $table->text('address')->nullable();
            $table->date('incident_date');
            $table->string('incident_location')->nullable();
            $table->enum('status', ['open', 'closed', 'under_investigation'])->default('open');
            $table->date('date_submitted')->nullable();
            $table->text('findings')->nullable();
            $table->text('actions_taken')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('barangay_id')->references('barangay_id')->on('barangays')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rabies_cases');
    }
};
