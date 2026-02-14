<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('item_name');
            $table->string('item_code')->unique()->nullable();
            $table->string('category'); // vaccine, medication, supplies, equipment, etc.
            $table->text('description')->nullable();
            $table->string('unit'); // pieces, bottles, boxes, etc.
            $table->integer('quantity')->default(0);
            $table->integer('min_stock_level')->default(10);
            $table->date('expiry_date')->nullable();
            $table->string('supplier')->nullable();
            $table->decimal('cost_per_unit', 10, 2)->nullable();
            $table->string('location')->nullable(); // storage location
            $table->enum('status', ['active', 'inactive', 'discontinued'])->default('active');
            $table->timestamps();
        });

        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_item_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('movement_type', ['stock_in', 'stock_out', 'adjustment', 'return']);
            $table->integer('quantity'); // positive for in, negative for out
            $table->integer('previous_quantity');
            $table->integer('new_quantity');
            $table->string('reference_number')->nullable(); // delivery note, requisition, etc.
            $table->text('remarks')->nullable();
            $table->date('movement_date')->default(now());
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
        Schema::dropIfExists('inventory_items');
    }
};
