<?php

namespace Database\Seeders;

use App\Models\BiteRabiesReport;
use App\Models\Barangay;
use Illuminate\Database\Seeder;

class AnimalBiteReportSeeder extends Seeder
{
    public function run(): void
    {
        $barangays = Barangay::where('city', 'dasmarinas')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->limit(10)
            ->get();

        if ($barangays->isEmpty()) {
            $this->command->warn('No barangays found in Dasmariñas city. Please run BarangaySeeder first.');
            return;
        }

        $reports = [
            [
                'patient_name' => 'Juan dela Cruz',
                'patient_age' => 25,
                'patient_gender' => 'Male',
                'nature_of_incident' => 'Bitten',
                'bite_site' => 'Upper Extremities',
                'exposure_category' => 'Category II (Scratch)',
                'animal_species' => 'Dog',
                'animal_status' => 'Owned',
                'animal_owner_name' => 'Maria Santos',
                'animal_vaccination_status' => 'Unknown',
                'animal_current_condition' => 'Healthy / Alive',
                'incident_date' => now()->subDays(5),
            ],
            [
                'patient_name' => 'Ana Reyes',
                'patient_age' => 8,
                'patient_gender' => 'Female',
                'nature_of_incident' => 'Bitten',
                'bite_site' => 'Head/Neck',
                'exposure_category' => 'Category III (Bite / Deep)',
                'animal_species' => 'Dog',
                'animal_status' => 'Stray',
                'animal_owner_name' => null,
                'animal_vaccination_status' => 'Unvaccinated',
                'animal_current_condition' => 'Missing / Escaped',
                'incident_date' => now()->subDays(3),
            ],
            [
                'patient_name' => 'Michael Tan',
                'patient_age' => 34,
                'patient_gender' => 'Male',
                'nature_of_incident' => 'Scratched',
                'bite_site' => 'Upper Extremities',
                'exposure_category' => 'Category II (Scratch)',
                'animal_species' => 'Cat',
                'animal_status' => 'Owned',
                'animal_owner_name' => 'Lisa Chen',
                'animal_vaccination_status' => 'Vaccinated',
                'animal_current_condition' => 'Healthy / Alive',
                'incident_date' => now()->subDays(7),
            ],
            [
                'patient_name' => 'Sofia Garcia',
                'patient_age' => 45,
                'patient_gender' => 'Female',
                'nature_of_incident' => 'Bitten',
                'bite_site' => 'Lower Extremities',
                'exposure_category' => 'Category III (Bite / Deep)',
                'animal_species' => 'Dog',
                'animal_status' => 'Owned',
                'animal_owner_name' => 'Roberto Garcia',
                'animal_vaccination_status' => 'Unknown',
                'animal_current_condition' => 'Healthy / Alive',
                'incident_date' => now()->subDays(2),
            ],
            [
                'patient_name' => 'Carlo Mendoza',
                'patient_age' => 12,
                'patient_gender' => 'Male',
                'nature_of_incident' => 'Bitten',
                'bite_site' => 'Trunk',
                'exposure_category' => 'Category III (Bite / Deep)',
                'animal_species' => 'Dog',
                'animal_status' => 'Stray',
                'animal_owner_name' => null,
                'animal_vaccination_status' => 'Unvaccinated',
                'animal_current_condition' => 'Missing / Escaped',
                'incident_date' => now()->subDays(1),
            ],
            [
                'patient_name' => 'Maria Lopez',
                'patient_age' => 28,
                'patient_gender' => 'Female',
                'nature_of_incident' => 'Bitten',
                'bite_site' => 'Upper Extremities',
                'exposure_category' => 'Category I (Lick)',
                'animal_species' => 'Cat',
                'animal_status' => 'Owned',
                'animal_owner_name' => 'Jenny Lopez',
                'animal_vaccination_status' => 'Vaccinated',
                'animal_current_condition' => 'Healthy / Alive',
                'incident_date' => now()->subDays(4),
            ],
            [
                'patient_name' => 'David Kim',
                'patient_age' => 52,
                'patient_gender' => 'Male',
                'nature_of_incident' => 'Bitten',
                'bite_site' => 'Lower Extremities',
                'exposure_category' => 'Category II (Scratch)',
                'animal_species' => 'Dog',
                'animal_status' => 'Owned',
                'animal_owner_name' => 'Sarah Kim',
                'animal_vaccination_status' => 'Vaccinated',
                'animal_current_condition' => 'Healthy / Alive',
                'incident_date' => now()->subDays(6),
            ],
            [
                'patient_name' => 'Emily Cruz',
                'patient_age' => 5,
                'patient_gender' => 'Female',
                'nature_of_incident' => 'Bitten',
                'bite_site' => 'Head/Neck',
                'exposure_category' => 'Category III (Bite / Deep)',
                'animal_species' => 'Dog',
                'animal_status' => 'Owned',
                'animal_owner_name' => 'Tom Cruz',
                'animal_vaccination_status' => 'Vaccinated',
                'animal_current_condition' => 'Healthy / Alive',
                'incident_date' => now()->subDays(8),
            ],
            [
                'patient_name' => 'James Wilson',
                'patient_age' => 41,
                'patient_gender' => 'Male',
                'nature_of_incident' => 'Bitten',
                'bite_site' => 'Upper Extremities',
                'exposure_category' => 'Category II (Scratch)',
                'animal_species' => 'Dog',
                'animal_status' => 'Wild',
                'animal_owner_name' => null,
                'animal_vaccination_status' => 'Unknown',
                'animal_current_condition' => 'Missing / Escaped',
                'incident_date' => now()->subDays(10),
            ],
            [
                'patient_name' => 'Patricia Yu',
                'patient_age' => 19,
                'patient_gender' => 'Female',
                'nature_of_incident' => 'Scratched',
                'bite_site' => 'Upper Extremities',
                'exposure_category' => 'Category I (Lick)',
                'animal_species' => 'Cat',
                'animal_status' => 'Stray',
                'animal_owner_name' => null,
                'animal_vaccination_status' => 'Unknown',
                'animal_current_condition' => 'Missing / Escaped',
                'incident_date' => now()->subDays(9),
            ],
        ];

        $count = 0;
        foreach ($barangays as $index => $barangay) {
            if (isset($reports[$index])) {
                $data = $reports[$index];
                $data['report_number'] = BiteRabiesReport::generateReportNumber();
                $data['report_source'] = 'staff_entry';
                $data['status'] = 'Pending Review';
                $data['assigned_to_role'] = 'assistant_vet';
                $data['reporting_facility'] = 'Others';
                $data['facility_name'] = 'Staff Entry';
                $data['date_reported'] = $data['incident_date'];
                $data['patient_barangay_id'] = $barangay->barangay_id;
                $data['patient_contact'] = '09123456789';
                $data['wound_management'] = null;
                $data['post_exposure_prophylaxis'] = 'No';
                $data['barangay_id'] = $barangay->barangay_id;

                BiteRabiesReport::create($data);
                $count++;
            }
        }

        $this->command->info("Created {$count} Bite & Rabies Reports successfully!");
    }
}
