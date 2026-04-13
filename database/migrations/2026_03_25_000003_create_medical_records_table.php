<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Medical & Vaccination Record Module - For tracking medical and vaccination records
     */
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->string('record_type');
            $table->unsignedBigInteger('animal_id')->nullable();
            $table->unsignedBigInteger('barangay_id')->nullable();
            $table->string('animal_name')->nullable();
            $table->string('species')->nullable();
            $table->string('breed')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('owner_contact')->nullable();
            $table->date('record_date');
            $table->text('diagnosis')->nullable();
            $table->text('treatment')->nullable();
            $table->string('vaccine_name')->nullable();
            $table->date('vaccination_date')->nullable();
            $table->date('next_vaccination_date')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('veterinarian_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->index('record_type');
            $table->index('animal_id');
            $table->index('record_date');
        });

        try {
            DB::statement('ALTER TABLE medical_records ADD CONSTRAINT medical_records_animal_id_foreign FOREIGN KEY (animal_id) REFERENCES pets(pet_id) ON DELETE SET NULL');
        } catch (\Exception $e) {}
        try {
            DB::statement('ALTER TABLE medical_records ADD CONSTRAINT medical_records_barangay_id_foreign FOREIGN KEY (barangay_id) REFERENCES barangays(barangay_id) ON DELETE SET NULL');
        } catch (\Exception $e) {}
        try {
            DB::statement('ALTER TABLE medical_records ADD CONSTRAINT medical_records_veterinarian_id_foreign FOREIGN KEY (veterinarian_id) REFERENCES admin_users(id) ON DELETE SET NULL');
        } catch (\Exception $e) {}
        try {
            DB::statement('ALTER TABLE medical_records ADD CONSTRAINT medical_records_created_by_foreign FOREIGN KEY (created_by) REFERENCES admin_users(id) ON DELETE SET NULL');
        } catch (\Exception $e) {}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
