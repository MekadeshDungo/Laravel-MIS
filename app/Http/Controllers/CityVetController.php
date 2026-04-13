<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\BiteRabiesReport;
use App\Models\RabiesVaccinationReport;
use App\Models\Barangay;
use App\Models\ImpoundRecord;

class CityVetController extends Controller
{
    /**
     * Show city veterinarian dashboard.
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        // Get statistics - use bite_rabies_reports for counts
        $year = $request->year ?? date('Y');

        $stats = [
            'total_rabies_cases' => BiteRabiesReport::whereYear('incident_date', $year)->count(),
            'open_cases' => BiteRabiesReport::where('status', 'Pending Review')->whereYear('incident_date', $year)->count(),
            'confirmed_cases' => BiteRabiesReport::where('animal_status', 'Stray')->whereYear('incident_date', $year)->count(),
            'total_bite_reports' => BiteRabiesReport::whereYear('incident_date', $year)->count(),
            'total_vaccinations' => RabiesVaccinationReport::whereYear('vaccination_date', $year)->count(),
        ];

        // Get recent cases
        $recentCases = BiteRabiesReport::with('barangay')->latest()->take(5)->get();

        // Get monthly trends for the year
        $monthlyCases = BiteRabiesReport::whereYear('incident_date', $year)
            ->selectRaw('MONTH(incident_date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Get cases by type
        $casesByType = BiteRabiesReport::whereYear('incident_date', $year)
            ->selectRaw('animal_type, COUNT(*) as count')
            ->groupBy('animal_type')
            ->pluck('count', 'animal_type')
            ->toArray();

        // Get heatmap data
        $heatmapData = $this->getHeatmapData($year);

        // Get all barangays for filter dropdown
        $barangays = Barangay::pluck('barangay_name', 'barangay_id');

        return view('dashboard.city-vet', compact(
            'user',
            'stats',
            'recentCases',
            'monthlyCases',
            'casesByType',
            'heatmapData',
            'barangays',
            'year'
        ));
    }

    /**
     * Show rabies geomap.
     */
    public function geomap(Request $request)
    {
        $user = Auth::user();
        $year = $request->year ?? date('Y');
        $previousYear = $year - 1;

        // Get heatmap data
        $heatmapData = $this->getHeatmapData($year);
        
        // Get case type breakdown
        $caseTypeBreakdown = $this->getCaseTypeBreakdown($year);
        
        // Get monthly timeline
        $monthlyTimeline = $this->getMonthlyTimeline($year);
        
        // Get year comparison
        $yearComparison = $this->getYearComparison($year, $previousYear);
        
        // Get top hotspots
        $hotspots = $this->getHotspots($year);

        return view('city-vet.rabies-geomap', compact(
            'user', 
            'heatmapData', 
            'year',
            'caseTypeBreakdown',
            'monthlyTimeline',
            'yearComparison',
            'hotspots'
        ));
    }

    /**
     * Get heatmap data for rabies cases.
     */
    private function getHeatmapData(int $year): array
    {
        // Get cases grouped by barangay from bite_rabies_reports
        // Use barangay_id (where the bite incident occurred)
        $byBarangay = BiteRabiesReport::whereYear('incident_date', $year)
            ->whereNotNull('barangay_id')
            ->where('barangay_id', '!=', '')
            ->selectRaw('barangay_id, COUNT(*) as count')
            ->groupBy('barangay_id')
            ->get();

        // Get ALL barangays with coordinates (not just those with cases)
        $barangays = Barangay::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['barangay_id', 'barangay_name', 'latitude', 'longitude']);

        $maxCount = $byBarangay->max('count') ?: 1;

