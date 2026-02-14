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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangay_users');
    }
};
