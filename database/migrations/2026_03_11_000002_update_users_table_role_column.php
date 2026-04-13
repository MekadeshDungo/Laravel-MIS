<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('admin_users', function (Blueprint $table) {
            // Drop the enum constraint and change to string
            $table->dropColumn('role');
            $table->string('role', 50)->default('viewer')->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->enum('role', [
                'super_admin',
                'admin',
                'city_vet',
                'records_staff',
                'admin_staff',
                'disease_control',
                'city_pound',
                'meat_inspector',
                'inventory_staff',
                'barangay_encoder',
                'clinic',
                'viewer',
                'citizen',
            ])->default('citizen')->after('password');
        });
    }
};
