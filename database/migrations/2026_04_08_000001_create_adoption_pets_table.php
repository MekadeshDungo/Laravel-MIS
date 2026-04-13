<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adoption_pets', function (Blueprint $table) {
            $table->id('adoption_id');
            $table->string('pet_name');
            $table->string('species');
            $table->string('gender');
            $table->integer('age')->nullable();
            $table->string('breed')->nullable();
            $table->text('description')->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->string('image')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->boolean('is_age_estimated')->default(false);
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_missing')->default(false);
            $table->date('missing_since')->nullable();
            $table->text('last_seen_location')->nullable();
            $table->text('contact_info')->nullable();
            $table->timestamps();
            
            $table->index('species');
            $table->index('gender');
            $table->index('is_approved');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adoption_pets');
    }
};
