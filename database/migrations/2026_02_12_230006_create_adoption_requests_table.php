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
        Schema::create('adoption_requests', function (Blueprint $table) {
            $table->id('adoption_request_id');
            $table->unsignedBigInteger('impound_id');
            $table->string('adopter_name');
            $table->string('adopter_contact');
            $table->text('address');
            $table->enum('request_status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->timestamp('requested_at')->useCurrent();
            $table->timestamps();

            $table->foreign('impound_id')->references('impound_id')->on('impound_records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adoption_requests');
    }
};
