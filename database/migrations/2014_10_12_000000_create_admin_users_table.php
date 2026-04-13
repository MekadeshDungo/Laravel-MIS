<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('admin_users') && !Schema::hasTable('users')) {
            Schema::create('admin_users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->enum('role', [
                    'super_admin',
                    'city_vet',
                    'admin_asst',
                    'assistant_vet',
                    'livestock_inspector',
                    'meat_inspector',
                    'records_staff',
                    'disease_control',
                    'barangay_encoder',
                    'viewer',
                    'clinic'
                ])->default('viewer');
                $table->string('barangay')->nullable();
                $table->string('contact_number', 15)->nullable();
                $table->text('address')->nullable();
                $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
                $table->rememberToken();
                $table->timestamps();
                
                $table->index('role');
                $table->index('status');
                $table->index('email');
            });
            
            // Update sessions table to reference admin_users if needed
            if (Schema::hasTable('sessions') && Schema::hasColumn('sessions', 'user_id')) {
                try {
                    Schema::table('sessions', function (Blueprint $table) {
                        $table->foreign('user_id')->references('id')->on('admin_users')->onDelete('set null');
                    });
                } catch (\Exception $e) {
                    // FK might already exist
                }
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_users');
    }
};