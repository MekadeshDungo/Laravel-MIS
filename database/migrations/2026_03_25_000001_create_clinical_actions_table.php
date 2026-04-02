<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Clinical Action Module - For tracking clinical tasks/actions
     */
    public function up(): void
    {
        Schema::create('clinical_actions', function (Blueprint $table) {
            $table->id();
            $table->string('case_title');
            $table->text('description');
            $table->foreignId('barangay_id')->nullable()->references('barangay_id')->on('barangays')->onDelete('set null');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', ['Pending', 'In Review', 'Completed'])->default('Pending');
            $table->text('remarks')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            $table->index('status');
            $table->index('barangay_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinical_actions');
    }
};