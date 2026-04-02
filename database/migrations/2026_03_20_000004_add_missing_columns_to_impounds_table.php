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
        Schema::table('impounds', function (Blueprint $table) {
            $table->renameColumn('impound_date', 'intake_date');
            $table->renameColumn('capture_location_text', 'intake_location');
            $table->string('animal_tag_code')->nullable()->after('animal_id');
            $table->text('intake_condition')->nullable()->after('animal_tag_code');
            $table->string('current_disposition')->nullable()->after('status');
            $table->unsignedBigInteger('stray_report_id')->nullable()->after('animal_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('impounds', function (Blueprint $table) {
            $table->renameColumn('intake_date', 'impound_date');
            $table->renameColumn('intake_location', 'capture_location_text');
            $table->dropColumn([
                'animal_tag_code',
                'intake_condition',
                'current_disposition',
                'stray_report_id',
            ]);
        });
    }
};
