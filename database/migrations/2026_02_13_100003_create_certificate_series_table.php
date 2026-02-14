<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificate_series', function (Blueprint $table) {
            $table->id('series_id');
            $table->string('series_name');
            $table->integer('year');
            $table->integer('last_number')->default(0);
            $table->string('prefix', 20);
            $table->timestamps();

            $table->unique(['series_name', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificate_series');
    }
};
