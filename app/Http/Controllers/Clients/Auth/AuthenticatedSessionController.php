<?php

namespace App\Http\Controllers\Clients\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        return view('Client.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Clear any intended URL to prevent redirect loops
            $request->session()->forget('url.intended');

            $user = Auth::user();

            // Check if user account is active
            if ($user->status === 'inactive') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account has been deactivated. Please contact the administrator.',
                ])->withInput($request->only('email'));
            }

            // Redirect based on user role - admins go to their dashboards
            // Citizens/Clients go to client landing page
            $role = $user->getRoleAttribute();
            
            if ($user->hasRole('super_admin')) {
                return redirect()->route('super-admin.dashboard')
                    ->with('success', 'Welcome back, Super Administrator ' . $user->name . '!');
            } elseif ($user->hasRole('city_vet')) {
                return redirect()->route('city-vet.dashboard')
                    ->with('success', 'Welcome back, City Veterinarian ' . $user->name . '!');
            } elseif ($user->hasAnyRole(['admin_staff', 'admin_asst'])) {
                return redirect()->route('admin-staff.dashboard')
                    ->with('success', 'Welcome back, Admin Staff ' . $user->name . '!');
            } elseif ($user->hasRole('assistant_vet')) {
                return redirect()->route('assistant-vet.dashboard')
                    ->with('success', 'Welcome back, Assistant Veterinarian ' . $user->name . '!');
            } elseif ($user->hasRole('livestock_inspector')) {
                return redirect()->route('livestock.dashboard')
                    ->with('success', 'Welcome back, Livestock Inspector ' . $user->name . '!');
            } elseif ($user->hasRole('meat_inspector')) {
                return redirect()->route('meat-inspection.dashboard')
                    ->with('success', 'Welcome back, Meat Inspector ' . $user->name . '!');
            } elseif ($user->hasAnyRole(['clinic', 'hospital'])) {
                return redirect()->route('clinic.dashboard')
                    ->with('success', 'Welcome back, Clinic User ' . $user->name . '!');
            } elseif ($user->hasRole('citizen')) {
                return redirect()->to('/client')
                    ->with('success', 'Welcome back, ' . $user->name . '!');
            } else {
                Auth::logout();
                return back()->withErrors([
                        'email' => 'Invalid role. Please contact the system administrator.',
                    ])->withInput($request->only('email'));
            }
        }

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
