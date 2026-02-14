<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RabiesCase;
use App\Models\Barangay;
use App\Models\Owner;

class RabiesCaseController extends Controller
{
    /**
     * Display a listing of rabies cases.
     */
    public function index(Request $request)
    {
        $query = RabiesCase::query();

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->has('case_type') && $request->case_type) {
            $query->where('case_type', $request->case_type);
        }

        // Filter by barangay
        if ($request->has('barangay_id') && $request->barangay_id) {
            $query->where('barangay_id', $request->barangay_id);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->where('incident_date', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->where('incident_date', '<=', $request->date_to);
        }

        // Non-admin users can only see their own entries
        if (!in_array(Auth::user()->role, ['super_admin', 'admin', 'city_vet', 'disease_control'])) {
            $query->where('user_id', Auth::id());
        }

        $cases = $query->with('barangay', 'owner')->latest()->paginate(10);
        $barangays = Barangay::pluck('barangay_name', 'id');

        return view('rabies-cases.index', compact('cases', 'barangays'));
    }

    /**
     * Show the form for creating a new rabies case.
     */
    public function create()
    {
        $barangays = Barangay::pluck('barangay_name', 'id');
        $owners = Owner::pluck('owner_name', 'id');
        return view('rabies-cases.create', compact('barangays', 'owners'));
    }

    /**
     * Store a newly created rabies case.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'case_number' => 'nullable|string|max:255',
            'case_type' => 'required|string|in:positive,probable,suspect,negative',
            'species' => 'required|string|in:dog,cat,other',
            'animal_name' => 'nullable|string|max:255',
            'owner_id' => 'nullable|exists:owners,id',
            'owner_name' => 'nullable|string|max:255',
            'owner_contact' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'barangay_id' => 'nullable|exists:barangays,id',
            'incident_date' => 'required|date',
            'incident_location' => 'nullable|string',
            'status' => 'nullable|string|in:open,closed,under_investigation',
            'date_submitted' => 'nullable|date',
            'findings' => 'nullable|string',
            'actions_taken' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = $validated['status'] ?? 'open';

        // Auto-generate case number if not provided
        if (empty($validated['case_number'])) {
            $validated['case_number'] = 'RAB-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));
        }

        RabiesCase::create($validated);

        return redirect()->route('rabies-cases.index')
            ->with('success', 'Rabies case recorded successfully!');
    }

    /**
     * Display the specified rabies case.
     */
    public function show(RabiesCase $rabiesCase)
    {
        $rabiesCase->load('barangay', 'owner', 'user');
        return view('rabies-cases.show', compact('rabiesCase'));
    }

    /**
     * Show the form for editing the rabies case.
     */
    public function edit(RabiesCase $rabiesCase)
    {
        $barangays = Barangay::pluck('barangay_name', 'id');
        $owners = Owner::pluck('owner_name', 'id');
        return view('rabies-cases.edit', compact('rabiesCase', 'barangays', 'owners'));
    }

    /**
     * Update the specified rabies case.
     */
    public function update(Request $request, RabiesCase $rabiesCase)
    {
        $validated = $request->validate([
            'case_number' => 'nullable|string|max:255',
            'case_type' => 'required|string|in:positive,probable,suspect,negative',
            'species' => 'required|string|in:dog,cat,other',
            'animal_name' => 'nullable|string|max:255',
            'owner_id' => 'nullable|exists:owners,id',
            'owner_name' => 'nullable|string|max:255',
            'owner_contact' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'barangay_id' => 'nullable|exists:barangays,id',
            'incident_date' => 'required|date',
            'incident_location' => 'nullable|string',
            'status' => 'nullable|string|in:open,closed,under_investigation',
            'date_submitted' => 'nullable|date',
            'findings' => 'nullable|string',
            'actions_taken' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $rabiesCase->update($validated);

        return redirect()->route('rabies-cases.index')
            ->with('success', 'Rabies case updated successfully!');
    }

    /**
     * Remove the specified rabies case.
     */
    public function destroy(RabiesCase $rabiesCase)
    {
        $rabiesCase->delete();
        return redirect()->route('rabies-cases.index')
            ->with('success', 'Rabies case deleted successfully!');
    }

    /**
     * Get summary report.
     */
    public function summary(Request $request)
    {
        $year = $request->year ?? date('Y');

        $byType = RabiesCase::whereYear('incident_date', $year)
            ->selectRaw('case_type, COUNT(*) as count')
            ->groupBy('case_type')
            ->pluck('count', 'case_type')
            ->toArray();

        $bySpecies = RabiesCase::whereYear('incident_date', $year)
            ->selectRaw('species, COUNT(*) as count')
            ->groupBy('species')
            ->pluck('count', 'species')
            ->toArray();

        $byMonth = RabiesCase::whereYear('incident_date', $year)
            ->selectRaw('MONTH(incident_date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        return view('rabies-cases.summary', compact('byType', 'bySpecies', 'byMonth', 'year'));
    }
}
