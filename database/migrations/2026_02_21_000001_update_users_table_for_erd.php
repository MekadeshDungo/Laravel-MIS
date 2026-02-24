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
        Schema::table('users', function (Blueprint $table) {
            // Add full_name column after name (only if it doesn't exist)
            if (!Schema::hasColumn('users', 'full_name')) {
                $table->string('full_name')->nullable()->after('name');
            }

            // Add role_id foreign key (only if it doesn't exist)
            if (!Schema::hasColumn('users', 'role_id')) {
                $table->unsignedBigInteger('role_id')->nullable();
                $table->foreign('role_id')
                    ->references('id')
                    ->on('roles')
                    ->onDelete('restrict');
            }

            // Add barangay_id foreign key (only if it doesn't exist)
            if (!Schema::hasColumn('users', 'barangay_id')) {
                $table->unsignedBigInteger('barangay_id')->nullable();
                $table->foreign('barangay_id')
                    ->references('barangay_id')
                    ->on('barangays')
                    ->nullOnDelete();
            }

            // Add status column (only if it doesn't exist)
            if (!Schema::hasColumn('users', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active')->after('barangay_id');
            }

            // Add indexes for common queries (only if they don't exist)
            $table->index('role_id');
            $table->index('barangay_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['barangay_id']);
            $table->dropColumn(['full_name', 'role_id', 'barangay_id', 'status']);
            $table->dropIndex(['role_id']);
            $table->dropIndex(['barangay_id']);
            $table->dropIndex(['status']);
        });
    }
};
