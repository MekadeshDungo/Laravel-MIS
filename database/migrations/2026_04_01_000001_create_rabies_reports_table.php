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
        Schema::create('rabies_reports', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Report Identification
            $table->string('report_number', 50)->unique();
            $table->enum('status', ['Pending Review', 'Under Review', 'Resolved', 'Closed'])->default('Pending Review');
            $table->string('assigned_to_role', 50)->default('assistant_vet');

            // SECTION I: Source of Report
            $table->enum('reporting_facility', [
                'Registered Veterinary Clinics',
                'Animal Bite Centers (ABCs)',
                'Hospitals',
                'Others'
            ]);
            $table->string('facility_name')->nullable();
            $table->date('date_reported');

            // SECTION II: Patient (Human) Information
            $table->string('patient_name');
            $table->tinyInteger('patient_age');
            $table->enum('patient_gender', ['Male', 'Female']);
            $table->unsignedBigInteger('patient_barangay_id');
            $table->string('patient_contact', 20);

            // SECTION III: Incident Details
            $table->date('incident_date');
            $table->enum('nature_of_incident', ['Bitten', 'Scratched', 'Licked (Open Wound)']);
            $table->enum('bite_site', ['Head/Neck', 'Upper Extremities', 'Trunk', 'Lower Extremities']);
            $table->enum('exposure_category', ['Category I (Lick)', 'Category II (Scratch)', 'Category III (Bite / Deep)']);

            // SECTION IV: Animal Information
            $table->enum('animal_species', ['Dog', 'Cat', 'Others']);
            $table->enum('animal_status', ['Stray', 'Owned', 'Wild']);
            $table->string('animal_owner_name')->nullable();
            $table->enum('animal_vaccination_status', ['Vaccinated', 'Unvaccinated', 'Unknown']);
            $table->enum('animal_current_condition', ['Healthy / Alive', 'Dead', 'Missing / Escaped', 'Euthanized']);

            // SECTION V: Clinical Action
            $table->json('wound_management')->nullable(); // Array: ['Washed with Soap', 'Antiseptic Applied', 'None']
            $table->enum('post_exposure_prophylaxis', ['Yes', 'No']);

            // Additional Fields
            $table->text('notes')->nullable();

            // Foreign Keys
            $table->unsignedBigInteger('barangay_id')->nullable(); // Where incident occurred
            $table->foreign('barangay_id')->references('barangay_id')->on('barangays')->onDelete('set null');
            $table->foreign('patient_barangay_id')->references('barangay_id')->on('barangays')->onDelete('cascade');

            // Timestamps
            $table->timestamps();

            // Indexes
            $table->index('report_number');
            $table->index('status');
            $table->index('assigned_to_role');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rabies_reports');
    }
};
