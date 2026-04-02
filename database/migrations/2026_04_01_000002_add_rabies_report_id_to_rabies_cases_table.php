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
        Schema::table('rabies_cases', function (Blueprint $table) {
            $table->foreignId('rabies_report_id')
                ->nullable()
                ->constrained('rabies_reports')
                ->onDelete('set null')
                ->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rabies_cases', function (Blueprint $table) {
            $table->dropForeign(['rabies_report_id']);
            $table->dropColumn('rabies_report_id');
        });
    }
};
