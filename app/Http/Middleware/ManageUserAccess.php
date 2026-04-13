<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class ManageUserAccess
{
    /**
     * Handle an incoming request.
     * Middleware to check if user can access user management features
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Must be authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to access this area.');
        }

        // Citizens cannot access admin areas at all
        if ($user->isCitizen()) {
            return redirect()->route('home')->with('error', 'You do not have permission to access this area.');
        }

        // Check if user has minimum level to access user management
        if ($user->getHierarchyLevel() < 3) {
            return redirect()->route('home')->with('error', 'You do not have permission to manage users.');
        }

        return $next($request);
    }
}

class CanManageUser
{
    /**
     * Handle an incoming request to manage a specific user.
     * Use: can:manage-user,user_id or can:manage-user
     */
    public function handle(Request $request, Closure $next, ?string $param = null): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login.');
        }

        // If checking specific user (e.g., route /users/{user}/edit)
        if ($param === 'user' || $request->route('user')) {
            $targetUser = $request->route('user');
            
            if ($targetUser instanceof User) {
                // Check if user can manage target
                if (!$user->canManageUser($targetUser)) {
                    return back()->with('error', 'You do not have permission to manage this user.');
                }

                // Special checks for super_admin self-protection
                if ($targetUser->isSelf() && $targetUser->isSuperAdmin()) {
                    // Allow access but certain actions will be blocked in controller
                }
            }
        }

        return $next($request);
    }
}

class CannotModifySelf
{
    /**
     * Prevent users from modifying their own critical settings
     * Use for delete, deactivate, role change operations
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login.');
        }

        // Get target user from route parameter
        $targetUserId = $request->route('user');
        
        if ($targetUserId) {
            // If parameter is a User model
            if ($targetUserId instanceof User) {
                $targetUser = $targetUserId;
            } else {
                // If parameter is an ID
                $targetUser = User::find($targetUserId);
            }

            if ($targetUser) {
                // Check if trying to modify self
                if ($targetUser->isSelf()) {
                    // Super admin cannot delete/deactivate/change own role
                    if ($user->isSuperAdmin()) {
                        return back()->with('error', 'You cannot perform this action on your own account as Super Administrator.');
                    }
                    
                    // Regular users cannot delete themselves
                    return back()->with('error', 'You cannot perform this action on your own account.');
                }

                // Non-super_admin cannot modify super_admin
                if ($targetUser->isSuperAdmin() && !$user->isSuperAdmin()) {
                    return back()->with('error', 'You cannot modify Super Administrator accounts.');
                }
            }
        }

        return $next($request);
    }
}