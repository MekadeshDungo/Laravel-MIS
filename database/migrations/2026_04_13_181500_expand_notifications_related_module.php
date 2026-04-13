<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add 'announcement' and other missing modules to related_module enum.
     */
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Drop the enum and recreate with more options
            $table->enum('related_module', [
                'announcement',
                'stray_report',
                'impound',
                'adoption',
                'bite_rabies_report',
                'vaccination',
                'clinical_action',
                'meat_inspection',
                'missing_pet',
                'system_log'
            ])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->enum('related_module', [
                'stray_report',
                'impound',
                'adoption',
                'bite_rabies_report'
            ])->change();
        });
    }
};