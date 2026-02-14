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
        Schema::create('impound_records', function (Blueprint $table) {
            $table->id('impound_id');
            $table->unsignedBigInteger('stray_report_id')->nullable();
            $table->string('animal_tag_code')->nullable();
            $table->string('intake_condition')->nullable();
            $table->string('intake_location')->nullable();
            $table->timestamp('intake_date')->useCurrent();
            $table->enum('current_disposition', ['impounded', 'claimed', 'adopted', 'transferred', 'euthanized'])->default('impounded');
            $table->timestamps();

            $table->foreign('stray_report_id')->references('stray_report_id')->on('stray_reports')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('impound_records');
    }
};
