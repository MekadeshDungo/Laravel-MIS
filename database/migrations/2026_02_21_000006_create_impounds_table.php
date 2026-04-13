<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('impounds', function (Blueprint $table) {
            $table->id('impound_id');
            $table->unsignedBigInteger('animal_id')->nullable();
            $table->unsignedBigInteger('stray_report_id')->nullable();
            $table->string('animal_tag_code')->nullable();
            $table->text('intake_condition')->nullable();
            $table->date('intake_date');
            $table->text('intake_location');
            $table->text('impound_reason')->nullable();
            $table->unsignedBigInteger('captured_by_user_id');
            $table->string('current_disposition')->nullable();
            $table->enum('status', ['in_pound', 'released', 'adopted', 'euthanized'])->default('in_pound');
            $table->date('release_date')->nullable();
            $table->timestamps();

            $table->index('animal_id');
            $table->index('intake_date');
            $table->index('status');
            $table->index('captured_by_user_id');
            $table->index('current_disposition');
        });

        DB::statement('ALTER TABLE impounds ADD CONSTRAINT impounds_stray_report_id_foreign FOREIGN KEY (stray_report_id) REFERENCES stray_reports(stray_report_id) ON DELETE SET NULL');
        DB::statement('ALTER TABLE impounds ADD CONSTRAINT impounds_captured_by_user_id_foreign FOREIGN KEY (captured_by_user_id) REFERENCES admin_users(id) ON DELETE CASCADE');
    }

    public function down(): void
    {
        Schema::dropIfExists('impounds');
    }
};
