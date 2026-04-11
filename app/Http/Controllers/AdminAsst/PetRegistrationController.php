<?php

namespace App\Http\Controllers\AdminAsst;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\Barangay;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PetRegistrationController extends Controller
{
    /**
     * Display a listing of pet registrations.
     */
    public function index(Request $request)
    {
        $query = Pet::query()->with('userOwner');

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'registered') {
                $query->whereNotNull('license_number');
            } elseif ($request->status === 'pending') {
                $query->whereNull('license_number');
            }
        }

        // Filter by species
        if ($request->filled('species')) {
            $query->where('species', $request->species);
        }

        // Filter by barangay
        if ($request->filled('barangay_id')) {
            $query->where('barangay_id', $request->barangay_id);
        }

        // Search by name or owner
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('breed', 'like', '%' . $search . '%')
                  ->orWhereHas('userOwner', function($uq) use ($search) {
                      $uq->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $pets = $query->orderBy('created_at', 'desc')->paginate(15);
        $barangays = Barangay::orderBy('barangay_name')->get();

        // Statistics
        $totalCount = Pet::count();
        $registeredCount = Pet::whereNotNull('license_number')->count();
        $pendingCount = Pet::whereNull('license_number')->count();

        return view('admin-asst.pet-registrations.index', compact(
            'pets', 
            'barangays',
            'totalCount',
            'registeredCount',
            'pendingCount'
        ));
    }

    /**
     * Show the form for creating a new pet registration.
     */
    public function create()
    {
        $barangays = Barangay::orderBy('barangay_name')->get();
        $users = User::orderBy('name')->get();
        
        return view('admin-asst.pet-registrations.create', compact('barangays', 'users'));
    }

    /**
     * Store a newly created pet registration.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|in:dog,cat,bird,other',
            'breed' => 'required|string|max:255',
            'gender' => 'required|in:male,female,unknown',
            'age' => 'nullable|string|max:100',
            'weight' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:100',
            'client_id' => 'required|exists:users,id',
            'barangay_id' => 'nullable|exists:barangays,barangay_id',
            'vaccination_status' => 'nullable|in:up_to_date,partial,none',
            'health_status' => 'nullable|string|max:255',
            'medical_history' => 'nullable|string',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('pets', 'public');
        }

        // Generate license number for registered pets
        $licenseNumber = null;
        if ($request->filled('generate_license')) {
            $licenseNumber = 'LIC-' . date('Y') . '-' . str_pad(Pet::count() + 1, 6, '0', STR_PAD_LEFT);
        }

        $validated['pet_image'] = $photoPath;
        $validated['license_number'] = $licenseNumber;
        $validated['license_expiry'] = $licenseNumber ? now()->addYear() : null;

        Pet::create($validated);

        return redirect()->route('admin-asst.pet-registrations.index')
            ->with('success', 'Pet registered successfully!');
    }

    /**
     * Display the specified pet registration.
     */
    public function show(Pet $pet)
    {
        $pet->load('userOwner', 'barangay');
        
        return view('admin-asst.pet-registrations.show', compact('pet'));
    }

    /**
     * Show the form for editing the specified pet registration.
     */
    public function edit(Pet $pet)
    {
        $barangays = Barangay::orderBy('barangay_name')->get();
        $users = User::orderBy('name')->get();
        
        return view('admin-asst.pet-registrations.edit', compact('pet', 'barangays', 'users'));
    }

    /**
     * Update the specified pet registration.
     */
    public function update(Request $request, Pet $pet)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|in:dog,cat,bird,other',
            'breed' => 'required|string|max:255',
            'gender' => 'required|in:male,female,unknown',
            'age' => 'nullable|string|max:100',
            'weight' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:100',
            'client_id' => 'required|exists:users,id',
            'barangay_id' => 'nullable|exists:barangays,barangay_id',
            'vaccination_status' => 'nullable|in:up_to_date,partial,none',
            'health_status' => 'nullable|string|max:255',
            'medical_history' => 'nullable|string',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'license_number' => 'nullable|string|max:50',
            'license_expiry' => 'nullable|date',
        ]);

        // Handle file upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($pet->pet_image) {
                \Storage::disk('public')->delete($pet->pet_image);
            }
            $validated['pet_image'] = $request->file('photo')->store('pets', 'public');
        }

        $pet->update($validated);

        return redirect()->route('admin-asst.pet-registrations.show', $pet)
            ->with('success', 'Pet registration updated successfully!');
    }

    /**
     * Remove the specified pet registration.
     */
    public function destroy(Pet $pet)
    {
        // Delete photo if exists
        if ($pet->pet_image) {
            \Storage::disk('public')->delete($pet->pet_image);
        }
        
        $pet->delete();

        return redirect()->route('admin-asst.pet-registrations.index')
            ->with('success', 'Pet registration deleted successfully!');
    }

    /**
     * Approve/Register a pet (issue license).
     */
    public function approve(Pet $pet)
    {
        $licenseNumber = 'LIC-' . date('Y') . '-' . str_pad(Pet::count() + 1, 6, '0', STR_PAD_LEFT);
        
        $pet->update([
            'license_number' => $licenseNumber,
            'license_expiry' => now()->addYear(),
        ]);

        return redirect()->back()->with('success', 'Pet approved and license issued: ' . $licenseNumber);
    }

    /**
     * Get statistics for AJAX calls.
     */
    public function stats()
    {
        $stats = [
            'total' => Pet::count(),
            'registered' => Pet::whereNotNull('license_number')->count(),
            'pending' => Pet::whereNull('license_number')->count(),
            'by_species' => Pet::select('species', DB::raw('count(*) as count'))
                ->groupBy('species')
                ->pluck('count', 'species')
                ->toArray(),
        ];

        return response()->json($stats);
    }
}
