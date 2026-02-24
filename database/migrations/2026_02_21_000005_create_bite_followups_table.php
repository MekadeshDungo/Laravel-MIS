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
        Schema::create('bite_followups', function (Blueprint $table) {
            $table->id('followup_id');
            $table->unsignedBigInteger('incident_id');
            $table->date('followup_date');
            $table->text('action_taken');
            $table->text('outcome')->nullable();
            $table->unsignedBigInteger('handled_by_user_id');
            $table->timestamps();

            $table->foreign('incident_id')
                ->references('incident_id')
                ->on('bite_incidents')
                ->cascadeOnDelete();

            $table->foreign('handled_by_user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            // Indexes
            $table->index('incident_id');
            $table->index('followup_date');
            $table->index('handled_by_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bite_followups');
    }
};
