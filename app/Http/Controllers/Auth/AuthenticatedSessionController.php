<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // Redirect based on user role
        return $this->redirectToDashboard($user);
    }

    /**
     * Redirect user to their role-based dashboard.
     */
    protected function redirectToDashboard($user): RedirectResponse
    {
        switch ($user->role) {
            case 'super_admin':
                return redirect()->intended('/super-admin/dashboard')
                    ->with('success', 'Welcome back, Super Administrator ' . $user->name . '!');
            case 'city_vet':
                return redirect()->intended('/city-vet/dashboard')
                    ->with('success', 'Welcome back, City Veterinarian ' . $user->name . '!');
            case 'admin_staff':
            case 'admin_asst':
                return redirect()->intended('/admin-staff/dashboard')
                    ->with('success', 'Welcome back, Admin Staff ' . $user->name . '!');
            case 'assistant_vet':
            case 'disease_control':
                return redirect()->intended('/assistant-vet/dashboard')
                    ->with('success', 'Welcome back, Assistant Veterinarian ' . $user->name . '!');
            case 'livestock_inspector':
                return redirect()->intended('/livestock/dashboard')
                    ->with('success', 'Welcome back, Livestock Inspector ' . $user->name . '!');
            case 'meat_inspector':
                return redirect()->intended(route('meat-inspection.dashboard'))
                    ->with('success', 'Welcome back, Meat Inspector ' . $user->name . '!');
            case 'city_pound':
            case 'inventory_staff':
                return redirect()->intended('/assistant-vet/dashboard')
                    ->with('success', 'Welcome back, Assistant Veterinarian ' . $user->name . '!');
            case 'citizen':
                return redirect()->intended('/client/dashboard')
                    ->with('success', 'Welcome back, Citizen ' . $user->name . '!');
            case 'viewer':
                return redirect()->intended('/viewer/dashboard')
                    ->with('success', 'Welcome back, Viewer ' . $user->name . '!');
            default:
                Auth::logout();
                return redirect()->route('login')->with('error', 'Invalid role. Please contact the system administrator.');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
