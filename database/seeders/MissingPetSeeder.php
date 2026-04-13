<?php

namespace Database\Seeders;

use App\Models\Pet;
use App\Models\Client;
use App\Models\Barangay;
use Illuminate\Database\Seeder;

class MissingPetSeeder extends Seeder
{
    public function run(): void
    {
        $barangays = Barangay::where('city', 'dasmarinas')
            ->limit(10)
            ->get();

        if ($barangays->isEmpty()) {
            $this->command->warn('No barangays found in Dasmariñas city. Please run BarangaySeeder first.');
            return;
        }

        $clients = [
            [
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'email' => 'maria.santos@email.com',
                'phone_number' => '09123456701',
                'house_no' => '123',
                'street' => 'Mabini St',
                'barangay_id' => $barangays->random()->barangay_id,
                'city' => 'Dasmariñas',
                'province' => 'Cavite',
                'password' => bcrypt('password123'),
                'status' => 'active',
            ],
            [
                'first_name' => 'Juan',
                'last_name' => 'Dela Cruz',
                'email' => 'juan.cruz@email.com',
                'phone_number' => '09123456702',
                'house_no' => '456',
                'street' => 'quezon Ave',
                'barangay_id' => $barangays->random()->barangay_id,
                'city' => 'Dasmariñas',
                'province' => 'Cavite',
                'password' => bcrypt('password123'),
                'status' => 'active',
            ],
            [
                'first_name' => 'Ana',
                'last_name' => 'Reyes',
                'email' => 'ana.reyes@email.com',
                'phone_number' => '09123456703',
                'house_no' => '789',
                'street' => 'Bonifacio St',
                'barangay_id' => $barangays->random()->barangay_id,
                'city' => 'Dasmariñas',
                'province' => 'Cavite',
                'password' => bcrypt('password123'),
                'status' => 'active',
            ],
            [
                'first_name' => 'Pedro',
                'last_name' => 'Garcia',
                'email' => 'pedro.garcia@email.com',
                'phone_number' => '09123456704',
                'house_no' => '321',
                'street' => 'Liberal St',
                'barangay_id' => $barangays->random()->barangay_id,
                'city' => 'Dasmariñas',
                'province' => 'Cavite',
                'password' => bcrypt('password123'),
                'status' => 'active',
            ],
            [
                'first_name' => 'Lisa',
                'last_name' => 'Chen',
                'email' => 'lisa.chen@email.com',
                'phone_number' => '09123456705',
                'house_no' => '654',
                'street' => 'Rodriguez Ave',
                'barangay_id' => $barangays->random()->barangay_id,
                'city' => 'Dasmariñas',
                'province' => 'Cavite',
                'password' => bcrypt('password123'),
                'status' => 'active',
            ],
        ];

        $createdClients = [];
        foreach ($clients as $clientData) {
            $createdClients[] = Client::firstOrCreate(
                ['email' => $clientData['email']],
                $clientData
            );
        }

        $missingPets = [
            [
                'name' => 'Buddy',
                'animal_type' => 'dog',
                'species' => 'Dog',
                'breed' => 'Golden Retriever',
                'gender' => 'Male',
                'color' => 'Golden',
                'sex' => 'male',
                'missing_since' => now()->subDays(5),
                'last_seen_location' => 'Paliparan I, Dasmariñas City',
                'contact_info' => '09123456701',
                'status' => 'active',
            ],
            [
                'name' => 'Whiskers',
                'animal_type' => 'cat',
                'species' => 'Cat',
                'breed' => 'Persian',
                'gender' => 'Female',
                'color' => 'White',
                'sex' => 'female',
                'missing_since' => now()->subDays(3),
                'last_seen_location' => 'Salitran II, Dasmariñas City',
                'contact_info' => '09123456702',
                'status' => 'active',
            ],
            [
                'name' => 'Max',
                'animal_type' => 'dog',
                'species' => 'Dog',
                'breed' => 'German Shepherd',
                'gender' => 'Male',
                'color' => 'Black and Tan',
                'sex' => 'male',
                'missing_since' => now()->subDays(7),
                'last_seen_location' => 'Burol Main, Dasmariñas City',
                'contact_info' => '09123456703',
                'status' => 'active',
            ],
            [
                'name' => 'Luna',
                'animal_type' => 'dog',
                'species' => 'Dog',
                'breed' => 'Shih Tzu',
                'gender' => 'Female',
                'color' => 'White and Brown',
                'sex' => 'female',
                'missing_since' => now()->subDays(2),
                'last_seen_location' => 'Poblacion, Dasmariñas City',
                'contact_info' => '09123456704',
                'status' => 'active',
            ],
            [
                'name' => 'Simba',
                'animal_type' => 'dog',
                'species' => 'Dog',
                'breed' => 'Labrador',
                'gender' => 'Male',
                'color' => 'Black',
                'sex' => 'male',
                'missing_since' => now()->subDays(10),
                'last_seen_location' => 'Sabang, Dasmariñas City',
                'contact_info' => '09123456705',
                'status' => 'active',
            ],
            [
                'name' => 'Cleo',
                'animal_type' => 'cat',
                'species' => 'Cat',
                'breed' => 'Siamese',
                'gender' => 'Female',
                'color' => 'Cream',
                'sex' => 'female',
                'missing_since' => now()->subDays(1),
                'last_seen_location' => 'Fatima III, Dasmariñas City',
                'contact_info' => '09123456701',
                'status' => 'active',
            ],
            [
                'name' => 'Rocky',
                'animal_type' => 'dog',
                'species' => 'Dog',
                'breed' => 'Bulldog',
                'gender' => 'Male',
                'color' => 'White and Brown',
                'sex' => 'male',
                'missing_since' => now()->subDays(4),
                'last_seen_location' => 'Langkaan II, Dasmariñas City',
                'contact_info' => '09123456702',
                'status' => 'active',
            ],
            [
                'name' => 'Milo',
                'animal_type' => 'dog',
                'species' => 'Dog',
                'breed' => 'Beagle',
                'gender' => 'Male',
                'color' => 'Tri-color',
                'sex' => 'male',
                'missing_since' => now()->subDays(6),
                'last_seen_location' => 'San Agustin I, Dasmariñas City',
                'contact_info' => '09123456703',
                'status' => 'active',
            ],
        ];

        $count = 0;
        foreach ($missingPets as $petData) {
            $petData['client_id'] = $createdClients[$count % count($createdClients)]->client_id;
            $petData['is_missing'] = true;

            Pet::create($petData);
            $count++;
        }

        $this->command->info("Created {$count} missing pet records successfully!");
    }
}
