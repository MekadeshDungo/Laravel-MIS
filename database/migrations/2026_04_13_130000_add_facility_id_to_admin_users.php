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
            // 1. Rename clinic_id to facility_id if clinic_id exists
            if (Schema::hasColumn('admin_users', 'clinic_id')) {
                $table->renameColumn('clinic_id', 'facility_id');
            } elseif (!Schema::hasColumn('admin_users', 'facility_id')) {
                // Add facility_id if neither exists
                $table->unsignedBigInteger('facility_id')->nullable()->after('barangay_id');
            }

            // 2. Add foreign key to facilities table
            if (Schema::hasColumn('admin_users', 'facility_id') && Schema::hasTable('facilities')) {
                try {
                    $table->foreign('facility_id')
                        ->references('id')
                        ->on('facilities')
                        ->onDelete('set null');
                } catch (\Exception $e) {
                    // FK might already exist
                }
            }

            // 3. Add index
            $table->index('facility_id');
        });
    }

    public function down(): void
    {
        Schema::table('admin_users', function (Blueprint $table) {
            $table->dropForeign(['facility_id']);
            $table->dropColumn(['facility_id']);
        });
    }
};