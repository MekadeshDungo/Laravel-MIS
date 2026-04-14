<?php

namespace Database\Seeders;

use App\Models\AdoptionTrait;
use Illuminate\Database\Seeder;

class AdoptionTraitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $traits = [
            'Friendly',
            'Playful',
            'Calm',
            'Energetic',
            'Loyal',
            'Gentle',
            'Intelligent',
            'Protective',
            'Affectionate',
            'Good with kids',
            'Good with other pets',
            'House trained',
            'Leash trained',
            'Quiet',
            'Curious',
        ];

        foreach ($traits as $traitName) {
            AdoptionTrait::create(['name' => $traitName]);
        }
    }
}