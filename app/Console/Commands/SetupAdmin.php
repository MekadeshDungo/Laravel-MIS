<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SetupAdmin extends Command
{
    protected $signature = 'admin:setup';
    protected $description = 'Setup admin account and fix login issues';

    public function handle()
    {
        // Clear all sessions
        DB::table('sessions')->truncate();
        $this->info('Sessions cleared.');

        // Delete any existing admin users
        DB::table('admin_users')->where('email', 'admin@vetmis.com')->delete();
        $this->info('Old admin user deleted.');

        // Create new admin user (legacy fields for backward compatibility - assignRole will be called separately)
        $userId = DB::table('admin_users')->insertGetId([
            'first_name' => 'System',
            'last_name' => 'Administrator',
            'email' => 'admin@vetmis.com',
            'password' => Hash::make('admin123'),
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Assign Spatie role
        $user = \App\Models\User::find($userId);
        $user->assignRole('city_vet');
        
        $this->info('Admin user created successfully with city_vet role!');

        $this->info('');
        $this->info('=== ADMIN LOGIN CREDENTIALS ===');
        $this->info('Email: admin@vetmis.com');
        $this->info('Password: admin123');
        $this->info('Role: City Veterinarian');
        $this->info('==============================');
        $this->info('');
        $this->info('Please clear your browser cache and cookies,');
        $this->info('then login at http://127.0.0.1:8000/login');
    }
}
