<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $userRole = $request->user()->role;
        $secondaryRole = $request->user()->secondary_role;
        
        // If super_admin, allow access to everything (check first!)
        if ($userRole === 'super_admin') {
            return $next($request);
        }
        
        // Check if the user has the required role (primary or secondary)
        $allowedRoles = explode('|', $role);
        
        if (in_array($userRole, $allowedRoles)) {
            return $next($request);
        }
        
        // Check secondary role
        if ($secondaryRole && in_array($secondaryRole, $allowedRoles)) {
            return $next($request);
        }

        // Redirect to appropriate dashboard based on role
        switch ($userRole) {
            case 'city_vet':
                return redirect()->route('city-vet.dashboard');
            case 'records_staff':
                return redirect()->route('records-staff.dashboard');
            case 'admin_staff':
                return redirect()->route('admin-staff.dashboard');
            case 'disease_control':
                return redirect()->route('disease-control.dashboard');
            case 'city_pound':
                return redirect()->route('city-pound.dashboard');
            case 'meat_inspector':
                return redirect()->route('meat-inspection.dashboard');
            case 'inventory_staff':
                return redirect()->route('inventory.dashboard');
            case 'barangay_encoder':
            case 'barangay':
                return redirect()->route('barangay.dashboard');
            case 'clinic':
                return redirect()->route('clinic.dashboard');
            case 'viewer':
                return redirect()->route('viewer.dashboard');
            case 'citizen':
                return redirect()->route('login')->with('error', 'Citizen portal not yet implemented.');
            case 'admin':
                return redirect()->route('admin.dashboard');
            default:
                // If user has a secondary role, redirect based on that
                if ($secondaryRole) {
                    switch ($secondaryRole) {
                        case 'barangay':
                            return redirect()->route('barangay.dashboard');
                        case 'clinic':
                            return redirect()->route('clinic.dashboard');
                    }
                }
                return redirect()->route('login')->with('error', 'Invalid role. Please contact the system administrator.');
        }
    }
}
