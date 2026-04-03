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
                'user_id' => $userId,
                'title' => 'Free Anti-Rabies Vaccination Drive',
                'type' => 'Vaccination Program',
                'audience' => 'Public',
                'priority' => 'Important',
                'status' => 'Published',
                'publish_date' => now(),
                'expiry_date' => now()->addMonths(2),
                'body' => 'The City Veterinary Office will conduct a free anti-rabies vaccination drive across all barangays. Pet owners are advised to bring their pets for free vaccination. This is part of our ongoing effort to eliminate rabies in our community.',
                'is_active' => true,
            ],
            [
                'user_id' => $userId,
                'title' => 'Rabies Alert: Increased Cases in Area',
                'type' => 'Rabies Alert',
                'audience' => 'Public',
                'priority' => 'Urgent',
                'status' => 'Published',
                'publish_date' => now(),
                'expiry_date' => now()->addWeeks(2),
                'body' => 'We have observed an increase in rabies cases in nearby areas. Please ensure your pets are vaccinated and avoid contact with stray animals. Report any suspected rabies cases immediately to the veterinary office.',
                'is_active' => true,
            ],
            [
                'user_id' => $userId,
                'title' => 'Pet Registration Reminder',
                'type' => 'General Announcement',
                'audience' => 'Pet Owners',
                'priority' => 'Normal',
                'status' => 'Published',
                'publish_date' => now(),
                'expiry_date' => now()->addMonths(1),
                'body' => 'Pet owners are reminded to register their pets at the City Veterinary Office. Registered pets will receive identification tags and are eligible for free vaccinations. Please bring your pet and valid ID to register.',
                'is_active' => true,
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }
    }
}