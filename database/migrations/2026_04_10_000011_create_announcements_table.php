<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop old table if exists (from older migration)
        Schema::dropIfExists('announcements');

        // Create new announcements table
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();

            // Content
            $table->string('title');
            $table->text('content');
            $table->string('attachment_path')->nullable();
            $table->string('photo_path')->nullable();

            // Category (campaign or event)
            $table->enum('category', ['campaign', 'event'])->default('event');

            $table->boolean('is_active')->default(true);

            // Event-specific fields (nullable for campaigns)
            $table->date('event_date')->nullable();
            $table->time('event_time')->nullable();
            $table->string('location')->nullable();

            // Contact info for events
            $table->string('contact_number', 11)->nullable();

            // Metadata
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            // Foreign Key
            $table->foreign('created_by')
                ->references('id')
                ->on('admin_users')
                ->onDelete('set null');

            // Indexes
            $table->index('category');
            $table->index('created_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
