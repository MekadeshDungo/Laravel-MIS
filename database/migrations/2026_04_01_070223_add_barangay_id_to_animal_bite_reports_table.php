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
        Schema::table('animal_bite_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('barangay_id')->nullable()->after('barangay');
            $table->foreign('barangay_id')->references('barangay_id')->on('barangays')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('animal_bite_reports', function (Blueprint $table) {
            $table->dropForeign(['barangay_id']);
            $table->dropColumn('barangay_id');
        });
    }
};
