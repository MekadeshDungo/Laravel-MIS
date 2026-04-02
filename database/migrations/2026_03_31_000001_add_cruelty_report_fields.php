<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Add missing fields for public cruelty report submission
     */
    public function up(): void
    {
        // Get existing columns to make migration idempotent
        $columns = DB::getSchemaBuilder()->getColumnListing('cruelty_reports');

        Schema::table('cruelty_reports', function (Blueprint $table) use ($columns) {
            // Add missing fields only if they don't exist
            if (!in_array('report_number', $columns)) {
                $table->string('report_number')->nullable()->after('id');
            }
            if (!in_array('reporter_email', $columns)) {
                $table->string('reporter_email')->nullable()->after('reporter_contact');
            }
            if (!in_array('accused_name', $columns)) {
                $table->string('accused_name')->nullable()->after('reporter_email');
            }
            if (!in_array('accused_address', $columns)) {
                $table->string('accused_address')->nullable()->after('accused_name');
            }
            if (!in_array('location', $columns)) {
                $table->string('location')->nullable()->after('accused_address');
            }
            if (!in_array('incident_date', $columns)) {
                $table->date('incident_date')->nullable()->after('date_reported');
            }
            if (!in_array('animal_type', $columns)) {
                $table->string('animal_type')->nullable()->after('incident_date');
            }
            if (!in_array('animal_description', $columns)) {
                $table->text('animal_description')->nullable()->after('animal_type');
            }
            if (!in_array('animal_count', $columns)) {
                $table->integer('animal_count')->nullable()->after('animal_description');
            }
            if (!in_array('violation_type', $columns)) {
                $table->string('violation_type')->nullable()->after('animal_count');
            }
            if (!in_array('animal_photos', $columns)) {
                $table->text('animal_photos')->nullable()->after('description');
            }
            if (!in_array('witness_affidavit', $columns)) {
                $table->text('witness_affidavit')->nullable()->after('animal_photos');
            }
            if (!in_array('testify_in_court', $columns)) {
                $table->enum('testify_in_court', ['yes', 'no'])->nullable()->after('witness_affidavit');
            }
            if (!in_array('attend_hearings', $columns)) {
                $table->enum('attend_hearings', ['yes', 'no'])->nullable()->after('testify_in_court');
            }
            if (!in_array('outcome', $columns)) {
                $table->string('outcome')->nullable()->after('action_taken');
            }

            // Change status enum - only if it needs updating
            // We need to check what the current enum values are
            try {
                $table->enum('status', ['Pending', 'Investigating', 'Resolved', 'Closed'])->default('Pending')->change();
            } catch (\Exception $e) {
                // If it fails, it might already have the correct values
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cruelty_reports', function (Blueprint $table) {
            $table->dropColumn([
                'report_number',
                'reporter_email',
                'accused_name',
                'accused_address',
                'location',
                'incident_date',
                'animal_type',
                'animal_description',
                'animal_count',
                'violation_type',
                'animal_photos',
                'witness_affidavit',
                'testify_in_court',
                'attend_hearings',
                'outcome',
            ]);
        });
    }
};
