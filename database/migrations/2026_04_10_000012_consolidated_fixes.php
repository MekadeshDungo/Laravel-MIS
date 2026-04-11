<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        try {
            Schema::table('vaccinations', function (Blueprint $table) {
                $table->foreign('pet_id')->references('id')->on('pets')->cascadeOnDelete();
                $table->foreign('vaccinated_by')->references('id')->on('admin_users')->cascadeOnDelete();
                $table->index('pet_id');
                $table->index('vaccinated_by');
                $table->index('vaccination_date');
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('livestock', function (Blueprint $table) {
                $table->dropForeign(['recorded_by']);
                $table->foreign('recorded_by')->references('id')->on('admin_users')->onDelete('set null');
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('establishments', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->foreign('user_id')->references('id')->on('admin_users')->onDelete('set null');
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('announcement_reads', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->foreign('user_id')->references('id')->on('admin_users')->onDelete('cascade');
                $table->foreign('announcement_id')->references('id')->on('announcements')->onDelete('cascade');
            });
        } catch (\Exception $e) {}

        try { DB::statement('CREATE INDEX IF NOT EXISTS livestock_owner_id_index ON livestock(owner_id)'); } catch (\Exception $e) {}
        try { DB::statement('CREATE INDEX IF NOT EXISTS livestock_barangay_id_index ON livestock(barangay_id)'); } catch (\Exception $e) {}
        try { DB::statement('CREATE INDEX IF NOT EXISTS livestock_species_index ON livestock(species)'); } catch (\Exception $e) {}
        try { DB::statement('CREATE INDEX IF NOT EXISTS livestock_status_index ON livestock(status)'); } catch (\Exception $e) {}
        try { DB::statement('CREATE INDEX IF NOT EXISTS livestock_recorded_by_index ON livestock(recorded_by)'); } catch (\Exception $e) {}

        try { DB::statement('CREATE INDEX IF NOT EXISTS establishments_barangay_id_index ON establishments(barangay_id)'); } catch (\Exception $e) {}
        try { DB::statement('CREATE INDEX IF NOT EXISTS establishments_user_id_index ON establishments(user_id)'); } catch (\Exception $e) {}
        try { DB::statement('CREATE INDEX IF NOT EXISTS establishments_type_index ON establishments(type)'); } catch (\Exception $e) {}
        try { DB::statement('CREATE INDEX IF NOT EXISTS establishments_status_index ON establishments(status)'); } catch (\Exception $e) {}

        try { DB::statement('CREATE INDEX IF NOT EXISTS notifications_user_id_index ON notifications(user_id)'); } catch (\Exception $e) {}
        try { DB::statement('CREATE INDEX IF NOT EXISTS notifications_is_read_index ON notifications(is_read)'); } catch (\Exception $e) {}
        try { DB::statement('CREATE INDEX IF NOT EXISTS notifications_related_module_index ON notifications(related_module)'); } catch (\Exception $e) {}

        try { DB::statement('CREATE INDEX IF NOT EXISTS impound_records_disposition_index ON impound_records(current_disposition)'); } catch (\Exception $e) {}
        try { DB::statement('CREATE INDEX IF NOT EXISTS impound_records_intake_index ON impound_records(intake_date)'); } catch (\Exception $e) {}

        try { DB::statement('CREATE INDEX IF NOT EXISTS adoption_requests_status_index ON adoption_requests(request_status)'); } catch (\Exception $e) {}
        try { DB::statement('CREATE INDEX IF NOT EXISTS adoption_requests_impound_index ON adoption_requests(impound_id)'); } catch (\Exception $e) {}

        try { DB::statement('CREATE INDEX IF NOT EXISTS spay_neuter_reports_created_index ON spay_neuter_reports(created_at)'); } catch (\Exception $e) {}

        try { DB::statement('CREATE INDEX IF NOT EXISTS clinical_actions_barangay_index ON clinical_actions(barangay_id)'); } catch (\Exception $e) {}
        try { DB::statement('CREATE INDEX IF NOT EXISTS clinical_actions_created_index ON clinical_actions(created_at)'); } catch (\Exception $e) {}

        try { DB::statement('CREATE INDEX IF NOT EXISTS medical_records_barangay_index ON medical_records(barangay_id)'); } catch (\Exception $e) {}
        try { DB::statement('CREATE INDEX IF NOT EXISTS medical_records_pet_index ON medical_records(pet_id)'); } catch (\Exception $e) {}

        try { DB::statement('CREATE INDEX IF NOT EXISTS system_logs_causer_index ON system_logs(causer_id)'); } catch (\Exception $e) {}
        try { DB::statement('CREATE INDEX IF NOT EXISTS system_logs_created_index ON system_logs(created_at)'); } catch (\Exception $e) {}

        Schema::table('clients', function (Blueprint $table) {
            if (Schema::hasColumn('clients', 'phone_number')) {
                $table->string('phone_number', 11)->change();
            }
            if (!Schema::hasColumn('clients', 'alternate_phone')) {
                $table->string('alternate_phone', 11)->nullable()->after('phone_number');
            }
            try { DB::statement('CREATE INDEX IF NOT EXISTS clients_status_index ON clients(status)'); } catch (\Exception $e) {}
            try { DB::statement('CREATE INDEX IF NOT EXISTS clients_email_index ON clients(email)'); } catch (\Exception $e) {}
        });
    }

    public function down(): void
    {
    }
};
