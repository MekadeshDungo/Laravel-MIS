<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Establishment;
use App\Models\Barangay;

class EstablishmentController extends Controller
{
    /**
     * Display a listing of establishments.
     */
    public function index(Request $request)
    {
        $query = Establishment::query();

        // Filter by type
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by barangay
        if ($request->has('barangay_id') && $request->barangay_id) {
            $query->where('barangay_id', $request->barangay_id);
        }

        // Search by name
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Non-admin users can only see their own entries
        if (!in_array(Auth::user()->role, ['super_admin', 'admin', 'city_vet'])) {
            $query->where('user_id', Auth::id());
        }

        $establishments = $query->with('barangay')->latest()->paginate(10);
        $barangays = Barangay::pluck('barangay_name', 'id');

        return view('establishments.index', compact('establishments', 'barangays'));
    }

    /**
     * Show the form for creating a new establishment.
     */
    public function create()
    {
        $barangays = Barangay::pluck('barangay_name', 'id');
        return view('establishments.create', compact('barangays'));
    }

    /**
     * Store a newly created establishment.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:meat_shop,poultry,pet_shop,vet_clinic,livestock_facility,other',
            'permit_no' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'contact_number' => 'nullable|string|max:255',
            'owner_name' => 'nullable|string|max:255',
            'barangay_id' => 'nullable|exists:barangays,id',
            'status' => 'nullable|string|in:active,inactive,suspended,pending',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = $validated['status'] ?? 'pending';

        Establishment::create($validated);

        return redirect()->route('establishments.index')
            ->with('success', 'Establishment registered successfully!');
    }

    /**
     * Display the specified establishment.
     */
    public function show(Establishment $establishment)
    {
        $establishment->load('barangay', 'inspections');
        return view('establishments.show', compact('establishment'));
    }

    /**
     * Show the form for editing the establishment.
     */
    public function edit(Establishment $establishment)
    {
        $barangays = Barangay::pluck('barangay_name', 'id');
        return view('establishments.edit', compact('establishment', 'barangays'));
    }

    /**
     * Update the specified establishment.
     */
    public function update(Request $request, Establishment $establishment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:meat_shop,poultry,pet_shop,vet_clinic,livestock_facility,other',
            'permit_no' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'contact_number' => 'nullable|string|max:255',
            'owner_name' => 'nullable|string|max:255',
            'barangay_id' => 'nullable|exists:barangays,id',
            'status' => 'nullable|string|in:active,inactive,suspended,pending',
        ]);

        $establishment->update($validated);

        return redirect()->route('establishments.index')
            ->with('success', 'Establishment updated successfully!');
    }

    /**
     * Remove the specified establishment.
     */
    public function destroy(Establishment $establishment)
    {
        $establishment->delete();
        return redirect()->route('establishments.index')
            ->with('success', 'Establishment deleted successfully!');
    }
}
