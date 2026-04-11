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

        // Create new admin user
        DB::table('admin_users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@vetmis.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $this->info('Admin user created successfully!');

        $this->info('');
        $this->info('=== ADMIN LOGIN CREDENTIALS ===');
        $this->info('Email: admin@vetmis.com');
        $this->info('Password: admin123');
        $this->info('==============================');
        $this->info('');
        $this->info('Please clear your browser cache and cookies,');
        $this->info('then login at http://127.0.0.1:8000/login');
    }
}
