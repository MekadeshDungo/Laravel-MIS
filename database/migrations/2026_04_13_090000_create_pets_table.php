<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id('pet_id');
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->unsignedBigInteger('barangay_id')->nullable();
            $table->string('pet_name')->nullable();
            $table->string('species')->nullable();
            $table->string('breed')->nullable();
            $table->string('sex')->nullable();
            $table->integer('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('color')->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->string('vaccination_status')->nullable();
            $table->date('vaccination_date')->nullable();
            $table->date('next_vaccination_date')->nullable();
            $table->string('license_number')->nullable();
            $table->date('license_expiry')->nullable();
            $table->string('microchip_number')->nullable();
            $table->string('health_status')->nullable();
            $table->text('medical_history')->nullable();
            $table->text('notes')->nullable();
            $table->string('pet_image')->nullable();
            $table->date('birthdate')->nullable();
            $table->text('body_mark_details')->nullable();
            $table->string('body_mark_image')->nullable();
            $table->boolean('is_neutered')->default(false);
            $table->boolean('is_crossbreed')->default(false);
            $table->string('training')->nullable();
            $table->string('insurance')->nullable();
            $table->string('behavior')->nullable();
            $table->string('likes')->nullable();
            $table->string('dislikes')->nullable();
            $table->text('diet')->nullable();
            $table->string('allergy')->nullable();
            $table->timestamps();

            $table->index('owner_id');
            $table->index('barangay_id');
            $table->index('species');
            $table->index('pet_name');
        });

        DB::statement('ALTER TABLE pets ADD CONSTRAINT pets_owner_id_foreign FOREIGN KEY (owner_id) REFERENCES pet_owners(owner_id) ON DELETE SET NULL');
        DB::statement('ALTER TABLE pets ADD CONSTRAINT pets_barangay_id_foreign FOREIGN KEY (barangay_id) REFERENCES barangays(barangay_id) ON DELETE SET NULL');
    }

    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
