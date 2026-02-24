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
        Schema::create('bite_incidents', function (Blueprint $table) {
            $table->id('incident_id');
            $table->unsignedBigInteger('reported_by_user_id');
            $table->unsignedBigInteger('barangay_id')->nullable();
            $table->date('incident_date');
            $table->text('location_details');
            $table->string('victim_name');
            $table->integer('victim_age')->nullable();
            $table->enum('victim_sex', ['male', 'female', 'other'])->nullable();
            $table->text('victim_address_text')->nullable();
            $table->unsignedBigInteger('biting_animal_id')->nullable();
            $table->text('animal_description')->nullable();
            $table->enum('severity_level', ['minor', 'moderate', 'severe'])->nullable();
            $table->enum('status', ['open', 'under_observation', 'closed'])->default('open');
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('reported_by_user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('barangay_id')
                ->references('barangay_id')
                ->on('barangays')
                ->nullOnDelete();

            $table->foreign('biting_animal_id')
                ->references('animal_id')
                ->on('animals')
                ->nullOnDelete();

            // Indexes
            $table->index('barangay_id');
            $table->index('incident_date');
            $table->index('status');
            $table->index('reported_by_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bite_incidents');
    }
};
