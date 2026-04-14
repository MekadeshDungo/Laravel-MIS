<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('adoption_pets', function (Blueprint $table) {
            $table->boolean('is_missing')->default(false)->after('image');
            $table->timestamp('missing_since')->nullable()->after('is_missing');
        });
    }

    public function down(): void
    {
        Schema::table('adoption_pets', function (Blueprint $table) {
            $table->dropColumn(['is_missing', 'missing_since']);
        });
    }
};
