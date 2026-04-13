<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'exposure_cases' => 'user_id',
            'barangay_users' => 'user_id',
            'stray_reports' => 'reported_by_user_id',
            'impound_status_histories' => 'updated_by_user_id',
            'adoption_status_histories' => 'updated_by_user_id',
            'notifications' => 'user_id',
            'establishments' => 'user_id',
            'livestock_censuses' => 'encoded_by_user_id',
            'rabies_cases' => 'user_id',
            'form_submissions' => ['user_id', 'submitted_by'],
            'service_forms' => 'user_id',
            'impounds' => 'user_id',
            'meat_establishments' => 'user_id',
            'meat_inspections' => 'user_id',
            'livestock' => 'recorded_by',
            'bite_rabies_reports' => 'user_id',
            'meat_shop_inspections' => 'user_id',
            'inventory_controls' => 'created_by',
            'inventory_movements' => 'performed_by',
            'report_exports' => 'exported_by_user_id',
            'system_logs' => 'user_id',
            'clinical_actions' => ['assigned_to', 'created_by'],
            'medical_records' => ['veterinarian_id', 'created_by'],
            'cruelty_reports' => ['investigated_by', 'created_by'],
        ];

        foreach ($tables as $table => $columns) {
            $columns = is_array($columns) ? $columns : [$columns];
            foreach ($columns as $column) {
                $this->fixForeignKey($table, $column);
            }
        }
    }

    private function fixForeignKey(string $table, string $column): void
    {
        if (!Schema::hasTable($table)) {
            return;
        }

        $fkName = $this->getForeignKeyName($table, $column);
        if ($fkName) {
            try {
                DB::statement("ALTER TABLE {$table} DROP FOREIGN KEY {$fkName}");
                DB::statement("ALTER TABLE {$table} ADD CONSTRAINT {$fkName} FOREIGN KEY ({$column}) REFERENCES admin_users(id) ON DELETE SET NULL");
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
    }
};