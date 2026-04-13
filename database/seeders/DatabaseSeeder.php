<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * Roles are now managed via Spatie Laravel Permission.
     * The legacy role column has been removed.
     */
    public function run(): void
    {
        // Ensure Spatie roles exist first
        $this->call([
            SpatieRoleSeeder::class,
        ]);

        // ==============================
        // 1. SUPER ADMIN (IT Personnel)
        // Full system control
        // ==============================
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@vetmis.gov'],
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'password' => bcrypt('password123'),
                'status' => 'active',
                'contact_number' => '091234567890',
            ]
        );
        $superAdmin->assignRole('super_admin');

        // ==============================
        // 2. CITY VETERINARIAN (Admin/Office Head)
        // Analytics, monitoring, decision-making
        // ==============================
        $cityVet = User::firstOrCreate(
            ['email' => 'cityvet@vetmis.gov'],
            [
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'password' => bcrypt('password123'),
                'status' => 'active',
                'contact_number' => '091234567891',
            ]
        );
        $cityVet->assignRole('city_vet');

        // ==============================
        // 3. ADMINISTRATIVE ASSISTANT IV
        // Clerical operations, adoption management
        // ==============================
        $adminStaff = User::firstOrCreate(
            ['email' => 'adminstaff@vet.gov.ph'],
            [
                'first_name' => 'Admin',
                'last_name' => 'Staff',
                'password' => bcrypt('password123'),
                'status' => 'active',
                'contact_number' => '091234567892',
            ]
        );
        $adminStaff->assignRole('admin_staff');

        // ==============================
        // 4. VETERINARIAN III (Assistant Vet)
        // Medical records, vaccination
        // ==============================
        $assistantVet = User::firstOrCreate(
            ['email' => 'assistant_vet@vetmis.gov'],
            [
                'first_name' => 'Pedro',
                'last_name' => 'Garcia',
                'password' => bcrypt('password123'),
                'status' => 'active',
                'contact_number' => '091234567893',
            ]
        );
        $assistantVet->assignRole('assistant_vet');

        // ==============================
        // 5. LIVESTOCK INSPECTOR
        // Farm profiling, livestock tracking
        // ==============================
        $livestock = User::firstOrCreate(
            ['email' => 'livestock@vetmis.gov'],
            [
                'first_name' => 'Roberto',
                'last_name' => 'Cruz',
                'password' => bcrypt('password123'),
                'status' => 'active',
                'contact_number' => '091234567894',
            ]
        );
        $livestock->assignRole('livestock_inspector');

        // ==============================
        // 6. MEAT INSPECTOR
        // Establishment profiling, compliance
        // ==============================
        $meatInspector = User::firstOrCreate(
            ['email' => 'meatinspector@vetmis.gov'],
            [
                'first_name' => 'Maria',
                'last_name' => 'Lopez',
                'password' => bcrypt('password123'),
                'status' => 'active',
                'contact_number' => '091234567895',
            ]
        );
        $meatInspector->assignRole('meat_inspector');

        // ==============================
        // 7. RECORDS STAFF
        // Encoding, organizing records
        // ==============================
        $recordsStaff = User::firstOrCreate(
            ['email' => 'records@vetmis.gov'],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Miller',
                'password' => bcrypt('password123'),
                'status' => 'active',
                'contact_number' => '091234567896',
            ]
        );
        $recordsStaff->assignRole('records_staff');

        // ==============================
        // 8. DISEASE CONTROL PERSONNEL
        // Animal health, vaccination, rabies monitoring
        // ==============================
        $diseaseControl = User::firstOrCreate(
            ['email' => 'diseasecontrol@vetmis.gov'],
            [
                'first_name' => 'Carlos',
                'last_name' => 'Reyes',
                'password' => bcrypt('password123'),
                'status' => 'active',
                'contact_number' => '091234567897',
            ]
        );
        $diseaseControl->assignRole('disease_control');

        // ==============================
        // 9. BARANGAY ENCODER
        // Data entry
        // ==============================
        $barangayEncoder = User::firstOrCreate(
            ['email' => 'barangay@vetmis.gov'],
            [
                'first_name' => 'Barangay',
                'last_name' => 'Encoder',
                'password' => bcrypt('password123'),
                'status' => 'active',
                'contact_number' => '091234567898',
            ]
        );
        $barangayEncoder->assignRole('barangay_encoder');

        // ==============================
        // 10. VIEWER / SUPERVISOR
        // Read-only access
        // ==============================
        $viewer = User::firstOrCreate(
            ['email' => 'viewer@vetmis.gov'],
            [
                'first_name' => 'Supervisor',
                'last_name' => 'Viewer',
                'password' => bcrypt('password123'),
                'status' => 'active',
                'contact_number' => '091234567899',
            ]
        );
        $viewer->assignRole('viewer');

        // Run BarangaySeeder AFTER users are created
        $this->call([
            BarangaySeeder::class,
        ]);

        // Run additional seeders
        $this->call([
            AdoptionTraitsSeeder::class,
            AdoptionPetsSeeder::class,
        ]);
    }
}
