<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Drop tables that are no longer needed for the simplified RBAC model
        Schema::dropIfExists('adoption_requests');
        Schema::dropIfExists('adoption_status_histories');
        Schema::dropIfExists('announcement_forms');
        Schema::dropIfExists('announcement_reads');
        Schema::dropIfExists('barangay_users');
        Schema::dropIfExists('certificate_series');
        Schema::dropIfExists('device_tokens');
        Schema::dropIfExists('form_submissions');
        Schema::dropIfExists('inventory_items');
        Schema::dropIfExists('livestock_censuses');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('pets');
        Schema::dropIfExists('rabies_cases');
        Schema::dropIfExists('rabies_vaccination_reports');
        Schema::dropIfExists('report_exports');
        Schema::dropIfExists('service_forms');
        Schema::dropIfExists('spay_neuter_reports');
        Schema::dropIfExists('stock_movements');
        Schema::dropIfExists('stray_reports');
        Schema::dropIfExists('user_roles');
        Schema::dropIfExists('impound_status_histories');

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration cannot be reversed as data would be lost
        // If you need to restore these tables, you must recreate them manually
    }
};
