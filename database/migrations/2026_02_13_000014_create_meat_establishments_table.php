<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meat_establishments', function (Blueprint $table) {
            $table->id('establishment_id');
            $table->string('establishment_name');
            $table->enum('establishment_type', ['meat_shop', 'slaughterhouse', 'livestock_farm', 'poultry_farm', 'meat_processing_plant'])->nullable();
            $table->string('owner_name')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->text('address_text');
            $table->string('landmark')->nullable();
            $table->string('permit_no')->nullable();
            $table->date('inspection_date')->nullable();
            $table->unsignedBigInteger('barangay_id')->nullable();
            $table->unsignedBigInteger('registered_by_user_id');
            $table->timestamps();

            $table->unique('establishment_name');
            $table->index('barangay_id');
            $table->index('registered_by_user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meat_establishments');
    }
};