<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LivestockCensus;
use App\Models\Barangay;

class LivestockCensusController extends Controller
{
    /**
     * Display a listing of livestock census records.
     */
    public function index(Request $request)
    {
        $query = LivestockCensus::query();

        // Filter by species
        if ($request->has('species') && $request->species) {
            $query->where('species', $request->species);
        }

        // Filter by year
        if ($request->has('year') && $request->year) {
            $query->where('report_year', $request->year);
        }

        // Filter by barangay
        if ($request->has('barangay_id') && $request->barangay_id) {
            $query->where('barangay_id', $request->barangay_id);
        }

        // Non-admin users can only see their own entries
        if (!Auth::user()->hasAnyRole(['super_admin', 'city_vet', 'livestock_inspector', 'admin_staff'])) {
            $query->where('encoded_by_user_id', Auth::id());
        }

        $censuses = $query->with('barangay')->latest()->paginate(10);
        $barangays = Barangay::pluck('barangay_name', 'barangay_id');
        $years = range(date('Y'), date('Y') - 10);

        return view('livestock-census.index', compact('censuses', 'barangays', 'years'));
    }

    /**
     * Show the form for creating a new census record.
     */
    public function create()
    {
        $barangays = Barangay::pluck('barangay_name', 'barangay_id');
        return view('livestock-census.create', compact('barangays'));
    }

    /**
     * Store a newly created census record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'barangay_id' => 'nullable|exists:barangays,barangay_id',
            'species' => 'required|string|in:cattle,carabao,swine,horse,goat,dog,pigeon',
            'no_of_heads' => 'required|integer|min:0',
            'no_of_farmers' => 'required|integer|min:0',
            'report_year' => 'required|integer|min:2000|max:' . date('Y'),
            'report_month' => 'required|integer|min:1|max:12',
        ]);

        $validated['encoded_by_user_id'] = Auth::id();

        LivestockCensus::create($validated);

        return redirect()->route('livestock-census.index')
            ->with('success', 'Livestock census record added successfully!');
    }

    /**
     * Display the specified census record.
     */
    public function show(LivestockCensus $census)
    {
        $census->load('barangay', 'user');
        return view('livestock-census.show', compact('census'));
    }

    /**
     * Show the form for editing the census record.
     */
    public function edit(LivestockCensus $census)
    {
        $barangays = Barangay::pluck('barangay_name', 'barangay_id');
        return view('livestock-census.edit', compact('census', 'barangays'));
    }

    /**
     * Update the specified census record.
     */
    public function update(Request $request, LivestockCensus $census)
    {
        $validated = $request->validate([
            'barangay_id' => 'nullable|exists:barangays,barangay_id',
            'species' => 'required|string|in:cattle,carabao,swine,horse,goat,dog,pigeon',
            'no_of_heads' => 'required|integer|min:0',
            'no_of_farmers' => 'required|integer|min:0',
            'report_year' => 'required|integer|min:2000|max:' . date('Y'),
            'report_month' => 'required|integer|min:1|max:12',
        ]);

        $census->update($validated);

        return redirect()->route('livestock-census.index')
            ->with('success', 'Livestock census record updated successfully!');
    }

    /**
     * Remove the specified census record.
     */
    public function destroy(LivestockCensus $census)
    {
        $census->delete();
        return redirect()->route('livestock-census.index')
            ->with('success', 'Livestock census record deleted successfully!');
    }

    /**
     * Get summary report by species.
     */
    public function summary(Request $request)
    {
        $year = $request->year ?? date('Y');
        $month = $request->month ?? date('n');

        $summary = LivestockCensus::where('report_year', $year)
            ->where('report_month', $month)
            ->selectRaw('species, SUM(no_of_heads) as total_heads, SUM(no_of_farmers) as total_farmers')
            ->groupBy('species')
            ->get();

        $totalHeads = $summary->sum('total_heads');
        $totalFarmers = $summary->sum('total_farmers');

        return view('livestock-census.summary', compact('summary', 'totalHeads', 'totalFarmers', 'year', 'month'));
    }
}
