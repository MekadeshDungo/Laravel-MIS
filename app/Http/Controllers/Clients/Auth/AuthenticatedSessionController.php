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
            switch ($user->role) {
                case 'super_admin':
                    return redirect()->route('super-admin.dashboard')
                        ->with('success', 'Welcome back, Super Administrator ' . $user->name . '!');
                case 'admin':
                    return redirect()->route('admin.dashboard')
                        ->with('success', 'Welcome back, Administrator ' . $user->name . '!');
                case 'city_vet':
                    return redirect()->route('city-vet.dashboard')
                        ->with('success', 'Welcome back, City Veterinarian ' . $user->name . '!');
                case 'admin_staff':
                case 'admin_asst':
                    return redirect()->route('admin-staff.dashboard')
                        ->with('success', 'Welcome back, Admin Staff ' . $user->name . '!');
                case 'assistant_vet':
                    return redirect()->route('assistant-vet.dashboard')
                        ->with('success', 'Welcome back, Assistant Veterinarian ' . $user->name . '!');
                case 'livestock_inspector':
                    return redirect()->route('livestock.dashboard')
                        ->with('success', 'Welcome back, Livestock Inspector ' . $user->name . '!');
                case 'records_staff':
                    return redirect()->route('records-staff.dashboard')
                        ->with('success', 'Welcome back, Records Staff ' . $user->name . '!');
                case 'disease_control':
                    return redirect()->route('assistant-vet.dashboard')
                        ->with('success', 'Welcome back, Assistant Veterinary Personnel ' . $user->name . '!');
                case 'meat_inspector':
                    return redirect()->route('meat-inspection.dashboard')
                        ->with('success', 'Welcome back, Meat Inspector ' . $user->name . '!');
                case 'inventory_staff':
                    // Merged into assistant_vet - redirect to Assistant Veterinary dashboard
                    return redirect()->route('assistant-vet.dashboard')
                        ->with('success', 'Welcome back, Assistant Veterinarian ' . $user->name . '!');
                case 'barangay_encoder':
                    return redirect()->route('barangay.dashboard')
                        ->with('success', 'Welcome back, Barangay Encoder ' . $user->name . '!');
                case 'barangay':
                    return redirect()->route('barangay.dashboard')
                        ->with('success', 'Welcome back, Barangay Encoder ' . $user->name . '!');
                case 'clinic':
                    return redirect()->route('clinic.dashboard')
                        ->with('success', 'Welcome back, Clinic User ' . $user->name . '!');
                case 'viewer':
                    return redirect()->route('viewer.dashboard')
                        ->with('success', 'Welcome back, Viewer ' . $user->name . '!');
                case 'citizen':
                    // Citizens/Clients go to client landing page
                    return redirect()->to('/client')
                        ->with('success', 'Welcome back, ' . $user->name . '!');
                default:
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
