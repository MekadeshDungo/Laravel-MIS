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
        Schema::table('system_logs', function (Blueprint $table) {
            // Add user_agent field as per ERD
            if (!Schema::hasColumn('system_logs', 'user_agent')) {
                $table->text('user_agent')->nullable()->after('ip_address');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('system_logs', function (Blueprint $table) {
            if (Schema::hasColumn('system_logs', 'user_agent')) {
                $table->dropColumn('user_agent');
            }
        });
    }
};
