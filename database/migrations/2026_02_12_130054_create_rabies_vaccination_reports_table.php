<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rabies_vaccination_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('clinic_name');
            $table->string('patient_name');
            $table->string('patient_contact');
            $table->string('patient_address');
            $table->string('pet_name')->nullable();
            $table->string('pet_species'); // dog, cat, etc.
            $table->string('pet_breed')->nullable();
            $table->integer('pet_age')->nullable();
            $table->string('pet_gender')->nullable();
            $table->string('pet_color')->nullable();
            $table->string('vaccine_brand');
            $table->string('vaccine_batch_number')->nullable();
            $table->date('vaccination_date');
            $table->time('vaccination_time');
            $table->date('next_vaccination_date')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->enum('vaccination_type', ['primary', 'booster']);
            $table->text('observations')->nullable();
            $table->enum('status', ['completed', 'pending', 'adverse_reaction'])->default('completed');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rabies_vaccination_reports');
    }
};
