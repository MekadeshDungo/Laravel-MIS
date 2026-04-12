<?php

namespace App\Http\Controllers\AdminAsst;

use App\Http\Controllers\Controller;
use App\Models\MissingPet;
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

        $validated['status'] = 'pending';

        $pet = MissingPet::create($validated);

        return redirect()->route('admin-staff.missing-pets.show', $pet->missing_id)
            ->with('success', 'Missing pet report created successfully!');
    }

    /**
     * Display the specified missing pet.
     */
    public function show(MissingPet $animal)
    {
        return view('admin-staff.missing-pets.show', compact('animal'));
    }

    /**
     * Mark missing pet as found.
     */
    public function markFound(Request $request, MissingPet $animal)
    {
        $animal->delete();

        return redirect()->route('admin-staff.missing-pets.index')
            ->with('success', 'Pet marked as found!');
    }

    /**
     * Approve missing pet report.
     */
    public function approve(Request $request, MissingPet $animal)
    {
        $animal->update([
            'status' => 'approved',
        ]);

        return redirect()->back()->with('success', 'Missing pet report approved!');
    }

    /**
     * Show form to edit missing pet details.
     */
    public function edit(MissingPet $animal)
    {
        return view('admin-staff.missing-pets.edit', compact('animal'));
    }

    /**
     * Update missing pet details.
     */
    public function update(Request $request, MissingPet $animal)
    {
        $validated = $request->validate([
            'pet_name' => 'required|string|max:255',
            'species' => 'required|string|in:dog,cat,other',
            'gender' => 'nullable|string|in:male,female,unknown',
            'age' => 'nullable|integer',
            'breed' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'date_of_birth' => 'nullable|date',
            'missing_since' => 'nullable|date',
            'last_seen_location' => 'nullable|string',
            'contact_info' => 'nullable|string',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            if ($animal->image) {
                Storage::disk('public')->delete($animal->image);
            }
            $path = $request->file('photo')->store('missing-pets', 'public');
            $validated['image'] = $path;
        }

        $animal->update($validated);

        return redirect()->route('admin-staff.missing-pets.show', $animal->missing_id)
            ->with('success', 'Missing pet report updated successfully!');
    }
}