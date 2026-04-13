<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add back 'role' column for backward compatibility with existing code.
     * This column will be kept in sync with Spatie roles.
     */
    public function up(): void
    {
        // Check if role column doesn't exist
        if (!Schema::hasColumn('admin_users', 'role')) {
            Schema::table('admin_users', function (Blueprint $table) {
                $table->enum('role', [
                    'super_admin',
                    'city_vet',
                    'admin_asst',
                    'admin_staff',
                    'assistant_vet',
                    'disease_control',
                    'livestock_inspector',
                    'meat_inspector',
                    'records_staff',
                    'barangay_encoder',
                    'city_pound',
                    'viewer',
                    'clinic',
                    'hospital',
                    'citizen'
                ])->nullable()->after('last_name')->default('viewer');
            });
        }

        // Sync role column from Spatie roles
        $this->syncRolesFromSpatie();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }

    /**
     * Sync the role column with Spatie roles.
     */
    private function syncRolesFromSpatie(): void
    {
        // Check if Spatie tables exist (they may be prefixed)
        $modelHasRolesTable = Schema::hasTable('spatie_model_has_roles') ? 'spatie_model_has_roles' : 'model_has_roles';
        $rolesTable = Schema::hasTable('spatie_roles') ? 'spatie_roles' : 'roles';

        // Get all users with their roles from Spatie
        $users = DB::table($modelHasRolesTable)
            ->join('admin_users', $modelHasRolesTable . '.model_id', '=', 'admin_users.id')
            ->join($rolesTable, $modelHasRolesTable . '.role_id', '=', $rolesTable . '.id')
            ->select('admin_users.id', $rolesTable . '.name as role_name')
            ->get();

        foreach ($users as $user) {
            DB::table('admin_users')
                ->where('id', $user->id)
                ->update(['role' => $user->role_name]);
        }
    }
};