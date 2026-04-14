<?php

namespace Database\Seeders;

use App\Models\AdoptionPet;
use App\Models\AdoptionTrait;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AdoptionPetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pets = [
            [
                'pet_name' => 'Xioming',
                'species' => 'Cat',
                'breed' => 'Norwegian Forest cat',
                'date_of_birth' => Carbon::now()->subYears(5),
                'gender' => 'Female',
                'description' => 'A medium-furred white she-cat with heterochromatic golden and green eyes; with average curled ears',
                'weight' => 89,
                'is_age_estimated' => true,
                'image' => 'images/adoption pets/xioming.jpg',
            ],
            [
                'pet_name' => 'Cozmo',
                'species' => 'Cat',
                'breed' => 'American Curl',
                'date_of_birth' => Carbon::now()->subYears(6),
                'gender' => 'Male',
                'description' => 'A medium-furred white cat with dichroic golden and green eyes; and is deaf, with large curled ears',
                'weight' => 77,
                'is_age_estimated' => true,
                'image' => 'images/adoption pets/cozmo.jpg',
            ],
            [
                'pet_name' => 'Chase',
                'species' => 'Cat',
                'breed' => 'Cornish Rex',
                'date_of_birth' => Carbon::now()->subYears(8),
                'gender' => 'Female',
                'description' => 'Loving, A long-furred silver red tom with blue eyes',
                'weight' => 69,
                'is_age_estimated' => true,
                'image' => 'images/adoption pets/chase.jpg',
            ],
            [
                'pet_name' => 'Buster',
                'species' => 'Dog',
                'breed' => 'Bulldog',
                'date_of_birth' => Carbon::now()->subYears(4),
                'gender' => 'Male',
                'description' => 'A stocky brindle dog with a massive underbite and a heart of gold',
                'weight' => 23,
                'is_age_estimated' => true,
                'image' => 'images/adoption pets/buster.jpg',
            ],
            [
                'pet_name' => 'Bella',
                'species' => 'Cat',
                'breed' => 'Scottish Fold',
                'date_of_birth' => Carbon::now()->subYears(2),
                'gender' => 'Female',
                'description' => 'A small grey tabby with tightly folded ears and a very expressive tail',
                'weight' => 4,
                'is_age_estimated' => true,
                'image' => 'images/adoption pets/bella.jpg',
            ],
            [
                'pet_name' => 'Shadow',
                'species' => 'Dog',
                'breed' => 'German Shepherd',
                'date_of_birth' => Carbon::now()->subYears(6),
                'gender' => 'Male',
                'description' => 'A large black and tan dog with alert ears and a highly focused gaze',
                'weight' => 38,
                'is_age_estimated' => true,
                'image' => 'images/adoption pets/shadow.jpg',
            ],
            [
                'pet_name' => 'Oliver',
                'species' => 'Cat',
                'breed' => 'British Shorthair',
                'date_of_birth' => Carbon::now()->subYears(3),
                'gender' => 'Male',
                'description' => 'A chubby blue-grey tomcat with round copper eyes and a plush coat',
                'weight' => 6,
                'is_age_estimated' => true,
                'image' => 'images/adoption pets/oliver.jpg',
            ],
            [
                'pet_name' => 'Daisy',
                'species' => 'Dog',
                'breed' => 'Golden Retriever',
                'date_of_birth' => Carbon::now()->subYears(1),
                'gender' => 'Female',
                'description' => 'A fluffy cream-colored puppy with floppy ears and a constantly wagging tail',
                'weight' => 25,
                'is_age_estimated' => true,
                'image' => 'images/adoption pets/daisy.jpg',
            ],
            [
                'pet_name' => 'Smokey',
                'species' => 'Cat',
                'breed' => 'Russian Blue',
                'date_of_birth' => Carbon::now()->subYears(4),
                'gender' => 'Male',
                'description' => 'A sleek short-haired cat with a silvery-green sheen and striking emerald eyes',
                'weight' => 5,
                'is_age_estimated' => true,
                'image' => 'images/adoption pets/smokey.jpg',
            ],
            [
                'pet_name' => 'Lottie',
                'species' => 'Cat',
                'breed' => 'Puspin',
                'date_of_birth' => Carbon::now()->subYears(3),
                'gender' => 'Female',
                'description' => 'A red and white low-riding cat with big fox-like ears and long tail',
                'weight' => 11,
                'is_age_estimated' => true,
                'image' => 'images/adoption pets/lottie.jpg',
            ],
            [
                'pet_name' => 'Naya',
                'species' => 'Cat',
                'breed' => 'Puspin',
                'date_of_birth' => Carbon::now()->subYears(4),
                'gender' => 'Female',
                'description' => 'A shy white and yellow fierce cat with green eyes',
                'weight' => 4.5,
                'is_age_estimated' => true,
                'image' => 'images/adoption pets/naya.jpg',
            ],
        ];

        foreach ($pets as $pet) {
            $createdPet = AdoptionPet::create($pet);
            
            // Attach random traits to each pet (1-3 random traits)
            $allTraits = AdoptionTrait::all()->pluck('id')->toArray();
            $numTraits = rand(1, 3);
            $randomTraitIds = array_rand(array_flip($allTraits), $numTraits);
            $createdPet->traits()->attach($randomTraitIds);
        }
    }
}