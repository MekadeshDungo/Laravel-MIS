<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request - Supports 7 user roles.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Redirect based on user role
            switch ($user->role) {
                case 'super_admin':
                    return redirect()->intended('/super-admin/dashboard')
                        ->with('success', 'Welcome back, Super Administrator ' . $user->name . '!');
                case 'admin':
                    return redirect()->intended('/admin/dashboard')
                        ->with('success', 'Welcome back, Administrator ' . $user->name . '!');
                case 'city_vet':
                    return redirect()->intended('/city-vet/dashboard')
                        ->with('success', 'Welcome back, City Veterinarian ' . $user->name . '!');
                case 'records_staff':
                    return redirect()->intended('/records-staff/dashboard')
                        ->with('success', 'Welcome back, Records Staff ' . $user->name . '!');
                case 'disease_control':
                    return redirect()->intended('/disease-control/dashboard')
                        ->with('success', 'Welcome back, Disease Control Personnel ' . $user->name . '!');
                case 'meat_inspector':
                    return redirect()->intended(route('meat-inspection.dashboard'))
                        ->with('success', 'Welcome back, Meat Inspector ' . $user->name . '!');
                case 'inventory_staff':
                    return redirect()->intended('/inventory/dashboard')
                        ->with('success', 'Welcome back, Inventory Staff ' . $user->name . '!');
                case 'barangay_encoder':
                    return redirect()->intended('/barangay/dashboard')
                        ->with('success', 'Welcome back, Barangay Encoder ' . $user->name . '!');
                case 'barangay':
                    return redirect()->intended('/barangay/dashboard')
                        ->with('success', 'Welcome back, Barangay Encoder ' . $user->name . '!');
                case 'clinic':
                    return redirect()->intended('/clinic/dashboard')
                        ->with('success', 'Welcome back, Clinic User ' . $user->name . '!');
                case 'viewer':
                    return redirect()->intended('/viewer/dashboard')
                        ->with('success', 'Welcome back, Viewer ' . $user->name . '!');
                case 'citizen':
                    return redirect()->intended('/citizen/dashboard')
                        ->with('success', 'Welcome back, Citizen ' . $user->name . '!');
                default:
                    Auth::logout();
                    return back()->withErrors([
                        'email' => 'Invalid role. Please contact the system administrator.',
                    ])->withInput($request->only('email'));
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    /**
     * Show the registration form - DISABLED for public registration.
     */
    public function showRegistrationForm()
    {
        // Registration is disabled - redirect to login
        return redirect()->route('login')->with('error', 'Registration is disabled. Please contact the system administrator.');
    }

    /**
     * Handle registration request - DISABLED.
     */
    public function register(Request $request)
    {
        // Registration is disabled
        return redirect()->route('login')->with('error', 'Registration is disabled. Please contact the system administrator.');
    }

    /**
     * Logout the user.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }
}
