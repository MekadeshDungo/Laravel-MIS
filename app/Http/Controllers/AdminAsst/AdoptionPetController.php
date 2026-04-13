<?php

namespace App\Http\Controllers\AdminAsst;

use App\Http\Controllers\Controller;
use App\Models\AdoptionPet;
use App\Models\AdoptionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdoptionPetController extends Controller
{
    public function index(Request $request)
    {
        $query = AdoptionPet::query();

        if ($request->filled('species')) {
            $query->where('species', $request->species);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('pet_name', 'like', '%' . $search . '%')
                  ->orWhere('breed', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $adoptionPets = $query->with('traits')->orderBy('created_at', 'desc')->paginate(12);
        $traits = AdoptionTrait::orderBy('name')->get();

        return view('admin-staff.adoption-pets.index', compact('adoptionPets', 'traits'));
    }

    public function create()
    {
        $traits = AdoptionTrait::orderBy('name')->get();
        return view('admin-staff.adoption-pets.create', compact('traits'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pet_name' => 'required|string|max:255',
            'species' => 'required|in:Dog,Cat',
            'breed' => 'nullable|string|max:255',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'nullable|date',
            'is_age_estimated' => 'nullable|boolean',
            'weight' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'traits' => 'nullable|array',
            'traits.*' => 'exists:adoption_traits,trait_id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('adoption-pets', 'public');
        }

        $validated['image'] = $imagePath;
        $validated['is_age_estimated'] = $request->has('is_age_estimated');

        $pet = AdoptionPet::create($validated);

        if (!empty($validated['traits'])) {
            $pet->traits()->attach($validated['traits']);
        }

        return redirect()->route('admin-staff.adoption-pets.index')
            ->with('success', 'Pet added to adoption successfully!');
    }

    public function show(AdoptionPet $adoptionPet)
    {
        $adoptionPet->load('traits');
        return view('admin-staff.adoption-pets.show', compact('adoptionPet'));
    }

    public function edit(AdoptionPet $adoptionPet)
    {
        $adoptionPet->load('traits');
        $traits = AdoptionTrait::orderBy('name')->get();
        $selectedTraits = $adoptionPet->traits->pluck('trait_id')->toArray();
        
        return view('admin-staff.adoption-pets.edit', compact('adoptionPet', 'traits', 'selectedTraits'));
    }

    public function update(Request $request, AdoptionPet $adoptionPet)
    {
        $validated = $request->validate([
            'pet_name' => 'required|string|max:255',
            'species' => 'required|in:Dog,Cat',
            'breed' => 'nullable|string|max:255',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'nullable|date',
            'is_age_estimated' => 'nullable|boolean',
            'weight' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'traits' => 'nullable|array',
            'traits.*' => 'exists:adoption_traits,trait_id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($adoptionPet->image) {
                Storage::disk('public')->delete($adoptionPet->image);
            }
            $validated['image'] = $request->file('image')->store('adoption-pets', 'public');
        }

        $validated['is_age_estimated'] = $request->has('is_age_estimated');

        $adoptionPet->update($validated);

        $adoptionPet->traits()->sync($validated['traits'] ?? []);

        return redirect()->route('admin-staff.adoption-pets.show', $adoptionPet)
            ->with('success', 'Adoption pet updated successfully!');
    }

    public function destroy(AdoptionPet $adoptionPet)
    {
        if ($adoptionPet->image) {
            Storage::disk('public')->delete($adoptionPet->image);
        }
        
        $adoptionPet->traits()->detach();
        $adoptionPet->delete();

        return redirect()->route('admin-staff.adoption-pets.index')
            ->with('success', 'Adoption pet removed successfully!');
    }

    public function approve(AdoptionPet $adoptionPet)
    {
        $adoptionPet->update(['is_approved' => true]);

        return redirect()->back()->with('success', 'Adoption pet approved successfully!');
    }
}