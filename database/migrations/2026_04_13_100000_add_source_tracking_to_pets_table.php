<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->string('source_module', 50)->nullable()->after('allergy');
            $table->unsignedBigInteger('source_module_id')->nullable()->after('source_module');
            $table->boolean('is_approved')->default(false)->after('source_module_id');
            $table->timestamp('consolidated_at')->nullable()->after('is_approved');
            $table->string('pet_status')->nullable()->after('consolidated_at');

            $table->index('source_module');
            $table->index(['source_module', 'source_module_id']);
        });
    }

    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->dropIndex(['source_module', 'source_module_id']);
            $table->dropColumn(['source_module', 'source_module_id', 'is_approved', 'consolidated_at', 'pet_status']);
        });
    }
};