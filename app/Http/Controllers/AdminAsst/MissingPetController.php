<?php

namespace App\Http\Controllers\AdminAsst;

use App\Http\Controllers\Controller;
use App\Models\MissingPet;
use App\Models\Pet;
use App\Models\PetOwner;
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
        $query = MissingPet::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $missingPets = $query->orderBy('missing_since', 'desc')->paginate(12);
        
        $pendingCount = MissingPet::where('status', 'pending')->count();
        $approvedCount = MissingPet::where('status', 'approved')->count();
        $totalCount = MissingPet::count();
            
        return view('admin-staff.missing-pets.index', compact('missingPets', 'pendingCount', 'approvedCount', 'totalCount'));
    }

    /**
     * Show the form for creating a new missing pet report.
     */
    public function create()
    {
        $clients = PetOwner::active()->orderBy('last_name')->get();
        return view('admin-staff.missing-pets.create', compact('clients'));
    }

    /**
     * Store a newly created missing pet report.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
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

        $validated['status'] = 'pending';

        $pet = MissingPet::create($validated);

        return redirect()->route('admin-staff.missing-pets.show', $pet->missing_id)
            ->with('success', 'Missing pet report created successfully!');
    }

    /**
     * Display the specified missing pet.
     */
public function show(MissingPet $missingPet)
    {
        return view('admin-staff.missing-pets.show', compact('missingPet'));
    }

    /**
     * Mark missing pet as found.
     */
    public function markFound(Request $request, MissingPet $missingPet)
    {
        $missingPet->delete();

        return redirect()->route('admin-staff.missing-pets.index')
            ->with('success', 'Pet marked as found!');
    }

    /**
     * Approve missing pet report.
     */
    public function approve(Request $request, MissingPet $missingPet)
    {
        $missingPet->update([
            'status' => 'approved',
        ]);

        return redirect()->back()->with('success', 'Missing pet report approved!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MissingPet $missingPet)
    {
        return view('admin-staff.missing-pets.edit', compact('missingPet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MissingPet $missingPet)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'pet_name' => 'required|string|max:255',
            'species' => 'required|string|in:dog,cat,other',
            'gender' => 'required|string|in:male,female,unknown',
            'age' => 'nullable|integer|min:0',
            'breed' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'weight' => 'nullable|numeric|min:0',
            'date_of_birth' => 'nullable|date',
            'missing_since' => 'required|date',
            'last_seen_location' => 'required|string',
            'contact_info' => 'required|string',
        ]);

        if ($missingPet->image) {
            Storage::disk('public')->delete($missingPet->image);
        }

        $missingPet->update($validated);

        return redirect()->route('admin-staff.missing-pets.show', $missingPet->missing_id)
            ->with('success', 'Missing pet report updated successfully!');
    }
}