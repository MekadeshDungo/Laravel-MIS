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
     */
    public function run(): void
    {
        // ==============================
        // 1. SYSTEM ADMINISTRATOR (Super Admin)
        // Full system control
        // ==============================
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@vetmis.gov.ph',
            'password' => bcrypt('admin123'),
            'role' => 'super_admin',
            'contact_number' => '09123456789',
            'address' => 'City Veterinary Office, Dasmariñas City',
        ]);

        // ==============================
        // 2. VETERINARY ADMINISTRATOR
        // Office-wide operations (High access but no system config)
        // ==============================
        User::create([
            'name' => 'Dr. Maria Santos',
            'email' => 'dr.santos@vetmis.gov.ph',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'contact_number' => '09123456790',
            'address' => 'City Veterinary Office',
        ]);

        User::create([
            'name' => 'Administrative Officer',
            'email' => 'admin.staff@vetmis.gov.ph',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'contact_number' => '09123456791',
            'address' => 'City Veterinary Office',
        ]);

        // ==============================
        // 3. BARANGAY ENCODERS
        // Barangay-only access
        // ==============================
        User::create([
            'name' => 'Barangay Poblacion Encoder',
            'email' => 'poblacion@vetmis.gov.ph',
            'password' => bcrypt('barangay123'),
            'role' => 'barangay',
            'barangay' => 'Barangay Poblacion',
            'contact_number' => '09123456792',
            'address' => 'Barangay Poblacion, Dasmariñas City',
        ]);

        User::create([
            'name' => 'Barangay San Jose Encoder',
            'email' => 'sanjose@vetmis.gov.ph',
            'password' => bcrypt('barangay123'),
            'role' => 'barangay',
            'barangay' => 'Barangay San Jose',
            'contact_number' => '09123456793',
            'address' => 'Barangay San Jose, Dasmariñas City',
        ]);

        User::create([
            'name' => 'Barangay Langkaan Encoder',
            'email' => 'langkaan@vetmis.gov.ph',
            'password' => bcrypt('barangay123'),
            'role' => 'barangay',
            'barangay' => 'Barangay Langkaan',
            'contact_number' => '09123456794',
            'address' => 'Barangay Langkaan, Dasmariñas City',
        ]);

        // ==============================
        // 4. VETERINARY CLINIC USERS
        // Clinic-only access
        // ==============================
        User::create([
            'name' => 'City Veterinary Clinic',
            'email' => 'clinic@vetclinic.com',
            'password' => bcrypt('clinic123'),
            'role' => 'clinic',
            'clinic_name' => 'City Veterinary Clinic',
            'contact_number' => '09123456795',
            'address' => '123 Main Street, Dasmariñas City',
        ]);

        User::create([
            'name' => 'Animal Care Center',
            'email' => 'animalcare@vetclinic.com',
            'password' => bcrypt('clinic123'),
            'role' => 'clinic',
            'clinic_name' => 'Animal Care Center',
            'contact_number' => '09123456796',
            'address' => '456 Veterinary Ave, Dasmariñas City',
        ]);

        // ==============================
        // 5. VETERINARY STAFF (Division-Based)
        // ==============================
        
        // Disease Control Division
        User::create([
            'name' => 'Disease Control Officer',
            'email' => 'disease.control@vetmis.gov.ph',
            'password' => bcrypt('staff123'),
            'role' => 'disease_control',
            'division' => 'Disease Control Division',
            'contact_number' => '09123456797',
            'address' => 'City Veterinary Office',
        ]);

        // City Pound Personnel
        User::create([
            'name' => 'City Pound Manager',
            'email' => 'city.pound@vetmis.gov.ph',
            'password' => bcrypt('staff123'),
            'role' => 'city_pound',
            'division' => 'City Pound Division',
            'contact_number' => '09123456798',
            'address' => 'City Pound Facility',
        ]);

        // Meat Inspection Division
        User::create([
            'name' => 'Meat Inspector',
            'email' => 'meat.inspection@vetmis.gov.ph',
            'password' => bcrypt('staff123'),
            'role' => 'meat_inspector',
            'division' => 'Meat Inspection Division',
            'contact_number' => '09123456799',
            'address' => 'Abattoir Office',
        ]);

        // Records Staff
        User::create([
            'name' => 'Records Staff',
            'email' => 'records@vetmis.gov.ph',
            'password' => bcrypt('staff123'),
            'role' => 'records_staff',
            'division' => 'Records Division',
            'contact_number' => '09123456810',
            'address' => 'City Veterinary Office',
        ]);

        // ==============================
        // 6. VIEWER / SUPERVISOR
        // Read-only access
        // ==============================
        User::create([
            'name' => 'Supervisor - Monitoring Officer',
            'email' => 'supervisor@vetmis.gov.ph',
            'password' => bcrypt('viewer123'),
            'role' => 'viewer',
            'contact_number' => '09123456800',
            'address' => 'City Veterinary Office',
        ]);

        // ==============================
        // 7. EXTERNAL USERS (Citizens / Pet Owners)
        // Public portal access
        // ==============================
        User::create([
            'name' => 'Juan Dela Cruz',
            'email' => 'juan.citizen@email.com',
            'password' => bcrypt('citizen123'),
            'role' => 'citizen',
            'contact_number' => '09123456801',
            'address' => 'Barangay Poblacion, Dasmariñas City',
        ]);

        User::create([
            'name' => 'Maria Clara',
            'email' => 'maria.citizen@email.com',
            'password' => bcrypt('citizen123'),
            'role' => 'citizen',
            'contact_number' => '09123456802',
            'address' => 'Barangay San Jose, Dasmariñas City',
        ]);

        // ==============================
        // END DEMO ACCOUNTS
        // ==============================
    }
}
