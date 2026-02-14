<?php

require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$user = User::firstOrCreate(
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

echo "Records Staff account created successfully!\n";
echo "Email: " . $user->email . "\n";
echo "Role: " . $user->role . "\n";
