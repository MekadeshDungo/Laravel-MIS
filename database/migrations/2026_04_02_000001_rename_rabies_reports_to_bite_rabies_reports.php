<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('rabies_reports', 'bite_rabies_reports');
    }

    public function down(): void
    {
        Schema::rename('bite_rabies_reports', 'rabies_reports');
    }
};
