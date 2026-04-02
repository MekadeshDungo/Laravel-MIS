<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class TestAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates test accounts for all 7 thesis roles
     */
    public function run(): void
    {
        // Note: Roles are stored as strings in users.role column
        // All 7 thesis roles are implemented with backward compatibility aliases

        // ==============================
        // THESIS ROLE 1: SUPER ADMIN
        // ==============================
        User::firstOrCreate(
            ['email' => 'superadmin@vetmis.gov'],
            [
                'name' => 'Super Administrator',
                'password' => bcrypt('password123'),
                'role' => 'super_admin',
                'status' => 'active',
                'contact_number' => '091988877701',
                'address' => 'IT Department, City Hall',
            ]
        );

        // ==============================
        // THESIS ROLE 2: CITY VETERINARIAN
        // ==============================
        User::firstOrCreate(
            ['email' => 'cityvet@vetmis.gov'],
            [
                'name' => 'Dr. Maria Santos',
                'password' => bcrypt('password123'),
                'role' => 'city_vet',
                'status' => 'active',
                'contact_number' => '091988877702',
                'address' => 'City Veterinary Office',
            ]
        );

        // ==============================
        // THESIS ROLE 3: ADMINISTRATIVE STAFF
        // ==============================
        User::firstOrCreate(
            ['email' => 'adminstaff@vetmis.gov'],
            [
                'name' => 'Carmen Rivera',
                'password' => bcrypt('password123'),
                'role' => 'admin_staff',
                'status' => 'active',
                'contact_number' => '091988877703',
                'division' => 'Records Division',
                'address' => 'City Veterinary Office',
            ]
        );

        // ==============================
        // THESIS ROLE 4: ASSISTANT VETERINARIAN
        // ==============================
        User::firstOrCreate(
            ['email' => 'assistantvet@vetmis.gov'],
            [
                'name' => 'Dr. Jose Reyes',
                'password' => bcrypt('password123'),
                'role' => 'assistant_vet',
                'status' => 'active',
                'contact_number' => '091988877704',
                'address' => 'City Veterinary Office',
            ]
        );

        // ==============================
        // THESIS ROLE 5: LIVESTOCK INSPECTOR
        // ==============================
        User::firstOrCreate(
            ['email' => 'livestock@vetmis.gov'],
            [
                'name' => 'Roberto Gonzales',
                'password' => bcrypt('password123'),
                'role' => 'livestock_inspector',
                'status' => 'active',
                'contact_number' => '091988877705',
                'division' => 'Livestock Division',
                'address' => 'City Veterinary Office',
            ]
        );

        // ==============================
        // THESIS ROLE 6: MEAT INSPECTOR
        // ==============================
        User::firstOrCreate(
            ['email' => 'meatinspector@vetmis.gov'],
            [
                'name' => 'Pedro Martinez',
                'password' => bcrypt('password123'),
                'role' => 'meat_inspector',
                'status' => 'active',
                'contact_number' => '091988877706',
                'division' => 'Meat Inspection Division',
                'address' => 'City Slaughterhouse',
            ]
        );

        // ==============================
        // THESIS ROLE 7: CITIZEN (PET OWNER)
        // ==============================
        User::firstOrCreate(
            ['email' => 'citizen@test.com'],
            [
                'name' => 'Juan dela Cruz',
                'password' => bcrypt('password123'),
                'role' => 'citizen',
                'status' => 'active',
                'contact_number' => '091988877707',
                'address' => 'Barangay Salitran, Dasmariñas City',
            ]
        );

        // ==============================
        // LEGACY ACCOUNTS (Backward Compatibility)
        // ==============================

        // Legacy: Assistant Veterinary (alias for assistant_vet)
        User::firstOrCreate(
            ['email' => 'diseasecontrol@vetmis.gov'],
            [
                'name' => 'Miguel Torres',
                'password' => bcrypt('password123'),
                'role' => 'disease_control', // Legacy alias for assistant_vet
                'status' => 'active',
                'contact_number' => '091988877708',
                'address' => 'City Veterinary Office',
            ]
        );

        // Legacy: Admin Assistant (alias for admin_staff)
        User::firstOrCreate(
            ['email' => 'adminasst@vetmis.gov'],
            [
                'name' => 'Lucia Fernandez',
                'password' => bcrypt('password123'),
                'role' => 'admin_asst', // Legacy alias for admin_staff
                'status' => 'active',
                'contact_number' => '091988877709',
                'division' => 'Records Division',
                'address' => 'City Veterinary Office',
            ]
        );

        // Print info
        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('THESIS TEST ACCOUNTS CREATED');
        $this->command->info('========================================');
        $this->command->info('');
        $this->command->info('📋 7 THESIS ROLES:');
        $this->command->info('1. superadmin@vetmis.gov - Super Admin (password123)');
        $this->command->info('2. cityvet@vetmis.gov - City Veterinarian (password123)');
        $this->command->info('3. adminstaff@vetmis.gov - Admin Staff (password123)');
        $this->command->info('4. assistantvet@vetmis.gov - Assistant Vet (password123)');
        $this->command->info('5. livestock@vetmis.gov - Livestock Inspector (password123)');
        $this->command->info('6. meatinspector@vetmis.gov - Meat Inspector (password123)');
        $this->command->info('7. citizen@test.com - Citizen/Pet Owner (password123)');
        $this->command->info('');
        $this->command->info('🔄 LEGACY ACCOUNTS (Backward Compatible):');
        $this->command->info('8. diseasecontrol@vetmis.gov - Assistant Veterinary (password123)');
        $this->command->info('9. adminasst@vetmis.gov - Admin Assistant (password123)');
        $this->command->info('');
    }
}
