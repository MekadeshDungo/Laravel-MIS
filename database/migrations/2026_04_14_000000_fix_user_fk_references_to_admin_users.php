<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pet_owners') && Schema::hasColumn('pet_owners', 'user_id')) {
            Schema::table('pet_owners', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->foreign('user_id')->references('id')->on('admin_users')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('adoption_applications') && Schema::hasColumn('adoption_applications', 'user_id')) {
            Schema::table('adoption_applications', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->foreign('user_id')->references('id')->on('admin_users')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('missing_pets_reports') && Schema::hasColumn('missing_pets_reports', 'user_id')) {
            Schema::table('missing_pets_reports', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->foreign('user_id')->references('id')->on('admin_users')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        // No rollback needed
    }
};