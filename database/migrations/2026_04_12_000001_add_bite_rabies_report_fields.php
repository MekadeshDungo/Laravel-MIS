<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bite_rabies_reports', function (Blueprint $table) {
            $table->string('date_reported')->nullable()->after('reporting_facility');
        });
    }

    public function down(): void
    {
        Schema::table('bite_rabies_reports', function (Blueprint $table) {
            $table->dropColumn('date_reported');
        });
    }
};