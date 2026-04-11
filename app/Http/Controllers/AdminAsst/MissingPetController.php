<?php

namespace App\Http\Controllers\AdminAsst;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MissingPetController extends Controller
{
    /**
     * Display a listing of missing pets.
     */
    public function index(Request $request)
    {
        $query = Pet::where('is_missing', true)
            ->with('owner');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $missingPets = $query->orderBy('missing_since', 'desc')->paginate(12);
        
        $pendingCount = Pet::where('is_missing', true)->where('status', 'active')->count();
        $approvedCount = Pet::where('is_missing', true)->where('status', 'approved')->count();
        $totalCount = Pet::where('is_missing', true)->count();
            
        return view('admin-staff.missing-pets.index', compact('missingPets', 'pendingCount', 'approvedCount', 'totalCount'));
    }

    /**
     * Show the form for creating a new missing pet report.
     */
    public function create()
    {
        $clients = Client::active()->orderBy('last_name')->get();
        return view('admin-staff.missing-pets.create', compact('clients'));
    }

    /**
     * Store a newly created missing pet report.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,client_id',
            'name' => 'required|string|max:255',
            'animal_type' => 'required|string|in:dog,cat,other',
            'breed' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'sex' => 'nullable|string|in:male,female,unknown',
            'photo' => 'nullable|image|max:2048',
            'missing_since' => 'required|date',
            'last_seen_location' => 'required|string',
            'contact_info' => 'required|string',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('missing-pets', 'public');
            $validated['photo_url'] = $path;
        }

        $validated['is_missing'] = true;
        $validated['status'] = 'active';

        $pet = Pet::create($validated);

        return redirect()->route('admin-staff.missing-pets.show', $pet->animal_id)
            ->with('success', 'Missing pet report created successfully!');
    }

    /**
     * Display the specified missing pet.
     */
    public function show(Pet $animal)
    {
        $animal->load('owner');
        return view('admin-staff.missing-pets.show', compact('animal'));
    }

    /**
     * Mark missing pet as found.
     */
    public function markFound(Request $request, Pet $animal)
    {
        $animal->update([
            'is_missing' => false,
            'missing_since' => null,
            'last_seen_location' => null,
            'contact_info' => null,
        ]);

        return redirect()->route('admin-staff.missing-pets.index')
            ->with('success', 'Pet marked as found!');
    }

    /**
     * Approve missing pet report.
     */
    public function approve(Request $request, Pet $animal)
    {
        $animal->update([
            'status' => 'approved',
        ]);

        return redirect()->back()->with('success', 'Missing pet report approved!');
    }

    /**
     * Show form to edit missing pet details.
     */
    public function edit(Pet $animal)
    {
        $clients = Client::active()->orderBy('last_name')->get();
        return view('admin-staff.missing-pets.edit', compact('animal', 'clients'));
    }

    /**
     * Update missing pet details.
     */
    public function update(Request $request, Pet $animal)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,client_id',
            'name' => 'required|string|max:255',
            'animal_type' => 'required|string|in:dog,cat,other',
            'breed' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'sex' => 'nullable|string|in:male,female,unknown',
            'photo' => 'nullable|image|max:2048',
            'missing_since' => 'required|date',
            'last_seen_location' => 'required|string',
            'contact_info' => 'required|string',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($animal->photo_url) {
                Storage::disk('public')->delete($animal->photo_url);
            }
            $path = $request->file('photo')->store('missing-pets', 'public');
            $validated['photo_url'] = $path;
        }

        $animal->update($validated);

        return redirect()->route('admin-staff.missing-pets.show', $animal->animal_id)
            ->with('success', 'Missing pet report updated successfully!');
    }
}