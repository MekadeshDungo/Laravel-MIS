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
        Schema::create('impounds', function (Blueprint $table) {
            $table->id('impound_id');
            $table->unsignedBigInteger('animal_id');
            $table->date('impound_date');
            $table->text('impound_reason')->nullable();
            $table->text('capture_location_text');
            $table->unsignedBigInteger('captured_by_user_id');
            $table->enum('status', ['in_pound', 'released', 'adopted', 'euthanized'])->default('in_pound');
            $table->date('release_date')->nullable();
            $table->timestamps();

            $table->foreign('animal_id')
                ->references('animal_id')
                ->on('animals')
                ->cascadeOnDelete();

            $table->foreign('captured_by_user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            // Indexes
            $table->index('animal_id');
            $table->index('impound_date');
            $table->index('status');
            $table->index('captured_by_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('impounds');
    }
};
