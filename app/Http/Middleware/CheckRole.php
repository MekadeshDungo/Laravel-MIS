<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Uses Spatie hasRole() for permission checking.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $user = $request->user();

        // If super_admin, allow access to everything
        if ($user->hasRole('super_admin')) {
            return $next($request);
        }

        // Check if the user has the required role using Spatie
        $allowedRoles = explode('|', $role);

        if ($user->hasAnyRole($allowedRoles)) {
            return $next($request);
        }

        // User doesn't have the required role - redirect to their own dashboard
        $userRole = $user->getEffectiveRole();
        
        // Map roles to their dashboards
        $roleDashboards = [
            'city_vet' => 'admin.dashboard',
            'admin_staff' => 'admin-staff.dashboard',
            'admin_asst' => 'admin-asst.dashboard',
            'assistant_vet' => 'assistant-vet.dashboard',
            'livestock_inspector' => 'livestock.dashboard',
            'meat_inspector' => 'meat-inspection.dashboard',
            'records_staff' => 'admin-staff.dashboard',
            'disease_control' => 'disease-control.dashboard',
            'clinic' => 'clinic.dashboard',
            'hospital' => 'hospital.dashboard',
            'citizen' => 'owner.dashboard',
        ];

        if (isset($roleDashboards[$userRole])) {
            return redirect()->route($roleDashboards[$userRole]);
        }

        // Unknown role - redirect to login
        return redirect()->route('login')->with('error', 'Invalid role. Please contact the system administrator.');
    }
}
