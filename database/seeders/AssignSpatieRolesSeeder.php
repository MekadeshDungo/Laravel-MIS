<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AssignSpatieRolesSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure roles exist
        $roles = ['super_admin', 'city_vet', 'admin_staff', 'admin_asst', 'assistant_vet', 
                  'meat_inspector', 'livestock_inspector', 'records_staff', 'disease_control', 
                  'barangay_encoder', 'viewer', 'citizen', 'clinic', 'hospital', 'city_pound'];
        
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // Map legacy role column to Spatie roles (using accessor for backward compatibility)
        $users = User::whereDoesntHave('roles')->get();
        
        $roleMapping = [
            'super_admin' => 'super_admin',
            'city_vet' => 'city_vet',
            'admin' => 'city_vet',
            'admin_staff' => 'admin_staff',
            'admin_asst' => 'admin_asst',
            'assistant_vet' => 'assistant_vet',
            'meat_inspector' => 'meat_inspector',
            'livestock_inspector' => 'livestock_inspector',
            'records_staff' => 'records_staff',
            'disease_control' => 'disease_control',
            'barangay_encoder' => 'barangay_encoder',
            'viewer' => 'viewer',
            'citizen' => 'citizen',
            'clinic' => 'clinic',
            'hospital' => 'hospital',
            'city_pound' => 'city_pound',
        ];

        foreach ($users as $user) {
            // Use the role attribute for backward compatibility (reads from Spatie roles)
            $currentRole = $user->getRoleAttribute();
            $spatieRole = $roleMapping[$currentRole] ?? 'viewer';
            
            // Remove existing roles and assign new one
            $user->syncRoles($spatieRole);
            
            $this->command->info("Assigned '{$spatieRole}' to user {$user->email} (was: {$currentRole})");
        }

        $this->command->info('Role migration complete!');
    }
}