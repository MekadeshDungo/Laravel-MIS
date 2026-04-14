<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->enum('vaccination_status', ['vaccinated', 'unvaccinated', 'pending'])->default('unvaccinated')->after('pet_image');
            $table->date('vaccination_date')->nullable()->after('vaccination_status');
            $table->date('next_vaccination_date')->nullable()->after('vaccination_date');
        });
    }

    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->dropColumn(['vaccination_status', 'vaccination_date', 'next_vaccination_date']);
        });
    }
};