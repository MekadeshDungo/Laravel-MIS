<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
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
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:super_admin,admin,city_vet,records_staff,admin_staff,disease_control,city_pound,meat_inspector,inventory_staff,barangay_encoder,clinic,viewer,citizen',
            'secondary_role' => 'nullable|string|in:barangay,clinic',
            'barangay' => 'nullable|string|max:255',
            'clinic_name' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'secondary_role' => $validated['secondary_role'] ?? null,
            'barangay' => $validated['barangay'] ?? null,
            'clinic_name' => $validated['clinic_name'] ?? null,
            'contact_number' => $validated['contact_number'] ?? null,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|in:super_admin,admin,city_vet,records_staff,admin_staff,disease_control,city_pound,meat_inspector,inventory_staff,barangay_encoder,clinic,viewer,citizen',
            'secondary_role' => 'nullable|string|in:barangay,clinic',
            'barangay' => 'nullable|string|max:255',
            'clinic_name' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'secondary_role' => $validated['secondary_role'] ?? null,
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
     */
    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
