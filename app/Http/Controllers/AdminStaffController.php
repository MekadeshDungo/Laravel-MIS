<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminStaffController extends Controller
{
    /**
     * Show admin staff dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Debug: Log user role
        \Log::debug('AdminStaffController - User Role: ' . ($user->role ?? 'no role'));
        
        // Get statistics - fix: use correct column name 'is_active' if exists
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
        ];
        
        return view('dashboard.admin-staff', compact('user', 'stats'));
    }
}
