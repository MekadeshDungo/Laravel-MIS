<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RabiesCase;
use App\Models\Barangay;
use App\Models\Owner;
use App\Models\BiteRabiesReport;

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
        if (!Auth::user()->hasAnyRole(['super_admin', 'city_vet', 'disease_control', 'admin_staff'])) {
            $query->where('user_id', Auth::id());
        }

        $cases = $query->with('barangay', 'owner')->latest()->paginate(10);
        $barangays = Barangay::pluck('barangay_name', 'barangay_id');

        return view('rabies-cases.index', compact('cases', 'barangays'));
    }

    /**
     * Show the form for creating a new rabies case.
     */
    public function create()
    {
        $barangays = Barangay::pluck('barangay_name', 'barangay_id');
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
        $barangays = Barangay::pluck('barangay_name', 'barangay_id');
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

    /**
     * Display the rabies heatmap/geomap page.
     *
     * Access Control:
     * - City Veterinarian (city_vet): Full access with all filters
     * - Veterinarian III (veterinarian): View-only access
     * - Other roles: Denied (403)
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function geomap(Request $request)
    {
        // Check user role for access control
        $user = Auth::user();

        // Define access levels
        // City Veterinarian: Full operational access
        // Veterinarian III: View-only access
        $allowedRoles = ['city_vet', 'veterinarian'];

        // Check if user has access using Spatie
        $hasAccess = $user->hasAnyRole($allowedRoles);

        if (!$hasAccess) {
            abort(403, 'Access denied. Only City Veterinarian and Veterinarian III can access the rabies geomap.');
        }

        // Determine access level based on role
        $isCityVet = $user->hasRole('city_vet');
        $accessLevel = $isCityVet ? 'full_operational' : 'view_only';

        // Get parameters from request
        $year = $request->year ?? 2026;
        $incidentType = $request->type ?? 'all';

        // Get heatmap data based on type filter
        if ($incidentType === 'rabies') {
            $heatmapData = $this->getRabiesHeatmapData($year);
        } elseif ($incidentType === 'bite') {
            $heatmapData = $this->getBiteIncidentData($year);
        } else {
            // Combined: rabies + bite incidents
            $rabiesData = $this->getRabiesHeatmapData($year);
            $biteData = $this->getBiteIncidentData($year);
            $heatmapData = array_merge($rabiesData, $biteData);
        }

        // Get statistics
        $stats = $this->getCombinedStats($year);

        // Get all barangays for filter dropdown
        $barangays = Barangay::pluck('barangay_name', 'barangay_id');

        return view('dashboard.rabies-geomap', compact('heatmapData', 'stats', 'accessLevel', 'year', 'incidentType', 'barangays'));
    }

    /**
     * Get rabies cases heatmap data.
     */
    private function getRabiesHeatmapData(int $year): array
    {
        // Get rabies cases filtered by Dasmariñas city only
        $byBarangay = RabiesCase::whereYear('incident_date', $year)
            ->whereNotNull('barangay_id')
            ->whereHas('barangay', function($query) {
                $query->where('city', 'dasmarinas');
            })
            ->selectRaw('barangay_id, COUNT(*) as count')
            ->groupBy('barangay_id')
            ->get();

        // Get ALL barangays in Dasmariñas with coordinates (not just those with cases)
        $barangays = Barangay::where('city', 'dasmarinas')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        $maxCount = $byBarangay->max('count') ?: 1;

        return $barangays->map(function ($barangay) use ($byBarangay, $maxCount) {
            $caseCount = $byBarangay->firstWhere('barangay_id', $barangay->barangay_id);
            $count = $caseCount ? $caseCount->count : 0;
            $intensity = $count / $maxCount;

            return [
                'id' => 'rabies-' . $barangay->barangay_id,
                'barangay_id' => $barangay->barangay_id,
                'barangay' => $barangay->barangay_name,
                'latitude' => (float) $barangay->latitude,
                'longitude' => (float) $barangay->longitude,
                'count' => (int) $count,
                'intensity' => round($intensity, 2),
                'incident_type' => 'rabies',
                'type_label' => 'Rabies Case',
            ];
        })->toArray();
    }

    /**
     * Get bite incidents heatmap data.
     */
    private function getBiteIncidentData(int $year): array
    {
        // Get bite incidents filtered by Dasmariñas city only
        $byBarangay = BiteRabiesReport::whereYear('incident_date', $year)
            ->whereNotNull('barangay_id')
            ->whereHas('barangay', function($query) {
                $query->where('city', 'dasmarinas');
            })
            ->selectRaw('barangay_id, COUNT(*) as count')
            ->groupBy('barangay_id')
            ->get();

        // Get ALL barangays in Dasmariñas with coordinates (not just those with cases)
        $barangays = Barangay::where('city', 'dasmarinas')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        $maxCount = $byBarangay->max('count') ?: 1;

        return $barangays->map(function ($barangay) use ($byBarangay, $maxCount) {
            $caseCount = $byBarangay->firstWhere('barangay_id', $barangay->barangay_id);
            $count = $caseCount ? $caseCount->count : 0;
            $intensity = $count / $maxCount;

            return [
                'id' => 'bite-' . $barangay->barangay_id,
                'barangay_id' => $barangay->barangay_id,
                'barangay' => $barangay->barangay_name,
                'latitude' => (float) $barangay->latitude,
                'longitude' => (float) $barangay->longitude,
                'count' => (int) $count,
                'intensity' => round($intensity, 2),
                'incident_type' => 'bite',
                'type_label' => 'Bite Incident',
            ];
        })->toArray();
    }

    /**
     * Get combined statistics for rabies and bite incidents.
     */
    private function getCombinedStats(int $year): array
    {
        // Rabies stats
        $rabiesByBarangay = RabiesCase::whereYear('incident_date', $year)
            ->whereNotNull('barangay_id')
            ->selectRaw('barangay_id, COUNT(*) as count')
            ->groupBy('barangay_id')
            ->get();

        $rabiesHighestId = $rabiesByBarangay->sortByDesc('count')->first()?->barangay_id;
        $rabiesHighest = $rabiesHighestId ? Barangay::find($rabiesHighestId)?->barangay_name : null;

        // Bite incident stats
        $biteByBarangay = BiteRabiesReport::whereYear('incident_date', $year)
            ->whereNotNull('barangay_id')
            ->selectRaw('barangay_id, COUNT(*) as count')
            ->groupBy('barangay_id')
            ->get();

        $biteHighestId = $biteByBarangay->sortByDesc('count')->first()?->barangay_id;
        $biteHighest = $biteHighestId ? Barangay::find($biteHighestId)?->barangay_name : null;

        return [
            'rabies' => [
                'total_cases' => (int) $rabiesByBarangay->sum('count'),
                'affected_barangays' => $rabiesByBarangay->count(),
                'highest_count' => (int) $rabiesByBarangay->max('count'),
                'highest_barangay' => $rabiesHighest,
            ],
            'bite' => [
                'total_cases' => (int) $biteByBarangay->sum('count'),
                'affected_barangays' => $biteByBarangay->count(),
                'highest_count' => (int) $biteByBarangay->max('count'),
                'highest_barangay' => $biteHighest,
            ],
            'total_cases' => (int) $rabiesByBarangay->sum('count') + (int) $biteByBarangay->sum('count'),
        ];
    }

    /**
     * Get heatmap data for rabies cases by location.
     *
     * Access Control:
     * - City Veterinarian (city_vet): Full access with all filters
     * - Veterinarian III (veterinarian): View-only access
     * - Other roles: Denied
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @queryParam year int Filter by year (default: current year)
     * @queryParam month int Filter by month (1-12)
     * @queryParam type string Filter by case type (positive, probable, suspect, negative)
     * @queryParam date_from string Filter by start date (Y-m-d)
     * @queryParam date_to string Filter by end date (Y-m-d)
     */
    public function heatmap(Request $request)
    {
        // Check user role for access control
        $user = Auth::user();

        // Define access levels
        $allowedRoles = ['city_vet', 'veterinarian'];

        // Check if user has access using Spatie
        $hasAccess = $user->hasAnyRole($allowedRoles);

        if (!$hasAccess) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Only City Veterinarian and Veterinarian III can access the rabies heatmap.',
            ], 403);
        }

        // Determine access level based on role
        // City Vet gets full operational access
        // Veterinarian gets view-only access
        $isCityVet = $user->hasRole('city_vet');
        $isVeterinarian = $user->hasRole('veterinarian');

        // Validate request - apply stricter validation for Veterinarian (view-only)
        if ($isVeterinarian && !$isCityVet) {
            // Veterinarian: Limited filters (only year for viewing)
            $validated = $request->validate([
                'year' => 'nullable|integer|min:2020|max:' . (date('Y') + 1),
            ]);
        } else {
            // City Vet: Full filters for operational decision-making
            $validated = $request->validate([
                'year' => 'nullable|integer|min:2020|max:' . (date('Y') + 1),
                'month' => 'nullable|integer|min:1|max:12',
                'type' => 'nullable|string|in:positive,probable,suspect,negative',
                'date_from' => 'nullable|date',
                'date_to' => 'nullable|date|after_or_equal:date_from',
            ]);
        }

        $year = $request->year ?? date('Y');
        $month = $request->month;
        $caseType = $request->type;
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;

        $query = RabiesCase::query()
            ->whereYear('incident_date', $year)
            ->whereNotNull('barangay_id');

        // Apply filters
        if ($month) {
            $query->whereMonth('incident_date', $month);
        }

        if ($caseType) {
            $query->where('case_type', $caseType);
        }

        if ($dateFrom) {
            $query->where('incident_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->where('incident_date', '<=', $dateTo);
        }

        // Get cases grouped by barangay with counts
        $byBarangay = $query->selectRaw('barangay_id, COUNT(*) as count')
            ->groupBy('barangay_id')
            ->get();

        // Get barangay data with coordinates
        $barangays = Barangay::whereIn('barangay_id', $byBarangay->pluck('barangay_id'))
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        // Merge data with additional details for visualization libraries
        $heatmapData = $barangays->map(function ($barangay) use ($byBarangay) {
            $caseCount = $byBarangay->firstWhere('barangay_id', $barangay->barangay_id);
            $count = $caseCount ? $caseCount->count : 0;

            // Calculate intensity for heatmap (0-1 scale)
            $maxCount = $byBarangay->max('count') ?: 1;
            $intensity = $count / $maxCount;

            return [
                'barangay_id' => $barangay->barangay_id,
                'barangay' => $barangay->barangay_name,
                'latitude' => (float) $barangay->latitude,
                'longitude' => (float) $barangay->longitude,
                'count' => (int) $count,
                'intensity' => round($intensity, 2),
                // GeoJSON format for mapping libraries
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [
                        (float) $barangay->longitude,
                        (float) $barangay->latitude
                    ]
                ],
                'properties' => [
                    'name' => $barangay->barangay_name,
                    'cases' => (int) $count,
                    'intensity' => round($intensity, 2),
                ]
            ];
        });

        // Calculate comprehensive statistics
        $highestBarangayId = $byBarangay->sortByDesc('count')->first()?->barangay_id;
        $highestBarangay = $highestBarangayId ? Barangay::find($highestBarangayId)?->barangay_name : null;

        // Get cases by type for the filtered data
        $casesByType = (clone $query)->selectRaw('case_type, COUNT(*) as count')
            ->groupBy('case_type')
            ->pluck('count', 'case_type')
            ->toArray();

        // Get cases by species
        $casesBySpecies = (clone $query)->selectRaw('species, COUNT(*) as count')
            ->groupBy('species')
            ->pluck('count', 'species')
            ->toArray();

        // Monthly distribution
        $monthlyDistribution = (clone $query)->selectRaw('MONTH(incident_date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $stats = [
            'total_cases' => (int) $byBarangay->sum('count'),
            'affected_barangays' => $byBarangay->count(),
            'highest_count' => (int) $byBarangay->max('count'),
            'highest_barangay' => $highestBarangay,
            'average_per_barangay' => $byBarangay->count() > 0
                ? round($byBarangay->sum('count') / $byBarangay->count(), 1)
                : 0,
            'by_type' => $casesByType,
            'by_species' => $casesBySpecies,
            'monthly_distribution' => $monthlyDistribution,
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'heatmap' => $heatmapData,
                'geojson' => [
                    'type' => 'FeatureCollection',
                    'features' => $heatmapData->map(function ($item) {
                        return [
                            'type' => 'Feature',
                            'geometry' => $item['geometry'],
                            'properties' => $item['properties']
                        ];
                    })->values()->all()
                ]
            ],
            'stats' => $stats,
            'filters' => [
                'year' => $year,
                'month' => $month,
                'type' => $caseType,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
            ],
            'metadata' => [
                'generated_at' => now()->toIso8601String(),
                'total_records' => $heatmapData->count(),
                'access_level' => $isCityVet ? 'full_operational' : 'view_only',
                'access_role' => $isCityVet ? 'city_vet' : 'super_admin',
                'access_description' => $isCityVet
                    ? 'Full access: Can filter by barangay, date, case severity for operational decision-making'
                    : 'View-only access: For system monitoring and troubleshooting only',
            ]
        ]);
    }

    /**
     * Get individual rabies incidents with coordinates for map markers
     * API Endpoint: GET /api/rabies/incidents
     */
    public function getIncidents(Request $request)
    {
        $user = Auth::user();

        // Check access using Spatie
        $allowedRoles = ['city_vet', 'assistant_vet', 'super_admin'];
        $hasAccess = $user->hasAnyRole($allowedRoles);

        if (!$hasAccess) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied',
            ], 403);
        }

        $year = $request->year ?? date('Y');

        // Get rabies cases with barangay coordinates
        $cases = RabiesCase::whereYear('incident_date', $year)
            ->whereHas('barangay', function($q) {
                $q->whereNotNull('latitude')->whereNotNull('longitude');
            })
            ->with('barangay')
            ->get()
            ->map(function($case) {
                return [
                    'id' => $case->id,
                    'case_number' => $case->case_number,
                    'victim_name' => $case->owner_name ?? 'Unknown',
                    'incident_date' => $case->incident_date?->format('Y-m-d'),
                    'barangay_name' => $case->barangay?->barangay_name,
                    'case_type' => $case->case_type,
                    'species' => $case->species,
                    'status' => $case->status,
                    'latitude' => (float) $case->barangay?->latitude,
                    'longitude' => (float) $case->barangay?->longitude,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $cases,
            'count' => $cases->count(),
        ]);
    }

    /**
     * Get barangays with rabies case counts for map markers
     * API Endpoint: GET /api/rabies/barangays
     */
    public function getBarangaysWithCaseCounts(Request $request)
    {
        $user = Auth::user();

        // Check access using Spatie
        $allowedRoles = ['city_vet', 'assistant_vet', 'super_admin'];
        $hasAccess = $user->hasAnyRole($allowedRoles);

        if (!$hasAccess) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied',
            ], 403);
        }

        $year = $request->year ?? date('Y');

        // Get all barangays with coordinates
        $barangays = Barangay::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->map(function($barangay) use ($year) {
                // Count rabies cases for this barangay in the selected year
                $caseCount = RabiesCase::where('barangay_id', $barangay->id)
                    ->whereYear('incident_date', $year)
                    ->count();

                return [
                    'id' => $barangay->id,
                    'name' => $barangay->barangay_name,
                    'latitude' => (float) $barangay->latitude,
                    'longitude' => (float) $barangay->longitude,
                    'case_count' => $caseCount,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $barangays,
            'count' => $barangays->count(),
        ]);
    }

    /**
     * Get rabies case counts by barangay name for heatmap
     * API Endpoint: GET /api/rabies/heatmap-data
     * Returns barangay name matched with case counts for GeoJSON mapping
     */
    public function getHeatmapData(Request $request)
    {
        $user = Auth::user();

        // Check access using Spatie
        $allowedRoles = ['city_vet', 'assistant_vet', 'super_admin'];
        $hasAccess = $user->hasAnyRole($allowedRoles);

        if (!$hasAccess) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied',
            ], 403);
        }

        $year = $request->year ?? date('Y');

        // Get rabies case counts grouped by barangay name
        $caseCounts = RabiesCase::whereYear('incident_date', $year)
            ->whereNotNull('barangay_id')
            ->with('barangay')
            ->get()
            ->groupBy(function($case) {
                return $case->barangay->barangay_name ?? 'Unknown';
            })
            ->map(function($cases, $barangayName) {
                return [
                    'name' => $barangayName,
                    'case_count' => $cases->count(),
                    'severity' => $cases->count() <= 2 ? 'low' : ($cases->count() <= 5 ? 'medium' : 'high'),
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'data' => $caseCounts,
            'year' => $year,
        ]);
    }
}
