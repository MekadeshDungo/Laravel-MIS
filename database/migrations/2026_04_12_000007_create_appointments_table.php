<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->enum('service_type', ['vaccination', 'kapon', 'adoption_interview']);
            $table->unsignedBigInteger('service_id');
            $table->enum('status', ['pending', 'scheduled', 'completed', 'cancelled', 'no_show'])->default('pending');
            $table->integer('total_weight')->default(1);
            $table->json('metadata')->nullable();
            $table->timestamps();

            // Indexes for querying
            $table->index('appointment_date');
            $table->index('appointment_time');
            $table->index('service_type');
            $table->index(['service_type', 'service_id']);
            $table->index('status');
            // Unique constraint: one appointment per date/time (not per service type - allows merging)
            $table->unique(['appointment_date', 'appointment_time'], 'unique_date_time_slot');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};