<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds census-style fields to livestock table for livestock_inspector module.
     */
    public function up(): void
    {
        Schema::table('livestock', function (Blueprint $table) {
            if (!Schema::hasColumn('livestock', 'farm_name')) {
                $table->string('farm_name')->nullable()->after('owner_id');
            }
            if (!Schema::hasColumn('livestock', 'animal_type')) {
                $table->string('animal_type')->nullable()->after('farm_name');
            }
            if (!Schema::hasColumn('livestock', 'quantity')) {
                $table->integer('quantity')->default(1)->after('animal_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('livestock', function (Blueprint $table) {
            $table->dropColumn(['farm_name', 'animal_type', 'quantity']);
        });
    }
};
