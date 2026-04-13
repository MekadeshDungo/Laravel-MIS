<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->enum('type', ['abc', 'clinic', 'hospital']);
            $table->unsignedBigInteger('barangay_id')->nullable();
            $table->timestamps();

            // Foreign key to barangays (nullable for incomplete student data)
            if (Schema::hasTable('barangays')) {
                $table->foreign('barangay_id')
                    ->references('barangay_id')
                    ->on('barangays')
                    ->onDelete('set null');
            }

            $table->index('barangay_id');
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};