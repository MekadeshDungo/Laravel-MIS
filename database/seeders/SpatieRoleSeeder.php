<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SpatieRoleSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $roles = [
            // Primary roles
            [
                'name' => 'super_admin',
                'guard_name' => 'web',
            ],
            [
                'name' => 'city_vet',
                'guard_name' => 'web',
            ],
            [
                'name' => 'admin_staff',
                'guard_name' => 'web',
            ],
            [
                'name' => 'assistant_vet',
                'guard_name' => 'web',
            ],
            [
                'name' => 'admin_asst',
                'guard_name' => 'web',
            ],
            [
                'name' => 'disease_control',
                'guard_name' => 'web',
            ],
            [
                'name' => 'livestock_inspector',
                'guard_name' => 'web',
            ],
            [
                'name' => 'meat_inspector',
                'guard_name' => 'web',
            ],
            [
                'name' => 'records_staff',
                'guard_name' => 'web',
            ],
            [
                'name' => 'barangay_encoder',
                'guard_name' => 'web',
            ],
            [
                'name' => 'clinic',
                'guard_name' => 'web',
            ],
            [
                'name' => 'hospital',
                'guard_name' => 'web',
            ],
            [
                'name' => 'citizen',
                'guard_name' => 'web',
            ],
            [
                'name' => 'viewer',
                'guard_name' => 'web',
            ],
            [
                'name' => 'city_pound',
                'guard_name' => 'web',
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name'], 'guard_name' => $role['guard_name']],
                $role
            );
        }

        $firstAdmin = User::orderBy('id', 'asc')->first();
        
        if ($firstAdmin) {
            $roleMapping = [
                'super_admin' => 'super_admin',
                'city_vet' => 'city_vet',
                'admin_staff' => 'admin_staff',
                'admin_asst' => 'admin_staff',
                'records_staff' => 'records_staff',
                'assistant_vet' => 'city_vet',
                'livestock_inspector' => 'city_vet',
                'meat_inspector' => 'city_vet',
                'clinic' => 'city_vet',
                'hospital' => 'city_vet',
                'citizen' => 'citizen',
            ];

            $existingRole = $firstAdmin->role;
            $spatieRole = $roleMapping[$existingRole] ?? 'admin_staff';
            
            $firstAdmin->assignRole($spatieRole);
            
            $this->command->info("Assigned '{$spatieRole}' role to first admin (ID: {$firstAdmin->id})");
        } else {
            $this->command->warn('No admin users found. Please create an admin user first.');
        }
    }
}
