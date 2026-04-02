<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * NOTE: roles table was removed - using enum instead
     */
    public function up(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            // Rename columns to match ERD
            if (Schema::hasColumn('announcements', 'description')) {
                $table->renameColumn('description', 'body');
            }
            if (Schema::hasColumn('announcements', 'photo_path')) {
                $table->renameColumn('photo_path', 'image_path');
            }

            // Add target_role column using enum instead of foreign key
            // NULL = visible to all
            // Specific role = visible only to that role
            if (!Schema::hasColumn('announcements', 'target_role')) {
                $table->enum('target_role', [
                    'super_admin',
                    'admin',
                    'city_vet',
                    'admin_staff',
                    'disease_control',
                    'city_pound',
                    'meat_inspector',
                    'veterinarian',
                    'viewer',
                    'citizen'
                ])->nullable()->after('user_id');
            }

            // Add column to control admin visibility
            // true = exclude admin/super_admin from viewing (default)
            // false = include everyone
            if (!Schema::hasColumn('announcements', 'exclude_admin')) {
                $table->boolean('exclude_admin')->default(true)->after('target_role');
            }

            // Add index for target_role
            $table->index('target_role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            // Reverse column renames
            if (Schema::hasColumn('announcements', 'body')) {
                $table->renameColumn('body', 'description');
            }
            if (Schema::hasColumn('announcements', 'image_path')) {
                $table->renameColumn('image_path', 'photo_path');
            }

            // Drop columns
            $table->dropColumn('target_role');
            $table->dropColumn('exclude_admin');
            $table->dropIndex(['target_role']);
        });
    }
};
