<?php

namespace App\Http\Controllers\Client;

use App\Models\Pet;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;

class PetRegistrationController extends Controller
{
    /**
     * Store a newly created pet in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pet_name' => 'required|string|max:255',
            'pet_type' => 'required|in:dog,cat',
            'gender' => 'required|in:male,female',
            'pet_breed' => 'required|string|max:255',
            'pet_birthdate' => 'nullable|date',
            'estimated_age' => 'nullable|string',
            'pet_weight' => 'nullable|string|max:50',
            'body_mark_details' => 'nullable|string',
        ]);

        // Get the authenticated user directly - pets.owner_id links to users.id
        $user = Auth::user();

        // Handle file uploads
        $petImagePath = null;
        $bodyMarkImagePath = null;

        if ($request->hasFile('pet_image')) {
            $petImagePath = $request->file('pet_image')->store('pets', 'public');
        }

        if ($request->hasFile('body_mark_image')) {
            $bodyMarkImagePath = $request->file('body_mark_image')->store('pets/body-marks', 'public');
        }

        // Create the pet - owner_id links to users.id
        $pet = Pet::create([
            'owner_id' => $user->id,
            'name' => $validated['pet_name'],
            'species' => $validated['pet_type'],
            'breed' => $validated['pet_breed'],
            'gender' => $validated['gender'],
            'age' => $validated['estimated_age'] ?? null,
            'weight' => $validated['pet_weight'] ?? null,
            'photo_url' => $petImagePath,
        ]);

        return redirect()->route('owner.dashboard')->with('success', 'Pet registered successfully!');
    }
}
