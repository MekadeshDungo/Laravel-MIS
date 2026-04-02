<?php

namespace Database\Seeders;

use App\Models\AnimalBiteReport;
use App\Models\Barangay;
use Illuminate\Database\Seeder;

class AnimalBiteReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get barangays from Dasmariñas city
        $barangays = Barangay::where('city', 'dasmarinas')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->limit(10)
            ->get();

        if ($barangays->isEmpty()) {
            $this->command->warn('No barangays found in Dasmariñas city. Please run BarangaySeeder first.');
            return;
        }

        // Sample bite reports data
        $reports = [
            [
                'victim_name' => 'Juan dela Cruz',
                'victim_age' => 25,
                'victim_gender' => 'Male',
                'victim_address' => '123 Main St, Barangay San Jose',
                'animal_type' => 'Dog',
                'animal_owner_name' => 'Maria Santos',
                'animal_owner_address' => '456 Oak Ave, Barangay San Jose',
                'bite_location' => 'Left Arm',
                'bite_description' => 'Dog bit while playing in the backyard',
                'bite_severity' => 'Category II',
                'bite_category' => 'Minor',
                'animal_vaccination_status' => 'Unknown',
                'bite_date' => now()->subDays(5),
            ],
            [
                'victim_name' => 'Ana Reyes',
                'victim_age' => 8,
                'victim_gender' => 'Female',
                'victim_address' => '789 Pine St, Barangay Emmanuel',
                'animal_type' => 'Dog',
                'animal_owner_name' => 'Pedro Reyes',
                'animal_owner_address' => '789 Pine St, Barangay Emmanuel',
                'bite_location' => 'Face',
                'bite_description' => 'Stray dog attacked child in the park',
                'bite_severity' => 'Category III',
                'bite_category' => 'Severe',
                'animal_vaccination_status' => 'Unvaccinated',
                'bite_date' => now()->subDays(3),
            ],
            [
                'victim_name' => 'Michael Tan',
                'victim_age' => 34,
                'victim_gender' => 'Male',
                'victim_address' => '321 Elm St, Barangay Langgam',
                'animal_type' => 'Cat',
                'animal_owner_name' => 'Lisa Chen',
                'animal_owner_address' => '321 Elm St, Barangay Langgam',
                'bite_location' => 'Right Hand',
                'bite_description' => 'Cat scratched while feeding without gloves',
                'bite_severity' => 'Category I',
                'bite_category' => 'Minor',
                'animal_vaccination_status' => 'Vaccinated',
                'bite_date' => now()->subDays(7),
            ],
            [
                'victim_name' => 'Sofia Garcia',
                'victim_age' => 45,
                'victim_gender' => 'Female',
                'victim_address' => '555 Mango Ave, Barangay Putol',
                'animal_type' => 'Dog',
                'animal_owner_name' => 'Roberto Garcia',
                'animal_owner_address' => '555 Mango Ave, Barangay Putol',
                'bite_location' => 'Left Leg',
                'bite_description' => 'Neighbor dog bit unexpectedly when entering yard',
                'bite_severity' => 'Category II',
                'bite_category' => 'Moderate',
                'animal_vaccination_status' => 'Unknown',
                'bite_date' => now()->subDays(2),
            ],
            [
                'victim_name' => 'Carlo Mendoza',
                'victim_age' => 12,
                'victim_gender' => 'Male',
                'victim_address' => '888 Cedar St, Barangay Paliparan',
                'animal_type' => 'Dog',
                'animal_owner_name' => 'Stray',
                'animal_owner_address' => 'N/A',
                'bite_location' => 'Back',
                'bite_description' => 'Stray dog bit while walking to school',
                'bite_severity' => 'Category II',
                'bite_category' => 'Moderate',
                'animal_vaccination_status' => 'Unvaccinated',
                'bite_date' => now()->subDays(1),
            ],
            [
                'victim_name' => 'Maria Lopez',
                'victim_age' => 28,
                'victim_gender' => 'Female',
                'victim_address' => '222 Bamboo Lane, Barangay Sabang',
                'animal_type' => 'Cat',
                'animal_owner_name' => 'Jenny Lopez',
                'animal_owner_address' => '222 Bamboo Lane, Barangay Sabang',
                'bite_location' => 'Left Arm',
                'bite_description' => 'Pet cat bit during grooming session',
                'bite_severity' => 'Category I',
                'bite_category' => 'Minor',
                'animal_vaccination_status' => 'Vaccinated',
                'bite_date' => now()->subDays(4),
            ],
            [
                'victim_name' => 'David Kim',
                'victim_age' => 52,
                'victim_gender' => 'Male',
                'victim_address' => '444 Rose St, Barangay San Agustin',
                'animal_type' => 'Dog',
                'animal_owner_name' => 'Sarah Kim',
                'animal_owner_address' => '444 Rose St, Barangay San Agustin',
                'bite_location' => 'Right Foot',
                'bite_description' => 'Family dog bit during feeding time',
                'bite_severity' => 'Category II',
                'bite_category' => 'Moderate',
                'animal_vaccination_status' => 'Vaccinated',
                'bite_date' => now()->subDays(6),
            ],
            [
                'victim_name' => 'Emily Cruz',
                'victim_age' => 5,
                'victim_gender' => 'Female',
                'victim_address' => '777 Lily St, Barangay Kanluran',
                'animal_type' => 'Dog',
                'animal_owner_name' => 'Tom Cruz',
                'animal_owner_address' => '777 Lily St, Barangay Kanluran',
                'bite_location' => 'Face/Neck',
                'bite_description' => 'Pet dog bit toddler who pulled its tail',
                'bite_severity' => 'Category III',
                'bite_category' => 'Severe',
                'animal_vaccination_status' => 'Vaccinated',
                'bite_date' => now()->subDays(8),
            ],
            [
                'victim_name' => 'James Wilson',
                'victim_age' => 41,
                'victim_gender' => 'Male',
                'victim_address' => '333 Violet St, Barangay Silangan',
                'animal_type' => 'Dog',
                'animal_owner_name' => 'Mark Wilson',
                'animal_owner_address' => '333 Violet St, Barangay Silangan',
                'bite_location' => 'Left Hand',
                'bite_description' => 'Guard dog bit intruder attempting to enter property',
                'bite_severity' => 'Category II',
                'bite_category' => 'Moderate',
                'animal_vaccination_status' => 'Unknown',
                'bite_date' => now()->subDays(10),
            ],
            [
                'victim_name' => 'Patricia Yu',
                'victim_age' => 19,
                'victim_gender' => 'Female',
                'victim_address' => '999 Tulip Ave, Barangay Balele',
                'animal_type' => 'Cat',
                'animal_owner_name' => 'Amy Yu',
                'animal_owner_address' => '999 Tulip Ave, Barangay Balele',
                'bite_location' => 'Right Arm',
                'bite_description' => 'Stray cat bit when approached for petting',
                'bite_severity' => 'Category I',
                'bite_category' => 'Minor',
                'animal_vaccination_status' => 'Unknown',
                'bite_date' => now()->subDays(9),
            ],
        ];

        $count = 0;
        foreach ($barangays as $index => $barangay) {
            if (isset($reports[$index])) {
                $data = $reports[$index];
                $data['barangay_id'] = $barangay->barangay_id;
                $data['reporter_name'] = $data['victim_name'];
                $data['reporter_contact'] = '09123456789';
                $data['bite_time'] = '09:30:00';
                $data['status'] = 'pending';
                $data['action_taken'] = 'Initial assessment completed';

                AnimalBiteReport::create($data);
                $count++;
            }
        }

        $this->command->info("Created {$count} Animal Bite Reports successfully!");
    }
}
