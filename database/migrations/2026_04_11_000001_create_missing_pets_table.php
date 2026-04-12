<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('missing_pets', function (Blueprint $table) {
            $table->id('missing_id');
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
            $table->date('missing_since');
            $table->text('last_seen_location');
            $table->text('contact_info');
            $table->timestamps();

            $table->index('species');
            $table->index('gender');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('missing_pets');
    }
};