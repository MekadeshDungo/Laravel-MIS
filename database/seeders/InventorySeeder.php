<?php

namespace Database\Seeders;

use App\Models\InventoryItem;
use App\Models\StockMovement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'user_id' => 1,
                'item_name' => 'Rabies Vaccine (Inactivated)',
                'item_code' => 'RAB-001',
                'category' => 'vaccine',
                'description' => 'Inactivated rabies vaccine for dogs and cats',
                'unit' => 'vials',
                'quantity' => 150,
                'min_stock_level' => 50,
                'expiry_date' => now()->addMonths(6),
                'supplier' => 'Veterinary Pharma Inc.',
                'cost_per_unit' => 150.00,
                'location' => 'Cold Storage A',
                'status' => 'active',
            ],
            [
                'user_id' => 1,
                'item_name' => 'Deworming Tablet (Broad Spectrum)',
                'item_code' => 'DEW-001',
                'category' => 'medication',
                'description' => 'Broad spectrum deworming medication',
                'unit' => 'tablets',
                'quantity' => 500,
                'min_stock_level' => 100,
                'expiry_date' => now()->addMonths(12),
                'supplier' => 'Animal Health Co.',
                'cost_per_unit' => 25.00,
                'location' => 'Storage B',
                'status' => 'active',
            ],
            [
                'user_id' => 1,
                'item_name' => '5-in-1 Vaccine (DHPPiL)',
                'item_code' => 'VAC-005',
                'category' => 'vaccine',
                'description' => 'Combination vaccine for dogs',
                'unit' => 'vials',
                'quantity' => 80,
                'min_stock_level' => 30,
                'expiry_date' => now()->addMonths(4),
                'supplier' => 'Veterinary Pharma Inc.',
                'cost_per_unit' => 200.00,
                'location' => 'Cold Storage A',
                'status' => 'active',
            ],
            [
                'user_id' => 1,
                'item_name' => 'Antibiotic (Amoxicillin)',
                'item_code' => 'ANT-001',
                'category' => 'medication',
                'description' => 'Broad spectrum antibiotic',
                'unit' => 'capsules',
                'quantity' => 200,
                'min_stock_level' => 50,
                'expiry_date' => now()->addMonths(8),
                'supplier' => 'Pharma Vet Corp.',
                'cost_per_unit' => 15.00,
                'location' => 'Storage B',
                'status' => 'active',
            ],
            [
                'user_id' => 1,
                'item_name' => 'Syringe (3ml)',
                'item_code' => 'SUP-001',
                'category' => 'supplies',
                'description' => '3ml disposable syringe with needle',
                'unit' => 'pieces',
                'quantity' => 20,
                'min_stock_level' => 100,
                'expiry_date' => null,
                'supplier' => 'Medical Supplies Inc.',
                'cost_per_unit' => 5.00,
                'location' => 'Supplies Cabinet',
                'status' => 'active',
            ],
            [
                'user_id' => 1,
                'item_name' => 'Rabies Vaccine (Expired)',
                'item_code' => 'RAB-002',
                'category' => 'vaccine',
                'description' => 'Expired rabies vaccine - for disposal',
                'unit' => 'vials',
                'quantity' => 30,
                'min_stock_level' => 50,
                'expiry_date' => now()->subMonths(2),
                'supplier' => 'Veterinary Pharma Inc.',
                'cost_per_unit' => 150.00,
                'location' => 'Quarantine Area',
                'status' => 'inactive',
            ],
            [
                'user_id' => 1,
                'item_name' => 'FVRCP Vaccine (Cats)',
                'item_code' => 'VAC-FVR',
                'category' => 'vaccine',
                'description' => 'Feline viral rhinotracheitis, calicivirus, panleukopenia',
                'unit' => 'vials',
                'quantity' => 10,
                'min_stock_level' => 20,
                'expiry_date' => now()->addMonths(5),
                'supplier' => 'Cat Health Ltd.',
                'cost_per_unit' => 180.00,
                'location' => 'Cold Storage B',
                'status' => 'active',
            ],
            [
                'user_id' => 1,
                'item_name' => 'Surgical Gloves (Medium)',
                'item_code' => 'SUP-GL',
                'category' => 'supplies',
                'description' => 'Disposable surgical gloves - medium size',
                'unit' => 'pairs',
                'quantity' => 45,
                'min_stock_level' => 50,
                'expiry_date' => now()->addMonths(18),
                'supplier' => 'Safety First Inc.',
                'cost_per_unit' => 20.00,
                'location' => 'Surgery Room',
                'status' => 'active',
            ],
        ];

        foreach ($items as $item) {
            $newItem = InventoryItem::create($item);

            // Create initial stock movement
            if ($item['quantity'] > 0 && $item['expiry_date'] !== null && strtotime($item['expiry_date']) > time()) {
                StockMovement::create([
                    'inventory_item_id' => $newItem->id,
                    'user_id' => 1,
                    'movement_type' => 'stock_in',
                    'quantity' => $item['quantity'],
                    'previous_quantity' => 0,
                    'new_quantity' => $item['quantity'],
                    'reference_number' => 'INITIAL-' . $newItem->item_code,
                    'remarks' => 'Initial stock entry',
                    'movement_date' => now()->subDays(30),
                ]);
            }
        }
    }
}
