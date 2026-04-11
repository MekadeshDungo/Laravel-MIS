<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stray_reports', function (Blueprint $table) {
            $table->id('stray_report_id');
            $table->unsignedBigInteger('barangay_id');
            $table->unsignedBigInteger('reported_by_user_id')->nullable();
            $table->enum('report_type', ['stray', 'nuisance', 'injured']);
            $table->enum('species', ['dog', 'cat', 'other']);
            $table->text('description')->nullable();
            $table->string('location_text')->nullable();
            $table->string('street_address')->nullable();
            $table->string('landmark')->nullable();
            $table->string('photo_path')->nullable();
            $table->enum('urgency_level', ['low', 'medium', 'high'])->default('medium');
            $table->enum('report_status', ['new', 'validated', 'responding', 'closed'])->default('new');
            $table->timestamp('reported_at')->useCurrent();
            $table->timestamps();

            $table->foreign('barangay_id')->references('barangay_id')->on('barangays')->onDelete('cascade');
            $table->foreign('reported_by_user_id')->references('id')->on('admin_users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stray_reports');
    }
};
