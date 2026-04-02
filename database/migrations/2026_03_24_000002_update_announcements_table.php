<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add new fields for the enhanced Announcement module:
     * - type (Vaccination Program, Rabies Alert, etc.)
     * - audience (Public, Pet Owners, etc.)
     * - priority (Normal, Important, Urgent)
     * - status (Draft, Published, Archived)
     * - publish_date
     * - expiry_date
     * - content
     * - attachment
     */
    public function up(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            // Add new type field
            if (!Schema::hasColumn('announcements', 'type')) {
                $table->enum('type', [
                    'Vaccination Program',
                    'Rabies Alert',
                    'Livestock Advisory',
                    'Meat Inspection Notice',
                    'General Announcement'
                ])->default('General Announcement')->after('user_id');
            }

            // Add audience field
            if (!Schema::hasColumn('announcements', 'audience')) {
                $table->enum('audience', [
                    'Public',
                    'Pet Owners',
                    'Farmers / Livestock Owners',
                    'Internal Staff'
                ])->default('Public')->after('type');
            }

            // Add priority field
            if (!Schema::hasColumn('announcements', 'priority')) {
                $table->enum('priority', [
                    'Normal',
                    'Important',
                    'Urgent'
                ])->default('Normal')->after('audience');
            }

            // Add publish_date
            if (!Schema::hasColumn('announcements', 'publish_date')) {
                $table->datetime('publish_date')->nullable()->after('priority');
            }

            // Add expiry_date
            if (!Schema::hasColumn('announcements', 'expiry_date')) {
                $table->datetime('expiry_date')->nullable()->after('publish_date');
            }

            // Rename description to content if it exists
            if (Schema::hasColumn('announcements', 'description')) {
                $table->renameColumn('description', 'content');
            }

            // Add attachment field
            if (!Schema::hasColumn('announcements', 'attachment_path')) {
                $table->string('attachment_path')->nullable()->after('image_path');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            // Drop new columns
            if (Schema::hasColumn('announcements', 'attachment_path')) {
                $table->dropColumn('attachment_path');
            }
            if (Schema::hasColumn('announcements', 'expiry_date')) {
                $table->dropColumn('expiry_date');
            }
            if (Schema::hasColumn('announcements', 'publish_date')) {
                $table->dropColumn('publish_date');
            }
            if (Schema::hasColumn('announcements', 'priority')) {
                $table->dropColumn('priority');
            }
            if (Schema::hasColumn('announcements', 'audience')) {
                $table->dropColumn('audience');
            }
            if (Schema::hasColumn('announcements', 'type')) {
                $table->dropColumn('type');
            }

            // Rename content back to description
            if (Schema::hasColumn('announcements', 'content')) {
                $table->renameColumn('content', 'description');
            }
        });
    }
};