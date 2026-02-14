<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spay_neuter_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('pet_name')->nullable();
            $table->string('pet_type'); // dog, cat, etc.
            $table->string('pet_breed')->nullable();
            $table->integer('pet_age')->nullable();
            $table->string('pet_sex'); // male, female
            $table->string('color_markings')->nullable();
            $table->string('owner_name');
            $table->string('owner_contact')->nullable();
            $table->text('owner_address')->nullable();
            $table->enum('procedure_type', ['spay', 'neuter', 'both']);
            $table->date('procedure_date');
            $table->string('veterinarian')->nullable();
            $table->string('clinic_name')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->enum('status', ['scheduled', 'completed', 'cancelled', 'pending'])->default('pending');
            $table->text('remarks')->nullable();
            $table->date('report_date')->default(now());
            $table->string('barangay')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spay_neuter_reports');
    }
};
