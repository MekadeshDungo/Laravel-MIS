<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pet_traits_new', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pet_id');
            $table->unsignedBigInteger('trait_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->index('pet_id');
            $table->index('trait_id');
        });

        DB::statement('ALTER TABLE pet_traits_new ADD CONSTRAINT fk_pet_traits_new_pet 
            FOREIGN KEY (pet_id) REFERENCES pets(pet_id) ON DELETE CASCADE');
        DB::statement('ALTER TABLE pet_traits_new ADD CONSTRAINT fk_pet_traits_new_trait 
            FOREIGN KEY (trait_id) REFERENCES traits(id) ON DELETE CASCADE');

        DB::statement('INSERT IGNORE INTO pet_traits_new (pet_id, trait_id, created_at, updated_at)
            SELECT p.pet_id, pt.trait_id, pt.created_at, pt.updated_at
            FROM pet_traits pt
            INNER JOIN pets p ON p.source_module = "adoption_pets" 
                AND p.source_module_id = pt.adoption_id');

        Schema::dropIfExists('pet_traits');
        Schema::rename('pet_traits_new', 'pet_traits');
    }

    public function down(): void
    {
        Schema::create('pet_traits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adoption_id')->constrained('adoption_pets', 'adoption_id')->onDelete('cascade');
            $table->foreignId('trait_id')->constrained('traits')->onDelete('cascade');
            $table->timestamps();
        });

        DB::statement('INSERT IGNORE INTO pet_traits (adoption_id, trait_id, created_at, updated_at)
            SELECT p.source_module_id, pt.trait_id, pt.created_at, pt.updated_at
            FROM pet_traits_new pt
            INNER JOIN pets p ON p.pet_id = pt.pet_id AND p.source_module = "adoption_pets"');

        Schema::dropIfExists('pet_traits_new');
    }
};