<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'role_name' => 'super_admin',
                'description' => 'System Administrator - Full system access with account management',
            ],
            [
                'role_name' => 'admin',
                'description' => 'Administrator - System management and user oversight',
            ],
            [
                'role_name' => 'city_vet',
                'description' => 'City Veterinarian - Consolidated reports, planning, regulatory decision-making',
            ],
            [
                'role_name' => 'records_staff',
                'description' => 'Records Staff - Encoding, organizing, maintaining official records',
            ],
            [
                'role_name' => 'disease_control',
                'description' => 'Disease Control Personnel - Animal health programs, vaccination activities',
            ],
            [
                'role_name' => 'meat_inspector',
                'description' => 'Meat Inspector - Inspection results, compliance monitoring, regulatory reports',
            ],
            [
                'role_name' => 'inventory_staff',
                'description' => 'Inventory Staff - Vaccine and supply management',
            ],
            [
                'role_name' => 'barangay_encoder',
                'description' => 'Barangay Encoder - Livestock census data entry, health-related data submission',
            ],
            [
                'role_name' => 'clinic',
                'description' => 'Veterinary Clinic - Submit rabies vaccination reports',
            ],
            [
                'role_name' => 'viewer',
                'description' => 'Viewer - Read-only access to reports',
            ],
            [
                'role_name' => 'citizen',
                'description' => 'Citizen - Public portal access for pet registration',
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['role_name' => $role['role_name']],
                $role
            );
        }
    }
}
