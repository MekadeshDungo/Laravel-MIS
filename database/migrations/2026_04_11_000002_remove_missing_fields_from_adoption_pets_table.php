<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('adoption_pets', function (Blueprint $table) {
            $table->dropColumn(['is_missing', 'missing_since', 'last_seen_location', 'contact_info']);
        });
    }

    public function down(): void
    {
        Schema::table('adoption_pets', function (Blueprint $table) {
            $table->boolean('is_missing')->default(false);
            $table->date('missing_since')->nullable();
            $table->text('last_seen_location')->nullable();
            $table->text('contact_info')->nullable();
        });
    }
};