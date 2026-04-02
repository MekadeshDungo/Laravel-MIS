<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * New Role Structure:
     * 1. super_admin - Super Administrator (IT)
     * 2. city_vet - City Veterinarian (Admin/Office Head)
     * 3. admin_asst - Administrative Assistant IV
     * 4. veterinarian - Veterinarian III (Assistant Vet)
     * 5. livestock_inspector - Livestock Inspector
     * 6. meat_inspector - Meat & Post-Abattoir Inspector
     * 7. records_staff - Records Staff
     * 8. disease_control - Assistant Veterinary Personnel
     * 9. barangay_encoder - Barangay Encoder
     * 10. viewer - Viewer/Supervisor
     */
    public function run(): void
    {
        // Note: Roles are now stored as strings in users.role column
        // No RoleSeeder needed - roles are defined in the enum/string

        // ==============================
        // 1. SUPER ADMIN (IT Personnel)
        // Full system control
        // ==============================
        User::firstOrCreate(
            ['email' => 'superadmin@vetmis.gov'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password123'),
                'role' => 'super_admin',
                'status' => 'active',
                'contact_number' => '091234567890',
                'address' => 'City Veterinary Office',
            ]
        );

        // ==============================
        // 2. CITY VETERINARIAN (Admin/Office Head)
        // Analytics, monitoring, decision-making
        // ==============================
        User::firstOrCreate(
            ['email' => 'cityvet@vetmis.gov'],
            [
                'name' => 'Dr. Maria Santos',
                'password' => bcrypt('password123'),
                'role' => 'city_vet',
                'status' => 'active',
                'contact_number' => '091234567891',
                'address' => 'City Veterinary Office',
            ]
        );

        // ==============================
        // 3. ADMINISTRATIVE ASSISTANT IV
        // Clerical operations, adoption management
        // ==============================
        User::firstOrCreate(
            ['email' => 'adminstaff@vet.gov.ph'],
            [
                'name' => 'Admin Staff',
                'password' => bcrypt('password123'),
                'role' => 'admin_staff', // Primary role - admin_asst is legacy alias
                'status' => 'active',
                'contact_number' => '091234567892',
                'address' => 'City Veterinary Office',
            ]
        );

        // ==============================
        // 4. VETERINARIAN III (Assistant Vet)
        // Medical records, vaccination
        // ==============================
        User::firstOrCreate(
            ['email' => 'veterinarian@vetmis.gov'],
            [
                'name' => 'Dr. Pedro Garcia',
                'password' => bcrypt('password123'),
                'role' => 'veterinarian',
                'status' => 'active',
                'contact_number' => '091234567893',
                'address' => 'City Veterinary Office',
            ]
        );

        // ==============================
        // 5. LIVESTOCK INSPECTOR
        // Farm profiling, livestock tracking
        // ==============================
        User::firstOrCreate(
            ['email' => 'livestock@vetmis.gov'],
            [
                'name' => 'Roberto Cruz',
                'password' => bcrypt('password123'),
                'role' => 'livestock_inspector',
                'status' => 'active',
                'contact_number' => '091234567894',
                'address' => 'City Veterinary Office',
            ]
        );

        // ==============================
        // 6. MEAT INSPECTOR
        // Establishment profiling, compliance
        // ==============================
        User::firstOrCreate(
            ['email' => 'meatinspector@vetmis.gov'],
            [
                'name' => 'Maria Lopez',
                'password' => bcrypt('password123'),
                'role' => 'meat_inspector',
                'status' => 'active',
                'contact_number' => '091234567895',
                'address' => 'Abattoir Office',
            ]
        );

        // ==============================
        // 7. RECORDS STAFF
        // Encoding, organizing records
        // ==============================
        User::firstOrCreate(
            ['email' => 'records@vetmis.gov'],
            [
                'name' => 'Sarah Miller',
                'password' => bcrypt('password123'),
                'role' => 'records_staff',
                'status' => 'active',
                'contact_number' => '091234567896',
                'address' => 'City Veterinary Office',
            ]
        );

        // ==============================
        // 8. DISEASE CONTROL PERSONNEL
        // Animal health, vaccination, rabies monitoring
        // ==============================
        User::firstOrCreate(
            ['email' => 'diseasecontrol@vetmis.gov'],
            [
                'name' => 'Carlos Reyes',
                'password' => bcrypt('password123'),
                'role' => 'disease_control',
                'status' => 'active',
                'contact_number' => '091234567897',
                'address' => 'City Veterinary Office',
            ]
        );

        // ==============================
        // 9. BARANGAY ENCODER
        // Data entry
        // ==============================
        User::firstOrCreate(
            ['email' => 'barangay@vetmis.gov'],
            [
                'name' => 'Barangay Encoder',
                'password' => bcrypt('password123'),
                'role' => 'barangay_encoder',
                'barangay' => 'Poblacion',
                'status' => 'active',
                'contact_number' => '091234567898',
                'address' => 'Barangay Poblacion',
            ]
        );

        // ==============================
        // 10. VIEWER / SUPERVISOR
        // Read-only access
        // ==============================
        User::firstOrCreate(
            ['email' => 'viewer@vetmis.gov'],
            [
                'name' => 'Supervisor',
                'password' => bcrypt('password123'),
                'role' => 'viewer',
                'status' => 'active',
                'contact_number' => '091234567899',
                'address' => 'City Veterinary Office',
            ]
        );

        // Run BarangaySeeder AFTER users are created
        $this->call([
            BarangaySeeder::class,
        ]);
    }
}
