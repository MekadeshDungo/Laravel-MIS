<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This migration creates the vaccinations table
     */
    public function up(): void
    {
        // Disable foreign key checks for this operation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Create vaccinations table
        Schema::create('vaccinations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pet_id');
            $table->unsignedBigInteger('vaccinated_by');
            $table->string('vaccine_type')->default('Rabies');
            $table->date('vaccination_date');
            $table->date('next_vaccination_date')->nullable();
            $table->string('batch_number')->nullable();
            $table->string('veterinarian')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('pet_id');
            $table->index('vaccinated_by');
            $table->index('vaccination_date');
        });

        // Add foreign keys manually
        DB::statement('ALTER TABLE vaccinations ADD CONSTRAINT vaccinations_pet_id_foreign FOREIGN KEY (pet_id) REFERENCES pets(pet_id) ON DELETE CASCADE');
        DB::statement('ALTER TABLE vaccinations ADD CONSTRAINT vaccinations_vaccinated_by_foreign FOREIGN KEY (vaccinated_by) REFERENCES admin_users(id) ON DELETE CASCADE');

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccinations');
    }
};
