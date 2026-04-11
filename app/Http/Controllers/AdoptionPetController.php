<?php

namespace App\Http\Controllers;

use App\Models\AdoptionPet;
use App\Models\AdoptionTrait;
use Illuminate\Http\Request;

class AdoptionPetController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pet_name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'age' => 'required|integer|min:0',
            'gender' => 'required|in:male,female',
            'description' => 'nullable|string',
            'traits' => 'nullable|array|min:1|max:5',
            'traits.*' => 'exists:traits,id',
            'weight' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'date_of_birth' => 'nullable|date',
            'is_age_estimated' => 'nullable|boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('adoption-pets', 'public');
        }

        $pet = AdoptionPet::create([
            'pet_name' => $validated['pet_name'],
            'species' => $validated['species'],
            'breed' => $validated['breed'] ?? null,
            'age' => $validated['age'],
            'gender' => $validated['gender'],
            'description' => $validated['description'] ?? null,
            'weight' => $validated['weight'] ?? null,
            'image' => $imagePath,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'is_age_estimated' => $validated['is_age_estimated'] ?? false,
        ]);

        if (!empty($validated['traits'])) {
            $pet->traits()->attach($validated['traits']);
        }

        return redirect()->route('adoption.index')
            ->with('success', 'Pet added successfully for adoption!');
    }
}