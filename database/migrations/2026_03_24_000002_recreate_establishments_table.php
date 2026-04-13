<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Recreates the establishments table that was incorrectly dropped
     * by the drop_duplicate_tables migration.
     *
     * This table stores various establishment types:
     * - vet_clinic: Veterinary clinics
     * - pet_shop: Pet shops
     * - meat_shop: Meat shops
     * - poultry: Poultry farms/stores
     * - livestock_facility: Livestock facilities
     * - other: Other establishment types
     *
     * NOTE: This is separate from 'meat_establishments' which is specifically
     * for meat inspection establishments.
     */
    public function up(): void
    {
        // Drop if exists to handle edge cases where table exists from previous migrations
        Schema::dropIfExists('establishments');

        Schema::create('establishments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barangay_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->enum('type', ['meat_shop', 'poultry', 'pet_shop', 'vet_clinic', 'livestock_facility', 'other']);
            $table->string('permit_no')->nullable();
            $table->string('address')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('owner_name')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended', 'pending'])->default('pending');
            $table->timestamps();

            $table->foreign('barangay_id')->references('barangay_id')->on('barangays')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('admin_users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('establishments');
    }
};
