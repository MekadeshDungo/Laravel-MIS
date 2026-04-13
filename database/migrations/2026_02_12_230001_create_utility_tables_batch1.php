<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('impound_records', function (Blueprint $table) {
            $table->id('impound_id');
            $table->unsignedBigInteger('stray_report_id')->nullable();
            $table->string('animal_tag_code')->nullable();
            $table->string('intake_condition')->nullable();
            $table->string('intake_location')->nullable();
            $table->timestamp('intake_date')->useCurrent();
            $table->enum('current_disposition', ['impounded', 'claimed', 'adopted', 'transferred', 'euthanized'])->default('impounded');
            $table->timestamps();
        });

        Schema::create('impound_status_histories', function (Blueprint $table) {
            $table->id('impound_status_id');
            $table->unsignedBigInteger('impound_id');
            $table->string('status');
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('updated_by_user_id')->nullable();
            $table->timestamps();

            $table->foreign('impound_id')->references('impound_id')->on('impound_records')->onDelete('cascade');
            $table->foreign('updated_by_user_id')->references('id')->on('admin_users')->onDelete('set null');
        });

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

        Schema::create('adoption_status_histories', function (Blueprint $table) {
            $table->id('adoption_status_id');
            $table->unsignedBigInteger('adoption_request_id');
            $table->string('status');
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('updated_by_user_id')->nullable();
            $table->timestamps();

            $table->foreign('adoption_request_id')->references('adoption_request_id')->on('adoption_requests')->onDelete('cascade');
            $table->foreign('updated_by_user_id')->references('id')->on('admin_users')->onDelete('set null');
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id('notification_id');
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->text('message');
            $table->enum('related_module', [
                'stray_report', 
                'impound', 
                'adoption', 
                'bite_rabies_report',
                'pet_registration',
                'spay_neuter',
                'livestock',
                'meat_inspection',
                'inventory',
                'user_management',
                'announcement',
                'rabies_case'
            ])->nullable();
            $table->unsignedBigInteger('related_record_id')->nullable();
            $table->boolean('is_read')->default(false);
            $table->string('priority')->default('normal')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('admin_users')->onDelete('cascade');
        });

        Schema::create('spay_neuter_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('admin_users')->onDelete('cascade');
            $table->string('pet_name')->nullable();
            $table->string('pet_type');
            $table->string('pet_breed')->nullable();
            $table->integer('pet_age')->nullable();
            $table->string('pet_sex');
            $table->string('color_markings')->nullable();
            $table->string('owner_name');
            $table->string('owner_contact')->nullable();
            $table->text('owner_address')->nullable();
            $table->enum('procedure_type', ['spay', 'neuter', 'both']);
            $table->date('procedure_date');
            $table->string('veterinarian')->nullable();
            $table->string('clinic_name')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->enum('status', ['scheduled', 'completed', 'cancelled', 'pending'])->default('pending');
            $table->text('remarks')->nullable();
            $table->date('report_date')->default(now());
            $table->string('barangay')->nullable();
            $table->timestamps();
        });

        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('admin_users')->onDelete('cascade');
            $table->string('item_name');
            $table->string('item_code')->unique()->nullable();
            $table->string('category');
            $table->text('description')->nullable();
            $table->string('unit');
            $table->integer('quantity')->default(0);
            $table->integer('min_stock_level')->default(10);
            $table->date('expiry_date')->nullable();
            $table->string('supplier')->nullable();
            $table->decimal('cost_per_unit', 10, 2)->nullable();
            $table->string('location')->nullable();
            $table->enum('status', ['active', 'inactive', 'discontinued'])->default('active');
            $table->timestamps();
        });

        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_item_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained('admin_users')->onDelete('cascade');
            $table->enum('movement_type', ['stock_in', 'stock_out', 'adjustment', 'return']);
            $table->integer('quantity');
            $table->integer('previous_quantity');
            $table->integer('new_quantity');
            $table->string('reference_number')->nullable();
            $table->text('remarks')->nullable();
            $table->date('movement_date')->default(now());
            $table->timestamps();
        });

        Schema::create('service_forms', function (Blueprint $table) {
            $table->id('form_id');
            $table->enum('form_type', ['kapon', 'vaccination', 'pet_registration', 'adoption', 'bite_report', 'stray_report', 'other']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('admin_users')->onDelete('set null');
        });

        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id('submission_id');
            $table->unsignedBigInteger('form_id');
            $table->unsignedBigInteger('submitted_by_user_id')->nullable();
            $table->string('citizen_name')->nullable();
            $table->string('citizen_contact')->nullable();
            $table->text('citizen_address')->nullable();
            $table->json('payload_json')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('review_notes')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->foreign('form_id')->references('form_id')->on('service_forms')->onDelete('cascade');
            $table->foreign('submitted_by_user_id')->references('id')->on('admin_users')->onDelete('set null');
            $table->foreign('reviewed_by')->references('id')->on('admin_users')->onDelete('set null');
        });

        Schema::create('certificate_series', function (Blueprint $table) {
            $table->id('series_id');
            $table->string('series_name');
            $table->integer('year');
            $table->integer('last_number')->default(0);
            $table->string('prefix', 20);
            $table->timestamps();

            $table->unique(['series_name', 'year']);
        });

        Schema::create('livestock_censuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barangay_id')->nullable();
            $table->unsignedBigInteger('encoded_by_user_id')->nullable();
            $table->enum('species', ['cattle', 'carabao', 'swine', 'horse', 'goat', 'dog', 'pigeon']);
            $table->integer('no_of_heads')->default(0);
            $table->integer('no_of_farmers')->default(0);
            $table->year('report_year');
            $table->integer('report_month');
            $table->timestamps();

            $table->foreign('barangay_id')->references('barangay_id')->on('barangays')->onDelete('set null');
            $table->foreign('encoded_by_user_id')->references('id')->on('admin_users')->onDelete('set null');
        });

        Schema::create('system_logs', function (Blueprint $table) {
            $table->id();
            $table->string('log_name')->nullable();
            $table->text('description')->nullable();
            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('event');
            $table->json('properties')->nullable();
            $table->unsignedBigInteger('causer_id')->nullable();
            $table->string('causer_type')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->string('module')->nullable();
            $table->string('action')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('record_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('role')->nullable();

            $table->index('subject_type');
            $table->index('subject_id');
            $table->index('event');
            $table->index('causer_id');
            $table->index('module');
            $table->index('action');
        });

        Schema::create('announcement_reads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('announcement_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('read_at')->useCurrent();

            $table->foreign('user_id')->references('id')->on('admin_users')->onDelete('cascade');
            $table->unique(['announcement_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcement_reads');
        Schema::dropIfExists('system_logs');
        Schema::dropIfExists('livestock_censuses');
        Schema::dropIfExists('certificate_series');
        Schema::dropIfExists('form_submissions');
        Schema::dropIfExists('service_forms');
        Schema::dropIfExists('stock_movements');
        Schema::dropIfExists('inventory_items');
        Schema::dropIfExists('spay_neuter_reports');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('adoption_status_histories');
        Schema::dropIfExists('adoption_requests');
        Schema::dropIfExists('impound_status_histories');
        Schema::dropIfExists('impound_records');
    }
};
