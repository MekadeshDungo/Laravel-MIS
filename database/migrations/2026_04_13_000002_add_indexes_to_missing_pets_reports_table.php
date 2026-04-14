<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('missing_pets_reports', function ($table) {
            $table->index('status', 'idx_status');
            $table->index('location_barangay', 'idx_barangay');
            $table->index('last_seen_at', 'idx_last_seen_at');
            $table->index('user_id', 'idx_user_id');
            $table->index(['status', 'location_barangay'], 'idx_status_barangay');
        });
    }

    public function down(): void
    {
        Schema::table('missing_pets_reports', function ($table) {
            $table->dropIndex('idx_status');
            $table->dropIndex('idx_barangay');
            $table->dropIndex('idx_last_seen_at');
            $table->dropIndex('idx_user_id');
            $table->dropIndex('idx_status_barangay');
        });
    }
};