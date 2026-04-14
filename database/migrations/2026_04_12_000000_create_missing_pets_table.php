<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('missing_pets')) {
            Schema::create('missing_pets', function (Blueprint $table) {
            $table->id('missing_id');
            $table->string('name');
            $table->string('species');
            $table->string('breed')->nullable();
            $table->integer('age')->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->string('color')->nullable();
            $table->enum('gender', ['male', 'female', 'unknown'])->default('unknown');
            $table->datetime('last_seen_at');
            $table->text('description')->nullable();
            $table->string('location');
            $table->enum('status', ['missing', 'found', 'reunited'])->default('missing');
            $table->string('photo_img')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('missing_pets');
    }
};