<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merge_audit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pet_id_kept');
            $table->unsignedBigInteger('pet_id_merged');
            $table->string('confidence', 50);
            $table->text('reason');
            $table->unsignedBigInteger('merged_by')->nullable();
            $table->timestamp('merged_at')->nullable();
            $table->timestamp('created_at')->nullable();

            $table->index('pet_id_kept');
            $table->index('pet_id_merged');
            $table->index('merged_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merge_audit');
    }
};