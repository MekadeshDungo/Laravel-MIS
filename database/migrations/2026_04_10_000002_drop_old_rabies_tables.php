<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop legacy tables that were replaced by bite_rabies_reports
        $tables = ['exposure_cases', 'rabies_cases', 'rabies_reports', 'animal_bite_reports'];
        
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::dropIfExists($table);
            }
        }
    }

    public function down(): void
    {
        // Not recreating - these are now in bite_rabies_reports
    }
};