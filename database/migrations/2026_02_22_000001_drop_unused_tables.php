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
        // Keep tables that are still used by controllers/models
        Schema::dropIfExists('adoption_requests');
        Schema::dropIfExists('adoption_status_histories');
        Schema::dropIfExists('announcement_forms');
        // Keep announcement_reads - used by AnnouncementController
        // Keep barangay_users - may be used
        // Keep certificate_series - used by CertificateController
        // Keep device_tokens - used by DeviceTokenController
        // Keep form_submissions - may be used
        // Keep inventory_items - used by InventoryController
        // Keep livestock_censuses - used by LivestockCensusController
        // Keep notifications - used by NotificationController
        // Keep pets - used by PetController
        // Keep rabies_cases - used by RabiesCaseController
        // Keep rabies_vaccination_reports - used by ClinicController
        // Keep report_exports - used by ReportController
        // Keep service_forms - used by ServiceFormController
        // Keep spay_neuter_reports - used by SpayNeuterController
        // Keep stock_movements - used by InventoryController
        // Keep stray_reports - used by various controllers
        // Keep user_roles - may be used
        // Keep impound_status_histories - used by ImpoundController

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
