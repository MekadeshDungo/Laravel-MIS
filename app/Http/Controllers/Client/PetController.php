<?php

namespace App\Http\Controllers\Client;

use App\Models\Animal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    /**
     * API: Display a listing of the user's animals.
     */
    public function index()
    {
        $user = Auth::user();

        // Get animals directly from user relationship
        $animals = $user->animals()->get();

        return response()->json([
            'success' => true,
            'data' => $animals
        ]);
    }

    /**
     * API: Display the specified animal.
     */
    public function show($id)
    {
        $user = Auth::user();

        $animal = Animal::where('id', $id)
            ->where('owner_id', $user->id)
            ->first();

        if (!$animal) {
            return response()->json([
                'success' => false,
                'message' => 'Animal not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $animal
        ]);
    }

    /**
     * Show the edit form for an animal.
     */
    public function edit($id)
    {
        $user = Auth::user();

        $animal = Animal::where('id', $id)
            ->where('owner_id', $user->id)
            ->first();

        if (!$animal) {
            return redirect()->route('owner.pets')->with('error', 'Animal not found.');
        }

        return view('Client.edit_pet', compact('animal'));
    }

    /**
     * Update the animal.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $animal = Animal::where('id', $id)
            ->where('owner_id', $user->id)
            ->first();

        if (!$animal) {
            return redirect()->route('owner.pets')->with('error', 'Animal not found.');
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
                $animal->pet_image = $request->file('pet_image')->store('pets', 'public');
            }
        } catch (\Exception $e) {
            // Log error but continue with other fields
            \Log::warning('Animal image upload failed: ' . $e->getMessage());
        }

        try {
            if ($request->hasFile('body_mark_image') && $request->file('body_mark_image')->isValid()) {
                $animal->body_mark_image = $request->file('body_mark_image')->store('pets/body-marks', 'public');
            }
        } catch (\Exception $e) {
            // Log error but continue with other fields
            \Log::warning('Body mark image upload failed: ' . $e->getMessage());
        }

        // Update animal - map fields to match Animal model schema
        $animal->update([
            'name' => $validated['pet_name'],
            'species' => $validated['pet_type'],
            'breed' => $validated['pet_breed'],
            'gender' => $validated['gender'],
            'age' => $validated['estimated_age'] ?? null,
            'weight' => $validated['pet_weight'] ?? null,
            'body_mark_details' => $validated['body_mark_details'] ?? null,
        ]);

        return redirect()->route('owner.pets')->with('success', 'Animal updated successfully!');
    }

    /**
     * Delete the animal.
     */
    public function destroy($id)
    {
        $user = Auth::user();

        $animal = Animal::where('id', $id)
            ->where('owner_id', $user->id)
            ->first();

        if (!$animal) {
            return redirect()->route('owner.pets')->with('error', 'Animal not found.');
        }

        // Delete the animal image if exists
        if ($animal->pet_image) {
            \Storage::disk('public')->delete($animal->pet_image);
        }

        $animal->delete();

        return redirect()->route('owner.pets')->with('success', 'Animal deleted successfully!');
    }
}
