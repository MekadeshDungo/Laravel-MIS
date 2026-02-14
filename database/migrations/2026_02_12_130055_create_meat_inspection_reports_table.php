<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meat_inspection_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('establishment_name');
            $table->string('establishment_type');
            $table->string('establishment_address');
            $table->string('owner_name');
            $table->string('owner_contact');
            $table->date('inspection_date');
            $table->time('inspection_time');
            $table->string('inspector_name');
            $table->enum('inspection_type', ['routine', 'complaint', 'follow_up', 'special']);
            $table->enum('overall_rating', ['excellent', 'good', 'satisfactory', 'poor', 'failed']);
            $table->text('findings')->nullable();
            $table->text('observations')->nullable();
            $table->text('recommendations')->nullable();
            $table->enum('compliance_status', ['pending', 'compliant', 'non_compliant', 'warning', 'closed'])->default('pending');
            $table->string('penalty_imposed')->nullable();
            $table->date('next_inspection_date')->nullable();
            $table->string('attachments')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meat_inspection_reports');
    }
};