        return $barangays->map(function ($barangay) use ($byBarangay, $maxCount) {
            $caseCount = $byBarangay->firstWhere('barangay_id', $barangay->barangay_id);
            $count = $caseCount ? (int) $caseCount->count : 0;

            return [
                'id' => 'rabies-' . $barangay->barangay_id,
                'barangay_id' => $barangay->barangay_id,
                'barangay' => $barangay->barangay_name,
                'name' => $barangay->barangay_name,
                'latitude' => (float) $barangay->latitude,
                'longitude' => (float) $barangay->longitude,
                'lat' => (float) $barangay->latitude,
                'lng' => (float) $barangay->longitude,
                'count' => $count,
                'intensity' => round($count / $maxCount, 2),
                'incident_type' => 'rabies',
            ];
        })->toArray();
    }

    /**
     * Get case type breakdown.
     */
    private function getCaseTypeBreakdown(int $year): array
    {
        return BiteRabiesReport::whereYear('incident_date', $year)
            ->selectRaw('animal_type, COUNT(*) as count')
            ->groupBy('animal_type')
            ->pluck('count', 'animal_type')
            ->toArray();
    }

    /**
     * Get monthly timeline data.
     */
    private function getMonthlyTimeline(int $year): array
    {
        $months = ['Jan' => 1, 'Feb' => 2, 'Mar' => 3, 'Apr' => 4, 'May' => 5, 'Jun' => 6, 
                   'Jul' => 7, 'Aug' => 8, 'Sep' => 9, 'Oct' => 10, 'Nov' => 11, 'Dec' => 12];
        
        $data = [];
        foreach ($months as $monthName => $monthNum) {
            $count = BiteRabiesReport::whereYear('incident_date', $year)
                ->whereMonth('incident_date', $monthNum)
                ->count();
            $data[$monthName] = $count;
        }
        
        return $data;
    }

    /**
     * Get year-over-year comparison.
     */
    private function getYearComparison(int $currentYear, int $previousYear): array
    {
        $current = BiteRabiesReport::whereYear('incident_date', $currentYear)->count();
        $previous = BiteRabiesReport::whereYear('incident_date', $previousYear)->count();
        
        $change = $previous > 0 ? round((($current - $previous) / $previous) * 100, 1) : 0;
        
        return [
            'current' => $current,
            'previous' => $previous,
            'change' => $change,
            'direction' => $change > 0 ? 'up' : ($change < 0 ? 'down' : 'stable')
        ];
    }

    /**
     * Get top hotspots (barangays with most cases).
     */
    private function getHotspots(int $year): array
    {
        return BiteRabiesReport::whereYear('incident_date', $year)
            ->with('barangay')
            ->selectRaw('barangay_id, COUNT(*) as count')
            ->groupBy('barangay_id')
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'barangay_id' => $item->barangay_id,
                    'barangay_name' => $item->barangay?->barangay_name ?? 'Unknown',
                    'count' => (int) $item->count
                ];
            })
            ->toArray();
    }

    /**
     * API endpoint for filtered geomap data (AJAX).
     */
    public function geomapData(Request $request)
    {
        $year = (int) ($request->year ?? date('Y'));
        $month = $request->month ? (int) $request->month : null;
        $week = $request->week ? (int) $request->week : null;
        $dateFrom = $request->date_from ?: null;
        $dateTo = $request->date_to ?: null;

        // Debug: Check if data exists
        $totalInDb = BiteRabiesReport::whereYear('incident_date', $year)->count();
        $withBarangay = BiteRabiesReport::whereYear('incident_date', $year)
            ->whereNotNull('barangay_id')->count();

        $heatmapData = $this->getFilteredHeatmapData($year, $month, $week, $dateFrom, $dateTo);
        $caseTypeBreakdown = $this->getFilteredCaseTypeBreakdown($year, $month, $week, $dateFrom, $dateTo);
        $totalCases = collect($heatmapData)->sum('count');

        $filterLabel = $year;
        if ($dateFrom && $dateTo) {
            $filterLabel = \Carbon\Carbon::parse($dateFrom)->format('M d') . ' - ' . \Carbon\Carbon::parse($dateTo)->format('M d, Y');
        } elseif ($month && $week) {
            $monthName = date('F', mktime(0, 0, 0, $month, 1));
            $filterLabel = "Week $week, $monthName $year";
        } elseif ($month) {
            $monthName = date('F', mktime(0, 0, 0, $month, 1));
            $filterLabel = "$monthName $year";
        }

        return response()->json([
            'heatmapData' => $heatmapData,
            'caseTypeBreakdown' => $caseTypeBreakdown,
            'totalCases' => $totalCases,
            'filterLabel' => $filterLabel,
            'year' => $year,
            'month' => $month,
            'week' => $week,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'debug' => [
                'total_in_db' => $totalInDb,
                'with_barangay' => $withBarangay,
            ],
        ]);
    }

    /**
     * Get filtered heatmap data by year, month, and/or week.
     */
    private function getFilteredHeatmapData(int $year, ?int $month = null, ?int $week = null, ?string $dateFrom = null, ?string $dateTo = null): array
    {
        $query = BiteRabiesReport::whereYear('incident_date', $year)
            ->whereNotNull('barangay_id')
            ->where('barangay_id', '!=', '');

        if ($dateFrom) {
            $query->where('incident_date', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->where('incident_date', '<=', $dateTo);
        }

        if ($month) {
            $query->whereMonth('incident_date', $month);
        }

        if ($week) {
            $query->whereRaw('WEEK(incident_date, 1) = ?', [$week]);
        }

        $byBarangay = $query
            ->selectRaw('barangay_id, COUNT(*) as count')
            ->groupBy('barangay_id')
            ->get();

        $barangays = Barangay::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['barangay_id', 'barangay_name', 'latitude', 'longitude']);

        $maxCount = $byBarangay->max('count') ?: 1;

        return $barangays->map(function ($barangay) use ($byBarangay, $maxCount) {
            $caseCount = $byBarangay->firstWhere('barangay_id', $barangay->barangay_id);
            $count = $caseCount ? (int) $caseCount->count : 0;

            return [
                'id' => 'bite-' . $barangay->barangay_id,
                'barangay_id' => $barangay->barangay_id,
                'barangay' => $barangay->barangay_name,
                'name' => $barangay->barangay_name,
                'latitude' => (float) $barangay->latitude,
                'longitude' => (float) $barangay->longitude,
                'lat' => (float) $barangay->latitude,
                'lng' => (float) $barangay->longitude,
                'count' => $count,
                'intensity' => round($count / $maxCount, 2),
                'incident_type' => 'rabies',
            ];
        })->toArray();
    }

    /**
     * Get filtered case type breakdown by year, month, and/or week.
     */
    private function getFilteredCaseTypeBreakdown(int $year, ?int $month = null, ?int $week = null, ?string $dateFrom = null, ?string $dateTo = null): array
    {
        $query = BiteRabiesReport::whereYear('incident_date', $year);

        if ($dateFrom) {
            $query->where('incident_date', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->where('incident_date', '<=', $dateTo);
        }

        if ($month) {
            $query->whereMonth('incident_date', $month);
        }

        if ($week) {
            $query->whereRaw('WEEK(incident_date, 1) = ?', [$week]);
        }

        return $query
            ->selectRaw('animal_type, COUNT(*) as count')
            ->groupBy('animal_type')
            ->pluck('count', 'animal_type')
            ->toArray();
    }
}
