<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SuperAdminController extends Controller
{
    /**
     * Show super admin dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get statistics
        $stats = [
            'total_users' => User::count(),
            'super_admins' => User::where('role', 'super_admin')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'city_vets' => User::where('role', 'city_vet')->count(),
            'barangay_encoders' => User::where('role', 'barangay_encoder')->count(),
            'clinics' => User::where('role', 'clinic')->count(),
        ];
        
        // Get recent users
        $recentUsers = User::latest()->take(5)->get();
        
        return view('dashboard.super-admin', compact('user', 'stats', 'recentUsers'));
    }
}
