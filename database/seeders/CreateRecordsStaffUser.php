<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CreateRecordsStaffUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'records@vetmis.gov.ph'],
            [
                'name' => 'Records Staff',
                'password' => bcrypt('staff123'),
                'role' => 'records_staff',
                'division' => 'Records Division',
                'contact_number' => '09123456810',
                'address' => 'City Veterinary Office',
            ]
        );
        
        $this->command->info('Records Staff user created successfully!');
    }
}
