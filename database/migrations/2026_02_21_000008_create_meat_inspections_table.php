<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meat_inspections', function (Blueprint $table) {
            $table->id('inspection_id');
            $table->unsignedBigInteger('establishment_id')->nullable();
            $table->unsignedBigInteger('inspector_user_id')->nullable();
            $table->string('inspector_name')->nullable();
            $table->string('inspection_type')->nullable();
            $table->date('inspection_date');
            $table->enum('status', ['passed', 'failed', 'conditional'])->default('passed');
            $table->enum('compliance_status', ['compliant', 'non_compliant', 'conditional'])->nullable();
            $table->text('findings')->nullable();
            $table->text('observations')->nullable();
            $table->text('recommendations')->nullable();
            $table->string('overall_rating')->nullable();
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->index('establishment_id');
            $table->index('inspector_user_id');
            $table->index('inspection_date');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meat_inspections');
    }
};
