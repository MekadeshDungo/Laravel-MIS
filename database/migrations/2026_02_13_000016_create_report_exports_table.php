<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_exports', function (Blueprint $table) {
            $table->id();
            $table->string('report_type');
            $table->json('parameters')->nullable();
            $table->string('file_path')->nullable();
            $table->foreignId('exported_by_user_id')->nullable()->constrained('admin_users')->onDelete('set null');
            $table->timestamp('exported_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_exports');
    }
};
