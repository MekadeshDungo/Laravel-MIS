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
        Schema::create('clients', function (Blueprint $table) {
            $table->id('client_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('suffix')->nullable();
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->string('house_no')->nullable();
            $table->string('street')->nullable();
            $table->string('subdivision')->nullable();
            $table->unsignedBigInteger('barangay_id')->nullable();
            $table->string('city')->default('Dasmariñas');
            $table->string('province')->default('Cavite');
            $table->string('password');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->timestamps();

            $table->foreign('barangay_id')
                ->references('barangay_id')
                ->on('barangays')
                ->nullOnDelete();

            // Indexes
            $table->index('barangay_id');
            $table->index('status');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
