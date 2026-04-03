<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->boolean('is_missing')->default(false)->after('status');
            $table->date('missing_since')->nullable()->after('is_missing');
            $table->text('last_seen_location')->nullable()->after('missing_since');
            $table->text('contact_info')->nullable()->after('last_seen_location');
        });
    }

    public function down(): void
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->dropColumn(['is_missing', 'missing_since', 'last_seen_location', 'contact_info']);
        });
    }
};