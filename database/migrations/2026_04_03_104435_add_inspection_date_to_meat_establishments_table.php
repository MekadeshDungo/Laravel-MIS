<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meat_establishments', function (Blueprint $table) {
            $table->date('inspection_date')->nullable()->after('permit_no');
        });
    }

    public function down(): void
    {
        Schema::table('meat_establishments', function (Blueprint $table) {
            $table->dropColumn('inspection_date');
        });
    }
};
