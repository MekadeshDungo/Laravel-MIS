<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('attachable_type', 255);
            $table->unsignedBigInteger('attachable_id');
            $table->string('file_path', 500);
            $table->string('file_type', 100)->nullable();
            $table->json('meta')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->index(['attachable_type', 'attachable_id']);
            $table->index('created_by');
        });

        DB::statement('INSERT IGNORE INTO attachments (attachable_type, attachable_id, file_path, file_type, created_at)
            SELECT "pets", p.pet_id, ap.image, "image", NOW()
            FROM adoption_pets ap
            INNER JOIN pets p ON p.source_module = "adoption_pets" AND p.source_module_id = ap.adoption_id
            WHERE ap.image IS NOT NULL AND TRIM(ap.image) != ""');

        DB::statement('INSERT IGNORE INTO attachments (attachable_type, attachable_id, file_path, file_type, created_at)
            SELECT "pets", p.pet_id, mp.image, "image", NOW()
            FROM missing_pets mp
            INNER JOIN pets p ON p.source_module = "missing_pets" AND p.source_module_id = mp.missing_id
            WHERE mp.image IS NOT NULL AND TRIM(mp.image) != ""');
    }

    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};