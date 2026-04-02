<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\Livestock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LivestockController extends Controller
{
    /**
     * Display the dashboard for Livestock Inspector.
     */
    public function dashboard()
    {
        // Get counts
        $totalLivestock = Livestock::count();
        $totalRecords = Livestock::count();
        $totalEstablishments = \App\Models\Establishment::count();
        $activeEstablishments = \App\Models\Establishment::where('status', 'active')->count();

        // Get recent records
        $recentRecords = Livestock::with(['barangay', 'recorder'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get count by species
        $bySpecies = Livestock::selectRaw('species, COUNT(*) as total')
            ->groupBy('species')
            ->orderBy('total', 'desc')
            ->get();

        // Get top barangays by livestock count
        $topBarangays = Livestock::selectRaw('barangay_id, COUNT(*) as total')
            ->groupBy('barangay_id')
            ->orderBy('total', 'desc')
            ->with('barangay')
            ->limit(5)
            ->get();

        return view('admin.livestock.dashboard', compact(
            'totalLivestock',
            'totalRecords',
            'totalEstablishments',
            'activeEstablishments',
            'recentRecords',
            'bySpecies',
            'topBarangays'
        ));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Livestock::with(['barangay', 'recorder']);

        // Filter by barangay
        if ($request->has('barangay_id') && $request->barangay_id) {
            $query->where('barangay_id', $request->barangay_id);
        }

        // Filter by species
        if ($request->has('species') && $request->species) {
            $query->where('species', $request->species);
        }

        $livestocks = $query->orderBy('created_at', 'desc')->paginate(15);
        $barangays = Barangay::orderBy('barangay_name')->get();
        $speciesList = ['cow', 'pig', 'chicken', 'goat', 'sheep', 'duck', 'turkey', 'horse', 'carabao', 'other'];

        return view('admin.livestock.index', compact('livestocks', 'barangays', 'speciesList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangays = Barangay::orderBy('barangay_name')->get();
        $speciesList = ['cow', 'pig', 'chicken', 'goat', 'sheep', 'duck', 'turkey', 'horse', 'carabao', 'other'];
        $genders = ['male', 'female', 'unknown'];
        $ageUnits = ['years', 'months', 'weeks'];
        $statuses = ['active', 'sold', 'deceased', 'slaughtered'];

        return view('admin.livestock.create', compact('barangays', 'speciesList', 'genders', 'ageUnits', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'owner_name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female,unknown',
            'age' => 'nullable|integer|min:0',
            'age_unit' => 'nullable|in:years,months,weeks',
            'tag_number' => 'nullable|string|max:255',
            'owner_contact' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'barangay_id' => 'nullable|exists:barangays,barangay_id',
            'status' => 'nullable|in:active,sold,deceased,slaughtered',
            'notes' => 'nullable|string',
        ]);

        $validated['recorded_by'] = Auth::id();
        $validated['status'] = $validated['status'] ?? 'active';

        Livestock::create($validated);

        return redirect()->route('livestock.index')
            ->with('success', 'Livestock record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Livestock $livestock)
    {
        $livestock->load(['barangay', 'recorder']);

        return view('admin.livestock.show', compact('livestock'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Livestock $livestock)
    {
        $barangays = Barangay::orderBy('barangay_name')->get();
        $speciesList = ['cow', 'pig', 'chicken', 'goat', 'sheep', 'duck', 'turkey', 'horse', 'carabao', 'other'];
        $genders = ['male', 'female', 'unknown'];
        $ageUnits = ['years', 'months', 'weeks'];
        $statuses = ['active', 'sold', 'deceased', 'slaughtered'];

        return view('admin.livestock.edit', compact('livestock', 'barangays', 'speciesList', 'genders', 'ageUnits', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Livestock $livestock)
    {
        $validated = $request->validate([
            'owner_name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female,unknown',
            'age' => 'nullable|integer|min:0',
            'age_unit' => 'nullable|in:years,months,weeks',
            'tag_number' => 'nullable|string|max:255',
            'owner_contact' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'barangay_id' => 'nullable|exists:barangays,barangay_id',
            'status' => 'nullable|in:active,sold,deceased,slaughtered',
            'notes' => 'nullable|string',
        ]);

        $livestock->update($validated);

        return redirect()->route('livestock.index')
            ->with('success', 'Livestock record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Livestock $livestock)
    {
        $livestock->delete();

        return redirect()->route('livestock.index')
            ->with('success', 'Livestock record deleted successfully.');
    }

    /**
     * Display summary/census data.
     */
    public function census(Request $request)
    {
        // Get count by species per barangay
        $censusBySpecies = Livestock::selectRaw('barangay_id, species, COUNT(*) as total_count')
            ->groupBy('barangay_id', 'species')
            ->with('barangay')
            ->get()
            ->groupBy('barangay_id');

        // Get total count per barangay
        $totalByBarangay = Livestock::selectRaw('barangay_id, COUNT(*) as total_count')
            ->groupBy('barangay_id')
            ->with('barangay')
            ->get();

        // Overall totals by species
        $overallBySpecies = Livestock::selectRaw('species, COUNT(*) as total_count')
            ->groupBy('species')
            ->get()
            ->pluck('total_count', 'species');

        $grandTotal = Livestock::count();
        $barangays = Barangay::orderBy('barangay_name')->get();

        return view('admin.livestock.census', compact(
            'censusBySpecies',
            'totalByBarangay',
            'overallBySpecies',
            'grandTotal',
            'barangays'
        ));
    }
}
