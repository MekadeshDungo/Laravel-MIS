<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('livestock', function (Blueprint $table) {
            $table->id('livestock_id');
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->unsignedBigInteger('barangay_id')->nullable();
            $table->string('species');
            $table->string('breed')->nullable();
            $table->string('color')->nullable();
            $table->enum('gender', ['male', 'female', 'unknown'])->default('unknown');
            $table->integer('age')->nullable();
            $table->enum('age_unit', ['years', 'months', 'weeks'])->default('years');
            $table->string('tag_number')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('owner_contact')->nullable();
            $table->text('address')->nullable();
            $table->enum('status', ['active', 'sold', 'deceased', 'slaughtered'])->default('active');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('recorded_by')->nullable();
            $table->timestamps();

            $table->foreign('owner_id')->references('client_id')->on('clients')->onDelete('set null');
            $table->foreign('barangay_id')->references('barangay_id')->on('barangays')->onDelete('set null');
            $table->foreign('recorded_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livestock');
    }
};
