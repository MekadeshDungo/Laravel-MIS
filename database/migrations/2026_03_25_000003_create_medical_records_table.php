<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('record_type'); // 'Medical' or 'Vaccination'
            $table->foreignId('animal_id')->nullable()->references('animal_id')->on('animals')->onDelete('set null');
            $table->foreignId('barangay_id')->nullable()->references('barangay_id')->on('barangays')->onDelete('set null');
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
            $table->foreignId('veterinarian_id')->nullable()->constrained('admin_users')->onDelete('set null');
            $table->foreignId('created_by')->nullable()->constrained('admin_users')->onDelete('set null');
            $table->timestamps();

            $table->index('record_type');
            $table->index('animal_id');
            $table->index('record_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
