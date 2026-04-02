<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates sample users for each role with access to their dashboards
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@vetmis.gov',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
                'status' => 'active',
                'contact_number' => '091234567890',
            ],
            [
                'name' => 'Dr. Maria Santos',
                'email' => 'cityvet@vetmis.gov',
                'password' => Hash::make('password123'),
                'role' => 'city_vet',
                'status' => 'active',
                'contact_number' => '091234567891',
            ],
            [
                'name' => 'John Doe',
                'email' => 'adminasst@vetmis.gov',
                'password' => Hash::make('password123'),
                'role' => 'admin_asst',
                'status' => 'active',
                'contact_number' => '091234567892',
            ],
            [
                'name' => 'Dr. Pedro Garcia',
                'email' => 'veterinarian@vetmis.gov',
                'password' => Hash::make('password123'),
                'role' => 'veterinarian',
                'status' => 'active',
                'contact_number' => '091234567893',
            ],
            [
                'name' => 'Roberto Cruz',
                'email' => 'livestock@vetmis.gov',
                'password' => Hash::make('password123'),
                'role' => 'livestock_inspector',
                'status' => 'active',
                'contact_number' => '091234567894',
            ],
            [
                'name' => 'Maria Lopez',
                'email' => 'meatinspector@vetmis.gov',
                'password' => Hash::make('password123'),
                'role' => 'meat_inspector',
                'status' => 'active',
                'contact_number' => '091234567895',
            ],
            [
                'name' => 'Sarah Miller',
                'email' => 'records@vetmis.gov',
                'password' => Hash::make('password123'),
                'role' => 'records_staff',
                'status' => 'active',
                'contact_number' => '091234567896',
            ],
            [
                'name' => 'Carlos Reyes',
                'email' => 'diseasecontrol@vetmis.gov',
                'password' => Hash::make('password123'),
                'role' => 'disease_control',
                'status' => 'active',
                'contact_number' => '091234567897',
            ],
            [
                'name' => 'Barangay Encoder',
                'email' => 'barangay@vetmis.gov',
                'password' => Hash::make('password123'),
                'role' => 'barangay_encoder',
                'barangay' => 'Poblacion',
                'status' => 'active',
                'contact_number' => '091234567898',
            ],
            [
                'name' => 'Supervisor',
                'email' => 'viewer@vetmis.gov',
                'password' => Hash::make('password123'),
                'role' => 'viewer',
                'status' => 'active',
                'contact_number' => '091234567899',
            ],
        ];

        foreach ($users as $userData) {
            // Check if user already exists
            $existingUser = User::where('email', $userData['email'])->first();
            
            if (!$existingUser) {
                User::create($userData);
                echo "Created user: {$userData['email']} with role: {$userData['role']}\n";
            } else {
                // Update existing user's role
                $existingUser->update([
                    'role' => $userData['role'],
                    'status' => 'active',
                ]);
                echo "Updated user: {$userData['email']} with role: {$userData['role']}\n";
            }
        }
    }
}
