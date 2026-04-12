<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bite_rabies_reports', function (Blueprint $table) {
            $table->string('patient_first_name')->nullable()->after('patient_name');
            $table->string('patient_middle_name')->nullable()->after('patient_first_name');
            $table->string('patient_suffix')->nullable()->after('patient_middle_name');
        });
    }

    public function down(): void
    {
        Schema::table('bite_rabies_reports', function (Blueprint $table) {
            $table->dropColumn(['patient_first_name', 'patient_middle_name', 'patient_suffix']);
        });
    }
};