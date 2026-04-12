<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bite_rabies_reports', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['Pending Review', 'Under Investigation', 'Cleared', 'Confirmed Rabies'])->default('Pending Review');
            $table->string('report_number', 50)->unique();
            
            // Patient Information
            $table->string('patient_name');
            $table->integer('age');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('patient_address')->nullable();
            $table->string('patient_contact', 11)->nullable();
            
            // Patient Barangay
            $table->string('patient_barangay')->nullable();
            
            // Location
            $table->foreignId('barangay_id')->nullable()->constrained('barangays', 'barangay_id')->onDelete('set null');
            
            // Incident Details
            $table->string('incident_barangay')->nullable();
            $table->string('exact_location')->nullable();
            $table->date('incident_date');
            $table->enum('exposure_type', ['bite', 'scratch', 'lick']);
            $table->string('bite_site')->nullable();
            $table->enum('category', ['I', 'II', 'III']);
            
            // Animal Information
            $table->enum('animal_type', ['dog', 'cat', 'others']);
            $table->enum('animal_status', ['stray', 'owned', 'wild']);
            $table->enum('vaccination_status', ['vaccinated', 'unvaccinated', 'unknown']);
            $table->string('animal_owner_name')->nullable();
            $table->string('animal_owner_contact', 11)->nullable();
            
            // Reporting
            $table->foreignId('reported_by')->nullable()->constrained('admin_users', 'id')->onDelete('set null');
            
            // Reporting Facility
            $table->string('reporting_facility')->nullable();
            
            // Additional
            $table->json('wound_management')->nullable();
            $table->text('post_exposure_prophylaxis')->nullable();
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('report_number');
            $table->index('barangay_id');
            $table->index('reported_by');
            $table->index('incident_date');
            $table->index('animal_type');
            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bite_rabies_reports');
    }
};