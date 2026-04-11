<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clinical_actions', function (Blueprint $table) {
            $table->id();
            $table->string('case_title');
            $table->string('action_type')->nullable();
            $table->unsignedBigInteger('animal_id')->nullable();
            $table->string('animal_name')->nullable();
            $table->string('species')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('owner_contact')->nullable();
            $table->date('action_date')->nullable();
            $table->text('description');
            $table->text('diagnosis')->nullable();
            $table->text('treatment_given')->nullable();
            $table->string('medication')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->string('outcome')->nullable();
            $table->unsignedBigInteger('veterinarian_id')->nullable();
            $table->foreignId('barangay_id')->nullable()->references('barangay_id')->on('barangays')->onDelete('set null');
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->enum('status', ['Pending', 'In Review', 'Completed'])->default('Pending');
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            
            $table->index('status');
            $table->index('barangay_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clinical_actions');
    }
};