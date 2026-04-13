<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\Establishment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstablishmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Establishment::with('barangay');

        // Filter by type
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        // Filter by barangay
        if ($request->has('barangay_id') && $request->barangay_id) {
            $query->where('barangay_id', $request->barangay_id);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Search by name
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('owner_name', 'like', '%' . $search . '%');
            });
        }

        $establishments = $query->orderBy('created_at', 'desc')->paginate(15);
        $barangays = Barangay::orderBy('barangay_name')->get();
        $types = ['meat_shop', 'poultry', 'pet_shop', 'vet_clinic', 'livestock_facility', 'other'];
        $statuses = ['active', 'inactive', 'suspended', 'pending'];

        return view('admin.establishments.index', compact('establishments', 'barangays', 'types', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangays = Barangay::orderBy('barangay_name')->get();
        $types = ['meat_shop', 'poultry', 'pet_shop', 'vet_clinic', 'livestock_facility', 'other'];
        $statuses = ['active', 'inactive', 'suspended', 'pending'];

        return view('admin.establishments.create', compact('barangays', 'types', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:meat_shop,poultry,pet_shop,vet_clinic,livestock_facility,other',
            'owner_name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'barangay_id' => 'nullable|exists:barangays,barangay_id',
            'status' => 'required|in:active,inactive,suspended,pending',
        ]);

        Establishment::create($validated);

        return redirect()->route('establishments.index')
            ->with('success', 'Establishment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Establishment $establishment)
    {
        $establishment->load('barangay');

        return view('admin.establishments.show', compact('establishment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Establishment $establishment)
    {
        $barangays = Barangay::orderBy('barangay_name')->get();
        $types = ['meat_shop', 'poultry', 'pet_shop', 'vet_clinic', 'livestock_facility', 'other'];
        $statuses = ['active', 'inactive', 'suspended', 'pending'];

        return view('admin.establishments.edit', compact('establishment', 'barangays', 'types', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Establishment $establishment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:meat_shop,poultry,pet_shop,vet_clinic,livestock_facility,other',
            'owner_name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'barangay_id' => 'nullable|exists:barangays,barangay_id',
            'status' => 'required|in:active,inactive,suspended,pending',
        ]);

        $establishment->update($validated);

        return redirect()->route('establishments.index')
            ->with('success', 'Establishment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Establishment $establishment)
    {
        $establishment->delete();

        return redirect()->route('establishments.index')
            ->with('success', 'Establishment deleted successfully.');
    }
}
