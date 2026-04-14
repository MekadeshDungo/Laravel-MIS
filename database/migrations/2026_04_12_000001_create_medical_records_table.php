<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('medical_records')) {
            Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('admin_users')->onDelete('cascade');
            $table->unsignedBigInteger('owner_id');
            $table->foreign('owner_id')->references('owner_id')->on('pet_owners')->onDelete('cascade');
            $table->enum('type', ['vaccination', 'kapon']);
            $table->date('appointment_date')->nullable();
            $table->enum('status', ['pending', 'approved', 'completed', 'rejected'])->default('pending');
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index('type');
            $table->index('appointment_date');
            $table->index('status');
            $table->index('user_id');
                $table->index('owner_id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};