<?php

namespace Database\Seeders;

use App\Models\SpayNeuterReport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpayNeuterSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reports = [
            [
                'user_id' => 1,
                'pet_name' => 'Buddy',
                'pet_type' => 'dog',
                'pet_breed' => 'Aspin',
                'pet_age' => 2,
                'pet_sex' => 'male',
                'color_markings' => 'Brown with white markings',
                'owner_name' => 'Juan dela Cruz',
                'owner_contact' => '09123456780',
                'owner_address' => '123 Main St, Barangay Poblacion',
                'procedure_type' => 'neuter',
                'procedure_date' => now()->subDays(5),
                'veterinarian' => 'Dr. Maria Santos',
                'clinic_name' => 'City Veterinary Office',
                'weight' => 15.5,
                'status' => 'completed',
                'remarks' => 'Procedure completed successfully',
                'barangay' => 'Barangay Poblacion',
            ],
            [
                'user_id' => 1,
                'pet_name' => 'Luna',
                'pet_type' => 'dog',
                'pet_breed' => 'Labrador',
                'pet_age' => 1,
                'pet_sex' => 'female',
                'color_markings' => 'Black',
                'owner_name' => 'Ana Garcia',
                'owner_contact' => '09123456781',
                'owner_address' => '456 Oak Ave, Barangay San Jose',
                'procedure_type' => 'spay',
                'procedure_date' => now()->subDays(3),
                'veterinarian' => 'Dr. Juan Reyes',
                'clinic_name' => 'City Veterinary Office',
                'weight' => 22.0,
                'status' => 'completed',
                'remarks' => 'Healthy recovery',
                'barangay' => 'Barangay San Jose',
            ],
            [
                'user_id' => 1,
                'pet_name' => 'Milo',
                'pet_type' => 'cat',
                'pet_breed' => 'Persian',
                'pet_age' => 3,
                'pet_sex' => 'male',
                'color_markings' => 'Orange tabby',
                'owner_name' => 'Pedro Martinez',
                'owner_contact' => '09123456782',
                'owner_address' => '789 Pine St, Barangay Langkaan',
                'procedure_type' => 'neuter',
                'procedure_date' => now()->addDays(7),
                'veterinarian' => 'Dr. Maria Santos',
                'clinic_name' => 'City Veterinary Office',
                'weight' => 5.5,
                'status' => 'scheduled',
                'remarks' => 'Pre-surgery checkup scheduled',
                'barangay' => 'Barangay Langkaan',
            ],
            [
                'user_id' => 1,
                'pet_name' => 'Coco',
                'pet_type' => 'dog',
                'pet_breed' => 'Shih Tzu',
                'pet_age' => 4,
                'pet_sex' => 'female',
                'color_markings' => 'White and brown',
                'owner_name' => 'Maria Rodriguez',
                'owner_contact' => '09123456783',
                'owner_address' => '321 Elm St, Barangay Poblacion',
                'procedure_type' => 'spay',
                'procedure_date' => now()->addDays(14),
                'veterinarian' => 'Dr. Juan Reyes',
                'clinic_name' => 'City Veterinary Office',
                'weight' => 8.0,
                'status' => 'scheduled',
                'remarks' => 'Owner requested morning schedule',
                'barangay' => 'Barangay Poblacion',
            ],
            [
                'user_id' => 1,
                'pet_name' => 'Max',
                'pet_type' => 'dog',
                'pet_breed' => 'German Shepherd',
                'pet_age' => 2,
                'pet_sex' => 'male',
                'color_markings' => 'Black and tan',
                'owner_name' => 'Jose Ramirez',
                'owner_contact' => '09123456784',
                'owner_address' => '654 Maple Ave, Barangay San Jose',
                'procedure_type' => 'both',
                'procedure_date' => now()->subDays(10),
                'veterinarian' => 'Dr. Maria Santos',
                'clinic_name' => 'City Veterinary Office',
                'weight' => 30.0,
                'status' => 'completed',
                'remarks' => 'Multiple procedure performed',
                'barangay' => 'Barangay San Jose',
            ],
        ];

        foreach ($reports as $report) {
            SpayNeuterReport::create($report);
        }
    }
}
