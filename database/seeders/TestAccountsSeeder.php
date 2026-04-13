<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class TestAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates test accounts for all roles using Spatie
     */
    public function run(): void
    {
        // ==============================
        // THESIS ROLE 1: SUPER ADMIN
        // ==============================
        $user1 = User::firstOrCreate(
            ['email' => 'superadmin@vetmis.gov'],
            [
                'first_name' => 'Super',
                'last_name' => 'Administrator',
                'password' => bcrypt('password123'),
                'status' => 'active',
                'contact_number' => '09198887701',
            ]
        );
        $user1->assignRole('super_admin');

        // ==============================
        // THESIS ROLE 2: CITY VETERINARIAN
        // ==============================
        $user2 = User::firstOrCreate(
            ['email' => 'cityvet@vetmis.gov'],
            [
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'password' => bcrypt('password123'),
                'status' => 'active',
                'contact_number' => '091988877702',
            ]
        );
        $user2->assignRole('city_vet');

        // ==============================
        // THESIS ROLE 3: ADMINISTRATIVE STAFF
        // ==============================
        $user3 = User::firstOrCreate(
            ['email' => 'adminstaff@vetmis.gov'],
            [
                'first_name' => 'Carmen',
                'last_name' => 'Rivera',
                'password' => bcrypt('password123'),
                'status' => 'active',
                'contact_number' => '091988877703',
            ]
        );
        $user3->assignRole('admin_staff');

        // ==============================
        // THESIS ROLE 4: ASSISTANT VETERINARIAN
        // ==============================
        $user4 = User::firstOrCreate(
            ['email' => 'assistantvet@vetmis.gov'],
            [
                'first_name' => 'Jose',
                'last_name' => 'Reyes',
                'password' => bcrypt('password123'),
                'status' => 'active',
                'contact_number' => '091988877704',
            ]
        );
        $user4->assignRole('assistant_vet');

        // ==============================
        // THESIS ROLE 5: LIVESTOCK INSPECTOR
        // ==============================
        $user5 = User::firstOrCreate(
            ['email' => 'livestock@vetmis.gov'],
            [
                'first_name' => 'Roberto',
                'last_name' => 'Gonzales',
                'password' => bcrypt('password123'),
                'status' => 'active',
                'contact_number' => '091988877705',
            ]
        );
        $user5->assignRole('livestock_inspector');

        // ==============================
        // THESIS ROLE 6: MEAT INSPECTOR
        // ==============================
        $user6 = User::firstOrCreate(
            ['email' => 'meatinspector@vetmis.gov'],
            [
                'first_name' => 'Pedro',
                'last_name' => 'Martinez',
                'password' => bcrypt('password123'),
                'status' => 'active',
                'contact_number' => '091988877706',
            ]
        );
        $user6->assignRole('meat_inspector');

        // ==============================
        // THESIS ROLE 7: CITIZEN (PET OWNER)
        // ==============================
        $user7 = User::firstOrCreate(
            ['email' => 'citizen@test.com'],
            [
                'first_name' => 'Juan',
                'last_name' => 'dela Cruz',
                'password' => bcrypt('password123'),
                'status' => 'active',
                'contact_number' => '091988877707',
            ]
        );
        $user7->assignRole('citizen');

        // ==============================
        // ADDITIONAL ACCOUNTS
        // ==============================

        // Disease Control (alias for assistant_vet)
        $user8 = User::firstOrCreate(
            ['email' => 'diseasecontrol@vetmis.gov'],
            [
                'first_name' => 'Miguel',
                'last_name' => 'Torres',
                'password' => bcrypt('password123'),
                'status' => 'active',
                'contact_number' => '091988877708',
            ]
        );
        $user8->assignRole('disease_control');

        // Admin Assistant
        $user9 = User::firstOrCreate(
            ['email' => 'adminasst@vetmis.gov'],
            [
                'first_name' => 'Lucia',
                'last_name' => 'Fernandez',
                'password' => bcrypt('password123'),
                'status' => 'active',
                'contact_number' => '091988877709',
            ]
        );
        $user9->assignRole('admin_asst');

        // Vet Clinic
        $user10 = User::firstOrCreate(
            ['email' => 'clinic@vetmis.gov'],
            [
                'first_name' => 'Happy Paws',
                'last_name' => 'Veterinary Clinic',
                'password' => bcrypt('password123'),
                'status' => 'active',
                'contact_number' => '091988877710',
            ]
        );
        $user10->assignRole('clinic');

        // Vet Hospital
        $user11 = User::firstOrCreate(
            ['email' => 'hospital@vetmis.gov'],
            [
                'first_name' => 'City Pet',
                'last_name' => 'Hospital',
                'password' => bcrypt('password123'),
                'status' => 'active',
                'contact_number' => '091988877711',
            ]
        );
        $user11->assignRole('hospital');

        // Print info
        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('THESIS TEST ACCOUNTS CREATED');
        $this->command->info('========================================');
        $this->command->info('');
        $this->command->info('📋 ROLES:');
        $this->command->info('1. superadmin@vetmis.gov - Super Admin (password123)');
        $this->command->info('2. cityvet@vetmis.gov - City Veterinarian (password123)');
        $this->command->info('3. adminstaff@vetmis.gov - Admin Staff (password123)');
        $this->command->info('4. assistantvet@vetmis.gov - Assistant Vet (password123)');
        $this->command->info('5. livestock@vetmis.gov - Livestock Inspector (password123)');
        $this->command->info('6. meatinspector@vetmis.gov - Meat Inspector (password123)');
        $this->command->info('7. citizen@test.com - Citizen/Pet Owner (password123)');
        $this->command->info('8. diseasecontrol@vetmis.gov - Disease Control (password123)');
        $this->command->info('9. adminasst@vetmis.gov - Admin Assistant (password123)');
        $this->command->info('10. clinic@vetmis.gov - Vet Clinic (password123)');
        $this->command->info('11. hospital@vetmis.gov - Vet Hospital (password123)');
        $this->command->info('');
    }
}
