<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE notifications MODIFY COLUMN related_module ENUM('stray_report', 'impound', 'adoption', 'bite_rabies_report') NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE notifications MODIFY COLUMN related_module ENUM('stray_report', 'impound', 'adoption') NULL");
    }
};
