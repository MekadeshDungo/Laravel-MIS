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
        Schema::table('meat_inspections', function (Blueprint $table) {
            $table->enum('compliance_status', ['compliant', 'non_compliant', 'conditional'])->nullable()->after('status');
            $table->text('observations')->nullable()->after('compliance_status');
            $table->text('recommendations')->nullable()->after('observations');
            $table->string('inspector_name')->nullable()->after('inspector_user_id');
            $table->string('inspection_type')->nullable()->after('inspector_name');
            $table->string('overall_rating')->nullable()->after('inspection_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meat_inspections', function (Blueprint $table) {
            $table->dropColumn([
                'compliance_status',
                'observations',
                'recommendations',
                'inspector_name',
                'inspection_type',
                'overall_rating',
            ]);
        });
    }
};
