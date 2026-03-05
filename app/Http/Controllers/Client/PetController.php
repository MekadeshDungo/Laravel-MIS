<?php

namespace App\Http\Controllers\Client;

use App\Models\Pet;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    /**
     * API: Display a listing of the user's pets.
     */
    public function index()
    {
        $user = Auth::user();

        // Get pets directly from user relationship
        $pets = $user->pets()->get();

        return response()->json([
            'success' => true,
            'data' => $pets
        ]);
    }

    /**
     * API: Display the specified pet.
     */
    public function show($id)
    {
        $user = Auth::user();

        $pet = Pet::where('id', $id)
            ->where('owner_id', $user->id)
            ->first();

        if (!$pet) {
            return response()->json([
                'success' => false,
                'message' => 'Pet not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pet
        ]);
    }

    /**
     * Show the edit form for a pet.
     */
    public function edit($id)
    {
        $user = Auth::user();

        $pet = Pet::where('id', $id)
            ->where('owner_id', $user->id)
            ->first();

        if (!$pet) {
            return redirect()->route('owner.pets')->with('error', 'Pet not found.');
        }

        return view('Client.edit_pet', compact('pet'));
    }

    /**
     * Update the pet.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $pet = Pet::where('id', $id)
            ->where('owner_id', $user->id)
            ->first();

        if (!$pet) {
            return redirect()->route('owner.pets')->with('error', 'Pet not found.');
        }

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

        // Handle file uploads with error handling
        try {
            if ($request->hasFile('pet_image') && $request->file('pet_image')->isValid()) {
                $pet->pet_image = $request->file('pet_image')->store('pets', 'public');
            }
        } catch (\Exception $e) {
            // Log error but continue with other fields
            \Log::warning('Pet image upload failed: ' . $e->getMessage());
        }

        try {
            if ($request->hasFile('body_mark_image') && $request->file('body_mark_image')->isValid()) {
                $pet->body_mark_image = $request->file('body_mark_image')->store('pets/body-marks', 'public');
            }
        } catch (\Exception $e) {
            // Log error but continue with other fields
            \Log::warning('Body mark image upload failed: ' . $e->getMessage());
        }

        // Update pet - map fields to match Pet model schema
        $pet->update([
            'name' => $validated['pet_name'],
            'species' => $validated['pet_type'],
            'breed' => $validated['pet_breed'],
            'gender' => $validated['gender'],
            'age' => $validated['estimated_age'] ?? null,
            'weight' => $validated['pet_weight'] ?? null,
            'body_mark_details' => $validated['body_mark_details'] ?? null,
        ]);

        return redirect()->route('owner.pets')->with('success', 'Pet updated successfully!');
    }

    /**
     * Delete the pet.
     */
    public function destroy($id)
    {
        $user = Auth::user();

        $pet = Pet::where('id', $id)
            ->where('owner_id', $user->id)
            ->first();

        if (!$pet) {
            return redirect()->route('owner.pets')->with('error', 'Pet not found.');
        }

        // Delete the pet image if exists
        if ($pet->pet_image) {
            \Storage::disk('public')->delete($pet->pet_image);
        }

        $pet->delete();

        return redirect()->route('owner.pets')->with('success', 'Pet deleted successfully!');
    }
}
