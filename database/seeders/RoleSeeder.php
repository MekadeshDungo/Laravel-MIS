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
            // Thesis Primary Roles (7 roles)
            [
                'role_name' => 'super_admin',
                'description' => 'Super Administrator (IT) - Full system control and technical administration',
            ],
            [
                'role_name' => 'city_vet',
                'description' => 'City Veterinarian (Admin/Office Head) - Analytics, monitoring, decision-making',
            ],
            [
                'role_name' => 'admin_staff',
                'description' => 'Administrative Staff (Book Binder 4) - Clerical operations, client service, adoption management, portal gatekeeper',
            ],
            [
                'role_name' => 'assistant_vet',
                'description' => 'Assistant Veterinarian (Vet 3) - Medical records, vaccination, clinical actions, cruelty assessment',
            ],
            [
                'role_name' => 'livestock_inspector',
                'description' => 'Livestock Inspector (Book Binder 1) - Farm profiling, livestock census, business profiling',
            ],
            [
                'role_name' => 'meat_inspector',
                'description' => 'Meat & Post-Abattoir Inspector - Establishment profiling, compliance monitoring',
            ],
            [
                'role_name' => 'citizen',
                'description' => 'Citizen (Pet Owner) - Pet owner portal access',
            ],
            // Legacy/Additional roles (for backward compatibility)
            [
                'role_name' => 'admin_asst',
                'description' => 'Legacy alias for admin_staff - Administrative Assistant IV',
            ],
            [
                'role_name' => 'disease_control',
                'description' => 'Legacy alias for assistant_vet - Assistant Veterinary Personnel',
            ],
            [
                'role_name' => 'veterinarian',
                'description' => 'Veterinarian (Clinic) - Veterinary clinic operations',
            ],
            [
                'role_name' => 'viewer',
                'description' => 'Viewer (Read-only) - Can view reports and dashboards only',
            ],
            [
                'role_name' => 'records_staff',
                'description' => 'Records Staff - Pet registration, owner records, vaccination encoding',
            ],
            [
                'role_name' => 'barangay_encoder',
                'description' => 'Barangay Encoder - Submit stray reports, manage impounds, adoption requests',
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
