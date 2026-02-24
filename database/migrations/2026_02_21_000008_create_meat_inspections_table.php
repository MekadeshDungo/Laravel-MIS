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
        Schema::create('meat_inspections', function (Blueprint $table) {
            $table->id('inspection_id');
            $table->unsignedBigInteger('establishment_id');
            $table->unsignedBigInteger('inspector_user_id');
            $table->date('inspection_date');
            $table->text('findings')->nullable();
            $table->enum('status', ['passed', 'failed', 'conditional'])->default('passed');
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('establishment_id')
                ->references('establishment_id')
                ->on('meat_establishments')
                ->cascadeOnDelete();

            $table->foreign('inspector_user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            // Indexes
            $table->index('establishment_id');
            $table->index('inspector_user_id');
            $table->index('inspection_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meat_inspections');
    }
};
