<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Inventory Control Module - For tracking inventory items with detailed movements
     */
    public function up(): void
    {
        Schema::create('inventory_controls', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->string('category'); // 'Medicine', 'Vaccine', 'Supply', 'Equipment'
            $table->string('unit')->nullable(); // 'pcs', 'boxes', 'bottles', etc.
            $table->integer('quantity')->default(0);
            $table->integer('minimum_stock')->default(0);
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->date('expiry_date')->nullable();
            $table->foreignId('barangay_id')->nullable()->references('barangay_id')->on('barangays')->onDelete('set null');
            $table->enum('status', ['Active', 'Inactive', 'Out of Stock'])->default('Active');
            $table->foreignId('created_by')->nullable()->constrained('admin_users')->onDelete('set null');
            $table->timestamps();
            
            $table->index('category');
            $table->index('status');
            $table->index('barangay_id');
        });
        
        // Create inventory movement tracking table
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_control_id')->constrained('inventory_controls')->onDelete('cascade');
            $table->enum('movement_type', ['In', 'Out', 'Adjustment', 'Transfer']);
            $table->integer('quantity');
            $table->text('reason')->nullable();
            $table->foreignId('performed_by')->nullable()->constrained('admin_users')->onDelete('set null');
            $table->foreignId('barangay_id')->nullable()->references('barangay_id')->on('barangays')->onDelete('set null');
            $table->timestamps();
            
            $table->index('movement_type');
            $table->index('inventory_control_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
        Schema::dropIfExists('inventory_controls');
    }
};