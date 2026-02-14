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
        Schema::table('stray_reports', function (Blueprint $table) {
            // Remove lat/long
            $table->dropColumn(['latitude', 'longitude']);
            
            // Add street_address and photo_path
            $table->string('street_address')->nullable()->after('location_text');
            $table->string('landmark')->nullable()->after('street_address');
            $table->string('photo_path')->nullable()->after('landmark');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stray_reports', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->dropColumn(['street_address', 'landmark', 'photo_path']);
        });
    }
};
