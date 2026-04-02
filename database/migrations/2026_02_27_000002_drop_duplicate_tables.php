<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Drop old duplicate tables that were replaced by newer tables:
     * - animal_bite_reports -> replaced by bite_incidents + bite_followups
     * - impound_records -> replaced by impounds
     * - pets -> replaced by animals
     * - meat_inspection_reports -> replaced by meat_inspections
     *
     * NOTE: 'establishments' table was intentionally kept as it serves a different
     * purpose than 'meat_establishments' (vet clinics, pet shops, etc.)
     */
    public function up(): void
    {
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Drop duplicate tables (NOTE: establishments table is kept - see comment above)
        Schema::dropIfExists('animal_bite_reports');
        Schema::dropIfExists('impound_records');
        Schema::dropIfExists('pets');
        Schema::dropIfExists('meat_inspection_reports');

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration cannot be easily reversed as the table structures
        // would need to be recreated from the original migrations
    }
};
