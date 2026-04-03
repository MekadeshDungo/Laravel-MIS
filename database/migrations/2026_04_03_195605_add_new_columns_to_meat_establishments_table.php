<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meat_establishments', function (Blueprint $table) {
            $table->enum('establishment_type', ['meat_shop', 'slaughterhouse', 'livestock_farm', 'poultry_farm', 'meat_processing_plant'])->nullable()->after('establishment_name');
            $table->string('contact_person')->nullable()->after('owner_name');
            $table->string('contact_number')->nullable()->after('contact_person');
            $table->string('email')->nullable()->after('contact_number');
            $table->string('landmark')->nullable()->after('address_text');
        });
    }

    public function down(): void
    {
        Schema::table('meat_establishments', function (Blueprint $table) {
            $table->dropColumn(['establishment_type', 'contact_person', 'contact_number', 'email', 'landmark']);
        });
    }
};