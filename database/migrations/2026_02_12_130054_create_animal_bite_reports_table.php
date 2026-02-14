<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('animal_bite_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('reporter_name');
            $table->string('reporter_contact');
            $table->string('victim_name');
            $table->integer('victim_age');
            $table->string('victim_gender');
            $table->text('victim_address');
            $table->string('animal_type'); // dog, cat, etc.
            $table->string('animal_owner_name')->nullable();
            $table->string('animal_owner_address')->nullable();
            $table->string('bite_location'); // barangay
            $table->text('bite_description');
            $table->enum('bite_severity', ['minor', 'moderate', 'severe']);
            $table->enum('bite_category', ['provoked', 'unprovoked']);
            $table->string('animal_vaccination_status')->nullable();
            $table->date('bite_date');
            $table->time('bite_time');
            $table->enum('status', ['pending', 'investigating', 'resolved'])->default('pending');
            $table->text('action_taken')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animal_bite_reports');
    }
};
