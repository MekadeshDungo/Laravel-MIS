<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Apply middleware for all methods except index/show
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     * Permission: Any authenticated user (except citizens) can view users list
     */
    public function index(Request $request)
    {
        // Check if user can access admin panel
        if (!auth()->user()->canAccessAdminPanel()) {
            return redirect()->route('home')->with('error', 'You do not have permission to access this area.');
        }

        $search = $request->get('search', '');
        $role = $request->get('role', '');
        
        $users = User::when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->when($role, function ($query) use ($role) {
                $query->where('role', $role);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.index', compact('users', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     * Permission: Must have level >= 3 (records_staff) to create users
     */
    public function create()
    {
        // Gate check using policy
        if (Gate::denies('create', User::class)) {
            return back()->with('error', 'You do not have permission to create users.');
        }

        // Get assignable roles based on current user's hierarchy
        $assignableRoles = auth()->user()->getAssignableRoles();

        return view('admin.users.create', compact('assignableRoles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Gate check using policy
        if (Gate::denies('create', User::class)) {
            return back()->with('error', 'You do not have permission to create users.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
            'barangay' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
        ]);

        // Check if user can assign the requested role
        if (!auth()->user()->canAssignRole($validated['role'])) {
            return back()->with('error', 'You cannot assign the role "' . $validated['role'] . '".');
        }

        // Prevent creating super_admin by non-super_admin
        if ($validated['role'] === User::ROLE_SUPER_ADMIN && !auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'You cannot create Super Administrator accounts.');
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'barangay' => $validated['barangay'] ?? null,
            'clinic_name' => $validated['clinic_name'] ?? null,
            'contact_number' => $validated['contact_number'] ?? null,
            'status' => 'active',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Gate check using policy
        if (Gate::denies('view', $user)) {
            return back()->with('error', 'You do not have permission to view this user.');
        }

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Gate check using policy
        if (Gate::denies('update', $user)) {
            return back()->with('error', 'You do not have permission to edit this user.');
        }

        // Get assignable roles
        $assignableRoles = auth()->user()->getAssignableRoles();

        return view('admin.users.edit', compact('user', 'assignableRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Gate check using policy
        if (Gate::denies('update', $user)) {
            return back()->with('error', 'You do not have permission to update this user.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string',
            'barangay' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
        ]);

        // ============================================
        // SUPER ADMIN SELF-PROTECTION VALIDATION RULES
        // ============================================
        
        // 1. If user is super_admin trying to change their own role -> BLOCK
        if (auth()->user()->isSuperAdmin() && $user->isSelf() && $validated['role'] !== $user->role) {
            return back()->with('error', 'You cannot change your own role as Super Administrator.');
        }

        // 2. Check role change permissions
        if ($validated['role'] !== $user->role) {
            // Check if user can assign the new role
            if (!auth()->user()->canAssignRole($validated['role'])) {
                return back()->with('error', 'You cannot assign the role "' . $validated['role'] . '".');
            }

            // Prevent changing to super_admin by non-super_admin
            if ($validated['role'] === User::ROLE_SUPER_ADMIN && !auth()->user()->isSuperAdmin()) {
                return back()->with('error', 'You cannot change a user to Super Administrator.');
            }

            // Prevent non-super_admin from modifying super_admin
            if ($user->isSuperAdmin() && !auth()->user()->isSuperAdmin()) {
                return back()->with('error', 'You cannot modify Super Administrator accounts.');
            }
        }

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'barangay' => $validated['barangay'] ?? null,
            'clinic_name' => $validated['clinic_name'] ?? null,
            'contact_number' => $validated['contact_number'] ?? null,
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * 
     * VALIDATION RULES:
     * - Cannot delete your own account
     * - Super admin cannot delete their own account
     * - Cannot delete super_admin unless you are also super_admin
     */
    public function destroy(User $user)
    {
        // Gate check using policy
        if (Gate::denies('delete', $user)) {
            return back()->with('error', 'You do not have permission to delete this user.');
        }

        // Additional validation: Cannot delete self
        if ($user->isSelf()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        // Super admin self-protection: Cannot delete self
        if ($user->isSuperAdmin() && $user->isSelf()) {
            return back()->with('error', 'You cannot delete your own Super Administrator account.');
        }

        // Cannot delete super_admin unless you are super_admin
        if ($user->isSuperAdmin() && !auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'You cannot delete Super Administrator accounts.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Toggle user status (activate/deactivate).
     */
    public function toggleStatus(Request $request, User $user)
    {
        // Gate check using policy
        if (Gate::denies('toggleStatus', $user)) {
            return back()->with('error', 'You do not have permission to change this user\'s status.');
        }

        // Cannot toggle own status
        if ($user->isSelf()) {
            return back()->with('error', 'You cannot change your own status.');
        }

        // Super admin self-protection: Cannot deactivate self
        if ($user->isSuperAdmin() && $user->isSelf()) {
            return back()->with('error', 'You cannot deactivate your own Super Administrator account.');
        }

        // Toggle status
        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->update(['status' => $newStatus]);

        $statusText = $newStatus === 'active' ? 'activated' : 'deactivated';
        return back()->with('success', "User {$statusText} successfully.");
    }
}
