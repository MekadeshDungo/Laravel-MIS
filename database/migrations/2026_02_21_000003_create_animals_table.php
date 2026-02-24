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
        Schema::create('animals', function (Blueprint $table) {
            $table->id('animal_id');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('animal_type'); // dog, cat, etc.
            $table->string('name')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('sex', ['male', 'female', 'unknown'])->nullable();
            $table->string('color')->nullable();
            $table->string('breed')->nullable();
            $table->boolean('is_stray')->default(false);
            $table->enum('status', ['active', 'impounded', 'adopted', 'deceased'])->default('active');
            $table->timestamps();

            $table->foreign('client_id')
                ->references('client_id')
                ->on('clients')
                ->nullOnDelete();

            // Indexes
            $table->index('client_id');
            $table->index('animal_type');
            $table->index('is_stray');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
