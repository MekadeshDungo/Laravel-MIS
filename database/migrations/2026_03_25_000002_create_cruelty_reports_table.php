<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Cruelty Assessment Module - For recording animal cruelty reports
     */
    public function up(): void
    {
        Schema::create('cruelty_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_title');
            $table->text('description');
            $table->foreignId('barangay_id')->nullable()->references('barangay_id')->on('barangays')->onDelete('set null');
            $table->string('reporter_name')->nullable();
            $table->string('reporter_contact')->nullable();
            $table->date('date_reported');
            $table->enum('status', ['Pending', 'Investigating', 'Resolved'])->default('Pending');
            $table->text('findings')->nullable();
            $table->text('action_taken')->nullable();
            $table->foreignId('investigated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            $table->index('status');
            $table->index('barangay_id');
            $table->index('date_reported');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cruelty_reports');
    }
};