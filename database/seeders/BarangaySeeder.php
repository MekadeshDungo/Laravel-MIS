<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create barangays
        $barangays = [
            [
                'barangay_name' => 'Barangay Poblacion',
                'city' => 'City',
                'province' => 'Province',
                'contact_number' => '123-4567',
                'office_email' => 'poblacion@barangay.gov',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'barangay_name' => 'Barangay San Jose',
                'city' => 'City',
                'province' => 'Province',
                'contact_number' => '234-5678',
                'office_email' => 'sanjose@barangay.gov',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'barangay_name' => 'Barangay Langkaan',
                'city' => 'City',
                'province' => 'Province',
                'contact_number' => '345-6789',
                'office_email' => 'langkaan@barangay.gov',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('barangays')->insert($barangays);

        // Link barangay users
        $barangayUsers = [
            [
                'barangay_id' => 1,
                'user_id' => 4,
                'position_title' => 'Barangay Encoder',
                'access_level' => 'encoder',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'barangay_id' => 2,
                'user_id' => 5,
                'position_title' => 'Barangay Encoder',
                'access_level' => 'encoder',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'barangay_id' => 3,
                'user_id' => 6,
                'position_title' => 'Barangay Encoder',
                'access_level' => 'encoder',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'barangay_id' => 1,
                'user_id' => 15,
                'position_title' => 'Barangay Encoder',
                'access_level' => 'encoder',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('barangay_users')->insert($barangayUsers);

        $this->command->info('Barangays and barangay users seeded successfully!');
    }
}
