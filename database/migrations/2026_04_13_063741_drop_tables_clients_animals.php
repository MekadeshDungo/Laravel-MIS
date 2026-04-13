<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::dropIfExists('animals');
        Schema::dropIfExists('clients');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id('client_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('suffix')->nullable();
            $table->string('email')->unique();
            $table->string('phone_number', 11);
            $table->string('alternate_phone', 11)->nullable();
            $table->string('house_no')->nullable();
            $table->string('street')->nullable();
            $table->string('subdivision')->nullable();
            $table->unsignedBigInteger('barangay_id')->nullable();
            $table->string('city')->default('Dasmariñas');
            $table->string('province')->default('Cavite');
            $table->string('password');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->timestamps();
        });

        Schema::create('animals', function (Blueprint $table) {
            $table->id('animal_id');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('animal_type');
            $table->string('name')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('sex', ['male', 'female', 'unknown'])->nullable();
            $table->string('color')->nullable();
            $table->string('breed')->nullable();
            $table->boolean('is_stray')->default(false);
            $table->enum('status', ['active', 'impounded', 'adopted', 'deceased'])->default('active');
            $table->timestamps();
        });
    }
};
