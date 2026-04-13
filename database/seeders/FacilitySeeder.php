<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            // Animal Bite Centers (ABC)
            ['name' => 'ABC Animal Bite Center - Salawag', 'type' => 'abc', 'barangay_id' => null],
            ['name' => 'ABC Animal Bite Center - San Agustin', 'type' => 'abc', 'barangay_id' => null],
            ['name' => 'ABC Animal Bite Center - San Jose', 'type' => 'abc', 'barangay_id' => null],
            ['name' => 'ABC Happy Life Animal Bite Clinic - Kadiwa, Burol 2', 'type' => 'abc', 'barangay_id' => null],
            ['name' => 'ABC Happy Life Animal Bite Clinic - Pala-Pala', 'type' => 'abc', 'barangay_id' => null],
            ['name' => 'Animal Bite Center - Dasmariñas, Cavite', 'type' => 'abc', 'barangay_id' => null],
            ['name' => 'Armielou ABC Animal Bite Center', 'type' => 'abc', 'barangay_id' => null],
            ['name' => 'Bytz Aide Animal Bite Center', 'type' => 'abc', 'barangay_id' => null],
            ['name' => 'Damarinas City Health Office (CHO) 4', 'type' => 'abc', 'barangay_id' => null],
            ['name' => 'Dasmarinas City Health Office (CHO) 1', 'type' => 'abc', 'barangay_id' => null],
            ['name' => 'Dasmarinas City Health Office (CHO) 3', 'type' => 'abc', 'barangay_id' => null],
            ['name' => 'Firstline Medical Clinic and Animal Bite Center', 'type' => 'abc', 'barangay_id' => null],
            ['name' => 'JGMD Animal Bite Center', 'type' => 'abc', 'barangay_id' => null],
            ['name' => 'Pagamutan ng Dasmariñas (Animal Bite Treatment Center)', 'type' => 'abc', 'barangay_id' => null],
            ['name' => 'St. Mary\'s Animal Bite Clinic - Dasmarinas Cavite', 'type' => 'abc', 'barangay_id' => null],
            ['name' => 'Vaccicare Animal Bite Center', 'type' => 'abc', 'barangay_id' => null],
            ['name' => 'Vaxilife Animal Bite Center', 'type' => 'abc', 'barangay_id' => null],

            // Veterinary Clinics
            ['name' => 'Amigos Pet Grooming', 'type' => 'clinic', 'barangay_id' => null],
            ['name' => 'Crupet Grooming Center', 'type' => 'clinic', 'barangay_id' => null],
            ['name' => 'Dasma Animal Clinic', 'type' => 'clinic', 'barangay_id' => null],
            ['name' => 'IOLAC Vet Clinic', 'type' => 'clinic', 'barangay_id' => null],
            ['name' => 'Ivan Animal Clinic', 'type' => 'clinic', 'barangay_id' => null],
            ['name' => 'Kanjis Pet Grooming', 'type' => 'clinic', 'barangay_id' => null],
            ['name' => 'Lil Pet Grooming Center', 'type' => 'clinic', 'barangay_id' => null],
            ['name' => 'Pet Express', 'type' => 'clinic', 'barangay_id' => null],
            ['name' => 'Petology Emergency Animal Hospital', 'type' => 'clinic', 'barangay_id' => null],
            ['name' => 'Salitran Animal Clinic & Grooming Station', 'type' => 'clinic', 'barangay_id' => null],
            ['name' => 'Tucay Vet Clinic and Pet Grooming', 'type' => 'clinic', 'barangay_id' => null],
            ['name' => 'Vetterhealth Animal Clinic', 'type' => 'clinic', 'barangay_id' => null],
            ['name' => 'Vetways Animal Clinic', 'type' => 'clinic', 'barangay_id' => null],

            // Hospitals
            ['name' => 'Agraan Hospital', 'type' => 'hospital', 'barangay_id' => null],
            ['name' => 'Asia Medic Family Hospital & Medical Center', 'type' => 'hospital', 'barangay_id' => null],
            ['name' => 'Dasmarinas City (DBB) Municipal Hospital', 'type' => 'hospital', 'barangay_id' => null],
            ['name' => 'Dasmarinas City Medical Center', 'type' => 'hospital', 'barangay_id' => null],
            ['name' => 'De La Salle University Medical Center', 'type' => 'hospital', 'barangay_id' => null],
            ['name' => 'EAC Medical Center - Cavite', 'type' => 'hospital', 'barangay_id' => null],
            ['name' => 'GMF Hospital', 'type' => 'hospital', 'barangay_id' => null],
            ['name' => 'Medcor Dasmarinas Hospital and Medical Center', 'type' => 'hospital', 'barangay_id' => null],
            ['name' => 'Pagamutan ng Dasmarinas', 'type' => 'hospital', 'barangay_id' => null],
            ['name' => 'St. Paul Hospital Cavite', 'type' => 'hospital', 'barangay_id' => null],
        ];

        foreach ($facilities as $facility) {
            try {
                Facility::firstOrCreate(
                    ['name' => $facility['name']],
                    $facility
                );
            } catch (\Exception $e) {
                $this->command->error('Error creating facility: ' . $e->getMessage());
            }
        }

        $this->command->info('Facilities seeded successfully!');
    }
}