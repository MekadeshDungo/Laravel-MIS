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
     * NOTE: Run seeders in this order:
     * 1. Roles (for reference)
     * 2. Users (barangay encoders must be created before BarangaySeeder)
     * 3. BarangaySeeder (creates barangays and links to users)
     * 4. Other seeders
     */
    public function run(): void
    {
        // ==============================
        // 1. SYSTEM ADMINISTRATOR (Super Admin)
        // Full system control
        // ==============================
        User::firstOrCreate(
            ['email' => 'admin@vetmis.gov.ph'],
            [
                'name' => 'System Administrator',
                'password' => bcrypt('admin123'),
                'role' => 'super_admin',
                'contact_number' => '09123456789',
                'address' => 'City Veterinary Office, Dasmariñas City',
            ]
        );

        // ==============================
        // 2. VETERINARY ADMINISTRATOR
        // Office-wide operations (High access but no system config)
        // ==============================
        User::firstOrCreate(
            ['email' => 'dr.santos@vetmis.gov.ph'],
            [
                'name' => 'Dr. Maria Santos',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'contact_number' => '09123456790',
                'address' => 'City Veterinary Office',
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin.staff@vetmis.gov.ph'],
            [
                'name' => 'Administrative Officer',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'contact_number' => '09123456791',
                'address' => 'City Veterinary Office',
            ]
        );

        // ==============================
        // 3. BARANGAY ENCODERS
        // Barangay-only access
        // ==============================
        User::firstOrCreate(
            ['email' => 'poblacion@vetmis.gov.ph'],
            [
                'name' => 'Barangay Poblacion Encoder',
                'password' => bcrypt('barangay123'),
                'role' => 'barangay_encoder',
                'barangay' => 'Barangay Poblacion',
                'contact_number' => '09123456792',
                'address' => 'Barangay Poblacion, Dasmariñas City',
            ]
        );

        User::firstOrCreate(
            ['email' => 'sanjose@vetmis.gov.ph'],
            [
                'name' => 'Barangay San Jose Encoder',
                'password' => bcrypt('barangay123'),
                'role' => 'barangay_encoder',
                'barangay' => 'Barangay San Jose',
                'contact_number' => '09123456793',
                'address' => 'Barangay San Jose, Dasmariñas City',
            ]
        );

        User::firstOrCreate(
            ['email' => 'langkaan@vetmis.gov.ph'],
            [
                'name' => 'Barangay Langkaan Encoder',
                'password' => bcrypt('barangay123'),
                'role' => 'barangay_encoder',
                'barangay' => 'Barangay Langkaan',
                'contact_number' => '09123456794',
                'address' => 'Barangay Langkaan, Dasmariñas City',
            ]
        );

        // ==============================
        // 4. VETERINARY CLINIC USERS
        // Clinic-only access
        // ==============================
        User::firstOrCreate(
            ['email' => 'clinic@vetclinic.com'],
            [
                'name' => 'City Veterinary Clinic',
                'password' => bcrypt('clinic123'),
                'role' => 'clinic',
                'clinic_name' => 'City Veterinary Clinic',
                'contact_number' => '09123456795',
                'address' => '123 Main Street, Dasmariñas City',
            ]
        );

        User::firstOrCreate(
            ['email' => 'animalcare@vetclinic.com'],
            [
                'name' => 'Animal Care Center',
                'password' => bcrypt('clinic123'),
                'role' => 'clinic',
                'clinic_name' => 'Animal Care Center',
                'contact_number' => '09123456796',
                'address' => '456 Veterinary Ave, Dasmariñas City',
            ]
        );

        // ==============================
        // 5. VETERINARY STAFF (Division-Based)
        // ==============================

        // Disease Control Division
        User::firstOrCreate(
            ['email' => 'disease.control@vetmis.gov.ph'],
            [
                'name' => 'Disease Control Officer',
                'password' => bcrypt('staff123'),
                'role' => 'disease_control',
                'division' => 'Disease Control Division',
                'contact_number' => '09123456797',
                'address' => 'City Veterinary Office',
            ]
        );

        // City Pound Personnel
        User::firstOrCreate(
            ['email' => 'city.pound@vetmis.gov.ph'],
            [
                'name' => 'City Pound Manager',
                'password' => bcrypt('staff123'),
                'role' => 'city_pound',
                'division' => 'City Pound Division',
                'contact_number' => '09123456798',
                'address' => 'City Pound Facility',
            ]
        );

        // Meat Inspection Division
        User::firstOrCreate(
            ['email' => 'meat.inspection@vetmis.gov.ph'],
            [
                'name' => 'Meat Inspector',
                'password' => bcrypt('staff123'),
                'role' => 'meat_inspector',
                'division' => 'Meat Inspection Division',
                'contact_number' => '09123456799',
                'address' => 'Abattoir Office',
            ]
        );

        // Records Staff
        User::firstOrCreate(
            ['email' => 'records@vetmis.gov.ph'],
            [
                'name' => 'Records Staff',
                'password' => bcrypt('staff123'),
                'role' => 'records_staff',
                'division' => 'Records Division',
                'contact_number' => '09123456810',
                'address' => 'City Veterinary Office',
            ]
        );

        // ==============================
        // 6. VIEWER / SUPERVISOR
        // Read-only access
        // ==============================
        User::firstOrCreate(
            ['email' => 'supervisor@vetmis.gov.ph'],
            [
                'name' => 'Supervisor - Monitoring Officer',
                'password' => bcrypt('viewer123'),
                'role' => 'viewer',
                'contact_number' => '09123456800',
                'address' => 'City Veterinary Office',
            ]
        );

        // ==============================
        // 7. EXTERNAL USERS (Citizens / Pet Owners)
        // Public portal access
        // ==============================
        User::firstOrCreate(
            ['email' => 'juan.citizen@email.com'],
            [
                'name' => 'Juan Dela Cruz',
                'password' => bcrypt('citizen123'),
                'role' => 'citizen',
                'contact_number' => '09123456801',
                'address' => 'Barangay Poblacion, Dasmariñas City',
            ]
        );

        User::firstOrCreate(
            ['email' => 'maria.citizen@email.com'],
            [
                'name' => 'Maria Clara',
                'password' => bcrypt('citizen123'),
                'role' => 'citizen',
                'contact_number' => '09123456802',
                'address' => 'Barangay San Jose, Dasmariñas City',
            ]
        );

        // ==============================
        // END DEMO ACCOUNTS
        // ==============================

        // Run BarangaySeeder AFTER users are created
        // This creates barangays and links them to barangay_encoder users
        $this->call([
            RoleSeeder::class,
            BarangaySeeder::class,
        ]);
    }
}
