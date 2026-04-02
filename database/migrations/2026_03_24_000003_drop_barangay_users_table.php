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
        // First, drop the foreign key constraint on notifications table
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['barangay_user_id']);
            $table->dropColumn('barangay_user_id');
        });

        // Add user_id to notifications table as replacement
        Schema::table('notifications', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('notification_id')->constrained('users')->onDelete('cascade');
            $table->index('user_id');
        });

        // Drop the barangay_users table
        Schema::dropIfExists('barangay_users');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate barangay_users table
        Schema::create('barangay_users', function (Blueprint $table) {
            $table->id('barangay_user_id');
            $table->unsignedBigInteger('barangay_id');
            $table->unsignedBigInteger('user_id');
            $table->string('position_title')->nullable();
            $table->enum('access_level', ['viewer', 'encoder', 'coordinator'])->default('encoder');
            $table->string('status')->default('active');
            $table->timestamps();

            $table->foreign('barangay_id')->references('barangay_id')->on('barangays')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Revert notifications table changes
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('barangay_user_id');
            $table->foreign('barangay_user_id')->references('barangay_user_id')->on('barangay_users')->onDelete('cascade');
        });
    }
};
