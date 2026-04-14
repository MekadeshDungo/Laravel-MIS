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
        Schema::table('pets', function (Blueprint $table) {
            $table->string('pet_image')->nullable()->after('birthdate');
            $table->string('is_neutered')->nullable()->after('pet_image');
            $table->string('is_crossbreed')->nullable()->after('is_neutered');
            $table->string('estimated_age')->nullable()->after('is_crossbreed');
            $table->string('pet_weight')->nullable()->after('estimated_age');
            $table->string('body_mark_image')->nullable()->after('pet_weight');
            $table->text('body_mark_details')->nullable()->after('body_mark_image');
            $table->json('training')->nullable()->after('body_mark_details');
            $table->json('insurance')->nullable()->after('training');
            $table->json('behavior')->nullable()->after('insurance');
            $table->json('likes')->nullable()->after('behavior');
            $table->json('dislikes')->nullable()->after('likes');
            $table->json('diet')->nullable()->after('dislikes');
            $table->json('allergy')->nullable()->after('diet');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->dropColumn([
                'pet_image',
                'is_neutered',
                'is_crossbreed',
                'estimated_age',
                'pet_weight',
                'body_mark_image',
                'body_mark_details',
                'training',
                'insurance',
                'behavior',
                'likes',
                'dislikes',
                'diet',
                'allergy',
            ]);
        });
    }
};
