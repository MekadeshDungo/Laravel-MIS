<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add back 'status' column for backward compatibility with existing code.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('announcements', 'status')) {
            Schema::table('announcements', function (Blueprint $table) {
                $table->enum('status', ['Draft', 'Published', 'Archived'])->nullable()->after('is_active')->default('Draft');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};