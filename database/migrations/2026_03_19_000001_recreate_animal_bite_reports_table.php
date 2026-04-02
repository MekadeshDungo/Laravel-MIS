<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('animal_bite_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('patient_name');
            $table->integer('patient_age');
            $table->enum('patient_sex', ['male', 'female']);
            $table->text('patient_address');
            $table->string('barangay');
            $table->string('bite_date');
            $table->string('bite_location');
            $table->string('animal_type');
            $table->string('animal_ownership')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('owner_address')->nullable();
            $table->string('animal_status')->nullable(); // rabid, vaccinated, unknown
            $table->string('vaccination_status')->nullable();
            $table->string('treatment_given')->nullable();
            $table->string('referral_hospital')->nullable();
            $table->string('status')->default('pending');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animal_bite_reports');
    }
};
