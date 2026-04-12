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

        // If super_admin, allow access to everything (check first!)
        if ($userRole === 'super_admin') {
            return $next($request);
        }

        // Check if the user has the required role
        $allowedRoles = explode('|', $role);

        if (in_array($userRole, $allowedRoles)) {
            return $next($request);
        }

        // Redirect to appropriate dashboard based on role
        switch ($userRole) {
            case 'city_vet':
                return redirect()->route('admin.dashboard');
            case 'admin_staff':
                return redirect()->route('admin-staff.dashboard');
            case 'livestock_inspector':
                return redirect()->route('livestock-census.index');
            case 'meat_inspector':
                return redirect()->route('meat-inspection.dashboard');
            case 'disease_control':
                return redirect()->route('disease-control.dashboard');
            case 'citizen':
                return redirect()->route('login')->with('error', 'Citizen portal not yet implemented.');
            // Legacy role name mappings (for backwards compatibility)
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'clinic':
                return redirect()->route('clinic.dashboard');
            case 'hospital':
                return redirect()->route('hospital.dashboard');
            case 'inventory_staff':
            case 'assistant_vet':
                return redirect()->route('assistant-vet.dashboard');
            default:
                return redirect()->route('login')->with('error', 'Invalid role. Please contact the system administrator.');
        }
    }
}
