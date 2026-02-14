<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('livestock_censuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barangay_id')->nullable();
            $table->unsignedBigInteger('encoded_by_user_id')->nullable();
            $table->enum('species', ['cattle', 'carabao', 'swine', 'horse', 'goat', 'dog', 'pigeon']);
            $table->integer('no_of_heads')->default(0);
            $table->integer('no_of_farmers')->default(0);
            $table->year('report_year');
            $table->integer('report_month');
            $table->timestamps();

            $table->foreign('barangay_id')->references('barangay_id')->on('barangays')->onDelete('set null');
            $table->foreign('encoded_by_user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livestock_censuses');
    }
};
