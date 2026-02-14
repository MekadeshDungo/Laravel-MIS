<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_forms', function (Blueprint $table) {
            $table->id('form_id');
            $table->enum('form_type', [
                'kapon',
                'vaccination',
                'pet_registration',
                'adoption',
                'bite_report',
                'stray_report',
                'other'
            ]);
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_forms');
    }
};
