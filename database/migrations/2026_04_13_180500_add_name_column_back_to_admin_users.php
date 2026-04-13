<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add back 'name' column for backward compatibility with existing code.
     * This column will be computed from first_name, middle_name, last_name.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('admin_users', 'name')) {
            Schema::table('admin_users', function (Blueprint $table) {
                $table->string('name', 255)->nullable()->after('email');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_users', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }
};