<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users') && !Schema::hasTable('admin_users')) {
            Schema::rename('users', 'admin_users');
        }

        if (Schema::hasTable('admin_users')) {
            $this->dropAndRecreateFK('adoption_status_histories', 'updated_by_user_id', 'admin_users');
            $this->dropAndRecreateFK('barangay_users', 'user_id', 'admin_users');
            $this->dropAndRecreateFK('bite_rabies_reports', 'user_id', 'admin_users');
            $this->dropAndRecreateFK('establishments', 'user_id', 'admin_users');
            $this->dropAndRecreateFK('exposure_cases', 'user_id', 'admin_users');
            $this->dropAndRecreateFK('form_submissions', 'user_id', 'admin_users');
            $this->dropAndRecreateFK('form_submissions', 'submitted_by', 'admin_users');
            $this->dropAndRecreateFK('impound_status_histories', 'updated_by_user_id', 'admin_users');
            $this->dropAndRecreateFK('impounds', 'user_id', 'admin_users');
            $this->dropAndRecreateFK('livestock_censuses', 'encoded_by_user_id', 'admin_users');
            $this->dropAndRecreateFK('livestock', 'recorded_by', 'admin_users');
            $this->dropAndRecreateFK('meat_establishments', 'user_id', 'admin_users');
            $this->dropAndRecreateFK('meat_inspections', 'user_id', 'admin_users');
            $this->dropAndRecreateFK('meat_shop_inspections', 'user_id', 'admin_users');
            $this->dropAndRecreateFK('notifications', 'user_id', 'admin_users');
            $this->dropAndRecreateFK('rabies_cases', 'user_id', 'admin_users');
            $this->dropAndRecreateFK('service_forms', 'user_id', 'admin_users');
            $this->dropAndRecreateFK('sessions', 'user_id', 'admin_users');
            $this->dropAndRecreateFK('stray_reports', 'reported_by_user_id', 'admin_users');
        }
    }

    private function dropAndRecreateFK(string $table, string $column, string $references): void
    {
        if (!Schema::hasTable($table)) {
            return;
        }

        $fkName = $this->getForeignKeyName($table, $column);
        if ($fkName) {
            try {
                DB::statement("ALTER TABLE {$table} DROP FOREIGN KEY {$fkName}");
                DB::statement("ALTER TABLE {$table} ADD CONSTRAINT {$fkName} FOREIGN KEY ({$column}) REFERENCES {$references}(id) ON DELETE SET NULL");
            } catch (\Exception $e) {
            }
        }
    }

    private function getForeignKeyName(string $table, string $column): ?string
    {
        $fks = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = 'vet_mis' AND TABLE_NAME = '{$table}' AND COLUMN_NAME = '{$column}'");
        return $fks[0]->CONSTRAINT_NAME ?? null;
    }

    public function down(): void
    {
        if (Schema::hasTable('admin_users')) {
            Schema::rename('admin_users', 'users');
        }
    }
};