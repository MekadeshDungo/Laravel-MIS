<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Complete list of 75 barangays in Dasmariñas City, Cavite
     */
    public function run(): void
    {
        $barangays = [
            // Zone / Poblacion - 5 barangays
            ['barangay_name' => 'Zone I', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3294, 'longitude' => 120.9358, 'status' => 'active'],
            ['barangay_name' => 'Zone I-B', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3303, 'longitude' => 120.9367, 'status' => 'active'],
            ['barangay_name' => 'Zone II', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3312, 'longitude' => 120.9375, 'status' => 'active'],
            ['barangay_name' => 'Zone III', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3330, 'longitude' => 120.9392, 'status' => 'active'],
            ['barangay_name' => 'Zone IV', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3348, 'longitude' => 120.9410, 'status' => 'active'],

            // Burol - 4 barangays
            ['barangay_name' => 'Burol', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3423, 'longitude' => 120.9301, 'status' => 'active'],
            ['barangay_name' => 'Burol I', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3412, 'longitude' => 120.9287, 'status' => 'active'],
            ['barangay_name' => 'Burol II', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3390, 'longitude' => 120.9265, 'status' => 'active'],
            ['barangay_name' => 'Burol III', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3368, 'longitude' => 120.9243, 'status' => 'active'],

            // Datu Esmael - 1 barangay
            ['barangay_name' => 'Datu Esmael (Bago-a-Ingud)', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3567, 'longitude' => 120.9489, 'status' => 'active'],

            // Emmanuel Bergado - 2 barangays
            ['barangay_name' => 'Emmanuel Bergado I', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3456, 'longitude' => 120.9432, 'status' => 'active'],
            ['barangay_name' => 'Emmanuel Bergado II', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3434, 'longitude' => 120.9410, 'status' => 'active'],

            // Fatima - 3 barangays
            ['barangay_name' => 'Fatima I', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3489, 'longitude' => 120.9423, 'status' => 'active'],
            ['barangay_name' => 'Fatima II', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3467, 'longitude' => 120.9401, 'status' => 'active'],
            ['barangay_name' => 'Fatima III', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3445, 'longitude' => 120.9379, 'status' => 'active'],

            // H-2 - 1 barangay
            ['barangay_name' => 'H-2', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3278, 'longitude' => 120.9145, 'status' => 'active'],

            // Langkaan - 2 barangays
            ['barangay_name' => 'Langkaan I', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3156, 'longitude' => 120.9425, 'status' => 'active'],
            ['barangay_name' => 'Langkaan II', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3134, 'longitude' => 120.9403, 'status' => 'active'],

            // Luzviminda - 2 barangays
            ['barangay_name' => 'Luzviminda I', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3234, 'longitude' => 120.9089, 'status' => 'active'],
            ['barangay_name' => 'Luzviminda II', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3212, 'longitude' => 120.9067, 'status' => 'active'],

            // Paliparan - 3 barangays
            ['barangay_name' => 'Paliparan I', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3212, 'longitude' => 120.9178, 'status' => 'active'],
            ['barangay_name' => 'Paliparan II', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3190, 'longitude' => 120.9156, 'status' => 'active'],
            ['barangay_name' => 'Paliparan III', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3168, 'longitude' => 120.9134, 'status' => 'active'],

            // Sabang - 1 barangay
            ['barangay_name' => 'Sabang', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3478, 'longitude' => 120.9567, 'status' => 'active'],

            // Saint Peter - 2 barangays
            ['barangay_name' => 'Saint Peter I', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3389, 'longitude' => 120.9367, 'status' => 'active'],
            ['barangay_name' => 'Saint Peter II', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3367, 'longitude' => 120.9345, 'status' => 'active'],

            // Salawag - 1 barangay
            ['barangay_name' => 'Salawag', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3256, 'longitude' => 120.9234, 'status' => 'active'],

            // Salitran - 4 barangays
            ['barangay_name' => 'Salitran I', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3267, 'longitude' => 120.9512, 'status' => 'active'],
            ['barangay_name' => 'Salitran II', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3245, 'longitude' => 120.9535, 'status' => 'active'],
            ['barangay_name' => 'Salitran III', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3223, 'longitude' => 120.9558, 'status' => 'active'],
            ['barangay_name' => 'Salitran IV', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3201, 'longitude' => 120.9581, 'status' => 'active'],

            // Sampaloc - 5 barangays
            ['barangay_name' => 'Sampaloc I (Pala-Pala)', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3098, 'longitude' => 120.9345, 'status' => 'active'],
            ['barangay_name' => 'Sampaloc II (Bucal/Malinta)', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3076, 'longitude' => 120.9323, 'status' => 'active'],
            ['barangay_name' => 'Sampaloc III (Piela)', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3054, 'longitude' => 120.9301, 'status' => 'active'],
            ['barangay_name' => 'Sampaloc IV (Talisayan/Bautista)', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3032, 'longitude' => 120.9279, 'status' => 'active'],
            ['barangay_name' => 'Sampaloc V (New Era)', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3010, 'longitude' => 120.9257, 'status' => 'active'],

            // San Agustin - 3 barangays
            ['barangay_name' => 'San Agustin I', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3401, 'longitude' => 120.9489, 'status' => 'active'],
            ['barangay_name' => 'San Agustin II (R. Tirona)', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3379, 'longitude' => 120.9467, 'status' => 'active'],
            ['barangay_name' => 'San Agustin III', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3357, 'longitude' => 120.9445, 'status' => 'active'],

            // San Andres - 2 barangays
            ['barangay_name' => 'San Andres I', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3289, 'longitude' => 120.9501, 'status' => 'active'],
            ['barangay_name' => 'San Andres II', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3267, 'longitude' => 120.9479, 'status' => 'active'],

            // San Antonio De Padua - 2 barangays
            ['barangay_name' => 'San Antonio De Padua I', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3523, 'longitude' => 120.9356, 'status' => 'active'],
            ['barangay_name' => 'San Antonio De Padua II', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3501, 'longitude' => 120.9334, 'status' => 'active'],

            // San Dionisio - 1 barangay
            ['barangay_name' => 'San Dionisio (Barangay 1)', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3256, 'longitude' => 120.9234, 'status' => 'active'],

            // San Esteban - 1 barangay
            ['barangay_name' => 'San Esteban (Barangay 4)', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3345, 'longitude' => 120.9312, 'status' => 'active'],

            // San Francisco - 2 barangays
            ['barangay_name' => 'San Francisco I', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3567, 'longitude' => 120.9234, 'status' => 'active'],
            ['barangay_name' => 'San Francisco II', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3545, 'longitude' => 120.9212, 'status' => 'active'],

            // San Isidro Labrador - 2 barangays
            ['barangay_name' => 'San Isidro Labrador I', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3178, 'longitude' => 120.9256, 'status' => 'active'],
            ['barangay_name' => 'San Isidro Labrador II', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3156, 'longitude' => 120.9234, 'status' => 'active'],

            // San Jose - 1 barangay
            ['barangay_name' => 'San Jose', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3314, 'longitude' => 120.9402, 'status' => 'active'],

            // San Juan - 1 barangay
            ['barangay_name' => 'San Juan (San Juan I)', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3298, 'longitude' => 120.9389, 'status' => 'active'],

            // San Lorenzo Ruiz - 2 barangays
            ['barangay_name' => 'San Lorenzo Ruiz I', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3234, 'longitude' => 120.9167, 'status' => 'active'],
            ['barangay_name' => 'San Lorenzo Ruiz II', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3212, 'longitude' => 120.9145, 'status' => 'active'],

            // San Luis - 2 barangays
            ['barangay_name' => 'San Luis I', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3489, 'longitude' => 120.9298, 'status' => 'active'],
            ['barangay_name' => 'San Luis II', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3467, 'longitude' => 120.9276, 'status' => 'active'],

            // San Manuel - 2 barangays
            ['barangay_name' => 'San Manuel I', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3578, 'longitude' => 120.9167, 'status' => 'active'],
            ['barangay_name' => 'San Manuel II', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3556, 'longitude' => 120.9145, 'status' => 'active'],

            // San Mateo - 1 barangay
            ['barangay_name' => 'San Mateo', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3545, 'longitude' => 120.9234, 'status' => 'active'],

            // San Miguel - 2 barangays
            ['barangay_name' => 'San Miguel', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3523, 'longitude' => 120.9312, 'status' => 'active'],
            ['barangay_name' => 'San Miguel II', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3501, 'longitude' => 120.9290, 'status' => 'active'],

            // San Nicolas - 2 barangays
            ['barangay_name' => 'San Nicolas I', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3398, 'longitude' => 120.9198, 'status' => 'active'],
            ['barangay_name' => 'San Nicolas II', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3376, 'longitude' => 120.9176, 'status' => 'active'],

            // San Roque - 1 barangay
            ['barangay_name' => 'San Roque (Sta. Cristina II)', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3401, 'longitude' => 120.9490, 'status' => 'active'],

            // San Simon - 1 barangay
            ['barangay_name' => 'San Simon (Barangay 7)', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3278, 'longitude' => 120.9267, 'status' => 'active'],

            // Santa Cristina - 2 barangays
            ['barangay_name' => 'Santa Cristina I', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3423, 'longitude' => 120.9512, 'status' => 'active'],
            ['barangay_name' => 'Santa Cristina II', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3401, 'longitude' => 120.9490, 'status' => 'active'],

            // Santa Cruz - 2 barangays
            ['barangay_name' => 'Santa Cruz I', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3245, 'longitude' => 120.9101, 'status' => 'active'],
            ['barangay_name' => 'Santa Cruz II', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3223, 'longitude' => 120.9079, 'status' => 'active'],

            // Santa Fe - 1 barangay
            ['barangay_name' => 'Santa Fe', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3189, 'longitude' => 120.9201, 'status' => 'active'],

            // Santa Lucia - 1 barangay
            ['barangay_name' => 'Santa Lucia (San Juan II)', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3312, 'longitude' => 120.9367, 'status' => 'active'],

            // Santa Maria - 1 barangay
            ['barangay_name' => 'Santa Maria (Barangay 20)', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3267, 'longitude' => 120.9189, 'status' => 'active'],

            // Santo Cristo - 1 barangay
            ['barangay_name' => 'Santo Cristo (Barangay 3)', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3334, 'longitude' => 120.9289, 'status' => 'active'],

            // Santo Niño - 2 barangays
            ['barangay_name' => 'Santo Niño I', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3456, 'longitude' => 120.9267, 'status' => 'active'],
            ['barangay_name' => 'Santo Niño II', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3434, 'longitude' => 120.9245, 'status' => 'active'],

            // Victoria Reyes - 1 barangay
            ['barangay_name' => 'Victoria Reyes', 'city' => 'Dasmariñas', 'province' => 'Cavite', 'latitude' => 14.3189, 'longitude' => 120.9378, 'status' => 'active'],
        ];

        // Insert barangays
        foreach ($barangays as $barangay) {
            DB::table('barangays')->insert($barangay);
        }

        $this->command->info('Successfully seeded 75 barangays!');
    }
}
