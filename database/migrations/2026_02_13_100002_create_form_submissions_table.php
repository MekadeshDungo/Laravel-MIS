<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id('submission_id');
            $table->unsignedBigInteger('form_id');
            $table->unsignedBigInteger('submitted_by_user_id')->nullable();
            $table->string('citizen_name')->nullable();
            $table->string('citizen_contact')->nullable();
            $table->text('citizen_address')->nullable();
            $table->json('payload_json')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('review_notes')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->foreign('form_id')
                ->references('form_id')
                ->on('service_forms')
                ->onDelete('cascade');

            $table->foreign('submitted_by_user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->foreign('reviewed_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_submissions');
    }
};
