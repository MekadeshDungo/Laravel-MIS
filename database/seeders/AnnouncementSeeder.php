<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $userId = \App\Models\User::first()->id ?? 1;
        
        $announcements = [
            [
                'title' => 'Free Anti-Rabies Vaccination Drive',
                'content' => 'The City Veterinary Office will conduct a free anti-rabies vaccination drive across all barangays. Pet owners are advised to bring their pets for free vaccination. This is part of our ongoing effort to eliminate rabies in our community.',
                'category' => 'campaign',
                'is_active' => true,
                'created_by' => $userId,
            ],
            [
                'title' => 'Rabies Alert: Increased Cases in Area',
                'content' => 'We have observed an increase in rabies cases in nearby areas. Please ensure your pets are vaccinated and avoid contact with stray animals. Report any suspected rabies cases immediately to the veterinary office.',
                'category' => 'campaign',
                'is_active' => true,
                'created_by' => $userId,
            ],
            [
                'title' => 'Pet Registration Reminder',
                'content' => 'Pet owners are reminded to register their pets at the City Veterinary Office. Registered pets will receive identification tags and are eligible for free vaccinations. Please bring your pet and valid ID to register.',
                'category' => 'campaign',
                'is_active' => true,
                'created_by' => $userId,
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }
    }
}