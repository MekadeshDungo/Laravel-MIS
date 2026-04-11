<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * NOTE: roles table was removed - using enum for roles instead
     */
    public function up(): void
    {
        Schema::table('admin_users', function (Blueprint $table) {
            // Add full_name column after name (only if it doesn't exist)
            if (!Schema::hasColumn('admin_users', 'full_name')) {
                $table->string('full_name')->nullable()->after('name');
            }

            // Add role column if it doesn't exist (using enum in main users table)
            if (!Schema::hasColumn('admin_users', 'role')) {
                $table->enum('role', [
                    'super_admin',
                    'admin',
                    'city_vet',
                    'admin_staff',
                    'disease_control',
                    'city_pound',
                    'meat_inspector',
                    'veterinarian',
                    'viewer'
                ])->default('viewer')->after('password');
            }

            // Add secondary_role column if it doesn't exist
            if (!Schema::hasColumn('admin_users', 'secondary_role')) {
                $table->enum('secondary_role', [
                    'super_admin',
                    'admin',
                    'city_vet',
                    'admin_staff',
                    'disease_control',
                    'city_pound',
                    'meat_inspector',
                    'veterinarian',
                    'viewer',
                    'barangay_encoder'
                ])->nullable()->after('role');
            }

            // Add barangay_id foreign key (only if it doesn't exist)
            if (!Schema::hasColumn('admin_users', 'barangay_id')) {
                $table->unsignedBigInteger('barangay_id')->nullable();
                $table->foreign('barangay_id')
                    ->references('barangay_id')
                    ->on('barangays')
                    ->nullOnDelete();
            }

            // Add status column (only if it doesn't exist)
            if (!Schema::hasColumn('admin_users', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active')->after('barangay_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_users', function (Blueprint $table) {
            $table->dropForeign(['barangay_id']);
            $table->dropColumn(['full_name', 'role', 'secondary_role', 'barangay_id', 'status']);
            $table->dropIndex(['role']);
            $table->dropIndex(['barangay_id']);
            $table->dropIndex(['status']);
        });
    }
};
