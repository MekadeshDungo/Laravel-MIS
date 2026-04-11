<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('impounds', function (Blueprint $table) {
            $table->id('impound_id');
            $table->unsignedBigInteger('animal_id');
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

            $table->foreign('animal_id')
                ->references('animal_id')
                ->on('animals')
                ->cascadeOnDelete();

            $table->foreign('captured_by_user_id')
                ->references('id')
                ->on('admin_users')
                ->cascadeOnDelete();

            $table->index('animal_id');
            $table->index('intake_date');
            $table->index('status');
            $table->index('captured_by_user_id');
            $table->index('current_disposition');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('impounds');
    }
};
