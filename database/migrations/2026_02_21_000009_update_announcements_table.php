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
        Schema::table('announcements', function (Blueprint $table) {
            // Rename columns to match ERD
            $table->renameColumn('description', 'body');
            $table->renameColumn('photo_path', 'image_path');

            // Add target_role_id after user_id for role-based visibility
            // NULL = visible to all EXCEPT admin and super_admin (by default)
            // Set to specific role_id = visible only to that role
            $table->unsignedBigInteger('target_role_id')->nullable()->after('user_id');
            $table->foreign('target_role_id')
                ->references('id')
                ->on('roles')
                ->nullOnDelete();

            // Add column to control admin visibility
            // true = exclude admin/super_admin from viewing (default)
            // false = include everyone
            $table->boolean('exclude_admin')->default(true)->after('target_role_id');

            // Add index for target_role_id
            $table->index('target_role_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            // Reverse column renames
            $table->renameColumn('body', 'description');
            $table->renameColumn('image_path', 'photo_path');

            // Drop foreign key and columns
            $table->dropForeign(['target_role_id']);
            $table->dropColumn('target_role_id');
            $table->dropColumn('exclude_admin');
            $table->dropIndex(['target_role_id']);
        });
    }
};
