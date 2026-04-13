<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('meat_shop_inspections');

        Schema::create('meat_shop_inspections', function (Blueprint $table) {
            $table->id();
            // FK will be added after meat_establishments is created
            $table->unsignedBigInteger('meat_shop_id')->nullable();
            $table->string('address')->nullable();
            $table->date('inspection_date')->default(date('Y-m-d'));
            $table->string('ticket_number')->nullable();
            $table->enum('licensing', ['compliant', 'non_compliant'])->nullable();
            $table->enum('storage', ['compliant', 'non_compliant'])->nullable();
            $table->enum('meat_quality', ['compliant', 'non_compliant'])->nullable();
            $table->enum('sanitation', ['compliant', 'non_compliant'])->nullable();
            $table->enum('lighting', ['compliant', 'non_compliant'])->nullable();
            $table->enum('personal_hygiene', ['compliant', 'non_compliant'])->nullable();
            $table->enum('equipment', ['compliant', 'non_compliant'])->nullable();
            $table->enum('apprehension_status', ['none', '1st_warning', '2nd_warning', '3rd_warning'])->default('none');
            $table->unsignedBigInteger('apprehended_by_user_id')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->index('meat_shop_id');
            $table->index('inspection_date');
            $table->index('apprehended_by_user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meat_shop_inspections');
    }
};
