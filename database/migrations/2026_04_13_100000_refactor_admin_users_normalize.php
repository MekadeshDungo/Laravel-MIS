<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admin_users', function (Blueprint $table) {
            // 1. Add name split fields only if they don't exist
            if (!Schema::hasColumn('admin_users', 'first_name')) {
                $table->string('first_name', 100)->nullable()->after('id');
            }
            if (!Schema::hasColumn('admin_users', 'middle_name')) {
                $table->string('middle_name', 100)->nullable()->after('first_name');
            }
            if (!Schema::hasColumn('admin_users', 'last_name')) {
                $table->string('last_name', 100)->nullable()->after('middle_name');
            }
            
            // 2. Add barangay foreign key only if it doesn't exist
            if (!Schema::hasColumn('admin_users', 'barangay_id')) {
                $table->unsignedBigInteger('barangay_id')->nullable()->after('last_name');
            }
            
            // 3. Add clinic_id only if it doesn't exist
            if (!Schema::hasColumn('admin_users', 'clinic_id')) {
                $table->unsignedBigInteger('clinic_id')->nullable()->after('barangay_id');
            }
            
            // 4. Remove legacy columns only if they exist
            $columnsToDrop = [];
            if (Schema::hasColumn('admin_users', 'name')) {
                $columnsToDrop[] = 'name';
            }
            if (Schema::hasColumn('admin_users', 'role')) {
                $columnsToDrop[] = 'role';
            }
            if (Schema::hasColumn('admin_users', 'barangay')) {
                $columnsToDrop[] = 'barangay';
            }
            if (Schema::hasColumn('admin_users', 'clinic_name')) {
                $columnsToDrop[] = 'clinic_name';
            }
            if (Schema::hasColumn('admin_users', 'division')) {
                $columnsToDrop[] = 'division';
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
            
            // 5. Add foreign key if column exists and FK doesn't
            if (Schema::hasColumn('admin_users', 'barangay_id')) {
                try {
                    // Check if foreign key already exists
                    $foreignKeys = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS WHERE TABLE_SCHEMA = 'vet_mis' AND TABLE_NAME = 'admin_users' AND CONSTRAINT_TYPE = 'FOREIGN KEY' AND CONSTRAINT_NAME = 'admin_users_barangay_id_foreign'");
                    if (empty($foreignKeys)) {
                        $table->foreign('barangay_id')
                            ->references('barangay_id')
                            ->on('barangays')
                            ->onDelete('set null');
                    }
                } catch (\Exception $e) {
                    // FK might already exist
                }
            }
            
            // 6. Add indexes
            $table->index('barangay_id');
            $table->index('clinic_id');
        });

        // 7. Data Migration: Move existing 'name' data to name components
        $this->migrateExistingNames();
    }

    /**
     * Migrate existing name field to first_name/last_name
     */
    private function migrateExistingNames(): void
    {
        // Check if name column still exists
        if (!Schema::hasColumn('admin_users', 'name')) {
            return;
        }
        
        $users = DB::table('admin_users')
            ->whereNotNull('name')
            ->where('name', '!=', '')
            ->whereNull('first_name')
            ->get();
        
        foreach ($users as $user) {
            $nameParts = explode(' ', $user->name, 2);
            $firstName = $nameParts[0] ?? '';
            $lastName = $nameParts[1] ?? '';
            
            DB::table('admin_users')
                ->where('id', $user->id)
                ->update([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                ]);
        }
    }

    public function down(): void
    {
        Schema::table('admin_users', function (Blueprint $table) {
            // Remove new columns
            $table->dropForeign(['barangay_id']);
            $table->dropColumn(['first_name', 'middle_name', 'last_name', 'barangay_id', 'clinic_id']);
            
            // Restore old columns
            $table->string('name')->nullable();
            $table->enum('role', [
                'super_admin',
                'city_vet',
                'admin_asst',
                'assistant_vet',
                'livestock_inspector',
                'meat_inspector',
                'records_staff',
                'disease_control',
                'barangay_encoder',
                'viewer',
                'clinic'
            ])->default('viewer')->nullable();
            $table->string('barangay')->nullable();
            $table->string('clinic_name')->nullable();
            $table->string('division')->nullable();
            
            $table->index('role');
        });
    }
};