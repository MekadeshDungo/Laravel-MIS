<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('system_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('system_logs', 'module')) {
                $table->string('module')->nullable()->after('event');
            }
            if (!Schema::hasColumn('system_logs', 'action')) {
                $table->string('action')->nullable()->after('module');
            }
            if (!Schema::hasColumn('system_logs', 'status')) {
                $table->string('status')->nullable()->after('action');
            }
            if (!Schema::hasColumn('system_logs', 'record_id')) {
                $table->unsignedBigInteger('record_id')->nullable()->after('status');
            }
            if (!Schema::hasColumn('system_logs', 'ip_address')) {
                $table->string('ip_address')->nullable()->after('record_id');
            }
            if (!Schema::hasColumn('system_logs', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('ip_address');
            }
            if (!Schema::hasColumn('system_logs', 'role')) {
                $table->string('role')->nullable()->after('user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('system_logs', function (Blueprint $table) {
            $table->dropColumn(['module', 'action', 'status', 'record_id', 'ip_address', 'user_id', 'role']);
        });
    }
};