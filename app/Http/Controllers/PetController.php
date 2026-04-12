<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Client;
use App\Models\Barangay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PetController extends Controller
{
    public function index(Request $request)
    {
        $query = Pet::with(['client', 'barangay']);

        if ($request->filled('species')) {
            $query->where('species', $request->species);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        if ($request->filled('barangay_id')) {
            $query->where('barangay_id', $request->barangay_id);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('breed', 'like', '%' . $request->search . '%');
            });
        }

        $pets = $query->orderBy('created_at', 'desc')->paginate(15);
        $clients = Client::orderBy('last_name')->get();
        $barangays = Barangay::orderBy('barangay_name')->get();

        return view('admin-staff.pets.index', compact('pets', 'clients', 'barangays'));
    }

    public function show(Pet $pet)
    {
        $pet->load(['client', 'barangay', 'vaccinations', 'medicalRecords']);

        return view('admin-staff.pets.show', compact('pet'));
    }

    public function create()
    {
        $clients = Client::orderBy('last_name')->get();
        $barangays = Barangay::orderBy('barangay_name')->get();

        return view('admin-staff.pets.create', compact('clients', 'barangays'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'nullable|exists:clients,client_id',
            'name' => 'required|string|max:100',
            'species' => 'required|string|max:50',
            'breed' => 'nullable|string|max:100',
            'age' => 'nullable|integer|min:0',
            'gender' => 'required|in:male,female,unknown',
            'color' => 'nullable|string|max:100',
            'weight' => 'nullable|numeric|min:0',
            'vaccination_status' => 'nullable|in:vaccinated,unvaccinated,pending',
            'vaccination_date' => 'nullable|date',
            'next_vaccination_date' => 'nullable|date',
            'license_number' => 'nullable|string|max:50',
            'license_expiry' => 'nullable|date',
            'microchip_number' => 'nullable|string|max:50',
            'health_status' => 'nullable|in:healthy,sick,deceased',
            'medical_history' => 'nullable|string',
            'notes' => 'nullable|string',
            'pet_image' => 'nullable|string',
            'barangay_id' => 'nullable|exists:barangays,barangay_id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Pet::create($request->validated());

        \App\Services\NotificationService::petRegistrationCreated(Pet::latest()->first()->id);

        return redirect()->route('pets.index')
            ->with('success', 'Pet registered successfully.');
    }

    public function edit(Pet $pet)
    {
        $pet->load('client');
        $clients = Client::orderBy('last_name')->get();
        $barangays = Barangay::orderBy('barangay_name')->get();

        return view('admin-staff.pets.edit', compact('pet', 'clients', 'barangays'));
    }

    public function update(Request $request, Pet $pet)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'nullable|exists:clients,client_id',
            'name' => 'required|string|max:100',
            'species' => 'required|string|max:50',
            'breed' => 'nullable|string|max:100',
            'age' => 'nullable|integer|min:0',
            'gender' => 'required|in:male,female,unknown',
            'color' => 'nullable|string|max:100',
            'weight' => 'nullable|numeric|min:0',
            'vaccination_status' => 'nullable|in:vaccinated,unvaccinated,pending',
            'vaccination_date' => 'nullable|date',
            'next_vaccination_date' => 'nullable|date',
            'license_number' => 'nullable|string|max:50',
            'license_expiry' => 'nullable|date',
            'microchip_number' => 'nullable|string|max:50',
            'health_status' => 'nullable|in:healthy,sick,deceased',
            'medical_history' => 'nullable|string',
            'notes' => 'nullable|string',
            'pet_image' => 'nullable|string',
            'barangay_id' => 'nullable|exists:barangays,barangay_id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pet->update($request->validated());

        return redirect()->route('pets.show', $pet)
            ->with('success', 'Pet updated successfully.');
    }

    public function destroy(Pet $pet)
    {
        $pet->delete();

        return redirect()->route('pets.index')
            ->with('success', 'Pet deleted successfully.');
    }
}