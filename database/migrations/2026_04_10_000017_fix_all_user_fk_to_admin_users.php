<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Fix all FK references from 'users' to 'admin_users'
        // Using try-catch to handle cases where FK doesn't exist
        
        // 1. notifications
        try {
            Schema::table('notifications', function (Blueprint $table) {
                if (Schema::hasColumn('notifications', 'user_id')) {
                    $table->dropForeign(['user_id']);
                    $table->foreign('user_id')
                        ->references('id')
                        ->on('admin_users')
                        ->cascadeOnDelete();
                }
            });
        } catch (\Exception $e) {}

        // 2. system_logs
        try {
            Schema::table('system_logs', function (Blueprint $table) {
                if (Schema::hasColumn('system_logs', 'user_id')) {
                    $table->dropForeign(['user_id']);
                    $table->foreign('user_id')
                        ->references('id')
                        ->on('admin_users')
                        ->cascadeOnDelete();
                }
            });
        } catch (\Exception $e) {}

        // 3. meat_inspections
        try {
            Schema::table('meat_inspections', function (Blueprint $table) {
                if (Schema::hasColumn('meat_inspections', 'inspector_user_id')) {
                    $table->dropForeign(['inspector_user_id']);
                    $table->foreign('inspector_user_id')
                        ->references('id')
                        ->on('admin_users')
                        ->cascadeOnDelete();
                }
            });
        } catch (\Exception $e) {}

        // 4. meat_establishments
        try {
            Schema::table('meat_establishments', function (Blueprint $table) {
                if (Schema::hasColumn('meat_establishments', 'registered_by_user_id')) {
                    $table->dropForeign(['registered_by_user_id']);
                    $table->foreign('registered_by_user_id')
                        ->references('id')
                        ->on('admin_users')
                        ->cascadeOnDelete();
                }
            });
        } catch (\Exception $e) {}

        // 5. livestock_censuses
        try {
            Schema::table('livestock_censuses', function (Blueprint $table) {
                if (Schema::hasColumn('livestock_censuses', 'encoded_by_user_id')) {
                    $table->dropForeign(['encoded_by_user_id']);
                    $table->foreign('encoded_by_user_id')
                        ->references('id')
                        ->on('admin_users')
                        ->cascadeOnDelete();
                }
            });
        } catch (\Exception $e) {}

        // 6. stray_reports
        try {
            Schema::table('stray_reports', function (Blueprint $table) {
                if (Schema::hasColumn('stray_reports', 'reported_by_user_id')) {
                    $table->dropForeign(['reported_by_user_id']);
                    $table->foreign('reported_by_user_id')
                        ->references('id')
                        ->on('admin_users')
                        ->cascadeOnDelete();
                }
            });
        } catch (\Exception $e) {}

        // 7. form_submissions
        try {
            Schema::table('form_submissions', function (Blueprint $table) {
                if (Schema::hasColumn('form_submissions', 'user_id')) {
                    $table->dropForeign(['user_id']);
                    $table->foreign('user_id')
                        ->references('id')
                        ->on('admin_users')
                        ->cascadeOnDelete();
                }
            });
        } catch (\Exception $e) {}

        // 8. clinical_actions
        try {
            Schema::table('clinical_actions', function (Blueprint $table) {
                if (Schema::hasColumn('clinical_actions', 'created_by')) {
                    $table->foreign('created_by')
                        ->references('id')
                        ->on('admin_users')
                        ->setNullOnDelete();
                }
                if (Schema::hasColumn('clinical_actions', 'assigned_to')) {
                    $table->foreign('assigned_to')
                        ->references('id')
                        ->on('admin_users')
                        ->setNullOnDelete();
                }
            });
        } catch (\Exception $e) {}

        // 9. medical_records
        try {
            Schema::table('medical_records', function (Blueprint $table) {
                if (Schema::hasColumn('medical_records', 'created_by')) {
                    $table->foreign('created_by')
                        ->references('id')
                        ->on('admin_users')
                        ->setNullOnDelete();
                }
            });
        } catch (\Exception $e) {}

        // 10. spay_neuter_reports
        try {
            Schema::table('spay_neuter_reports', function (Blueprint $table) {
                if (Schema::hasColumn('spay_neuter_reports', 'encoded_by')) {
                    $table->foreign('encoded_by')
                        ->references('id')
                        ->on('admin_users')
                        ->setNullOnDelete();
                }
            });
        } catch (\Exception $e) {}

        // 11. rabies_vaccination_reports
        try {
            Schema::table('rabies_vaccination_reports', function (Blueprint $table) {
                if (Schema::hasColumn('rabies_vaccination_reports', 'encoded_by')) {
                    $table->foreign('encoded_by')
                        ->references('id')
                        ->on('admin_users')
                        ->setNullOnDelete();
                }
            });
        } catch (\Exception $e) {}

        // 12. cruelty_reports
        try {
            Schema::table('cruelty_reports', function (Blueprint $table) {
                if (Schema::hasColumn('cruelty_reports', 'reported_by')) {
                    $table->foreign('reported_by')
                        ->references('id')
                        ->on('admin_users')
                        ->setNullOnDelete();
                }
            });
        } catch (\Exception $e) {}

        // 13. inventory_controls
        try {
            Schema::table('inventory_controls', function (Blueprint $table) {
                if (Schema::hasColumn('inventory_controls', 'created_by')) {
                    $table->foreign('created_by')
                        ->references('id')
                        ->on('admin_users')
                        ->cascadeOnDelete();
                }
            });
        } catch (\Exception $e) {}

        // 14. report_exports
        try {
            Schema::table('report_exports', function (Blueprint $table) {
                if (Schema::hasColumn('report_exports', 'user_id')) {
                    $table->foreign('user_id')
                        ->references('id')
                        ->on('admin_users')
                        ->cascadeOnDelete();
                }
            });
        } catch (\Exception $e) {}

        // 15. device_tokens
        try {
            Schema::table('device_tokens', function (Blueprint $table) {
                if (Schema::hasColumn('device_tokens', 'user_id')) {
                    $table->dropForeign(['user_id']);
                    $table->foreign('user_id')
                        ->references('id')
                        ->on('admin_users')
                        ->cascadeOnDelete();
                }
            });
        } catch (\Exception $e) {}

        // 16. pets indexes
        try {
            DB::statement('CREATE INDEX IF NOT EXISTS pets_health_status_index ON pets(health_status)');
            DB::statement('CREATE INDEX IF NOT EXISTS pets_gender_index ON pets(gender)');
            DB::statement('CREATE INDEX IF NOT EXISTS pets_name_index ON pets(name)');
        } catch (\Exception $e) {}

        // 17. clients indexes
        try {
            DB::statement('CREATE INDEX IF NOT EXISTS clients_first_name_index ON clients(first_name)');
            DB::statement('CREATE INDEX IF NOT EXISTS clients_last_name_index ON clients(last_name)');
        } catch (\Exception $e) {}

        // 18. adoption_pets indexes
        try {
            DB::statement('CREATE INDEX IF NOT EXISTS adoption_pets_species_index ON adoption_pets(species)');
            DB::statement('CREATE INDEX IF NOT EXISTS adoption_pets_gender_index ON adoption_pets(gender)');
            DB::statement('CREATE INDEX IF NOT EXISTS adoption_pets_is_approved_index ON adoption_pets(is_approved)');
        } catch (\Exception $e) {}

        // 19. traits indexes
        try {
            DB::statement('CREATE INDEX IF NOT EXISTS traits_name_index ON traits(name)');
        } catch (\Exception $e) {}

        // 20. pet_traits indexes
        try {
            DB::statement('CREATE INDEX IF NOT EXISTS pet_traits_adoption_index ON pet_traits(adoption_id)');
            DB::statement('CREATE INDEX IF NOT EXISTS pet_traits_trait_id_index ON pet_traits(trait_id)');
        } catch (\Exception $e) {}
    }

    public function down(): void
    {
        // Not reversing - this is a critical fix
    }
};