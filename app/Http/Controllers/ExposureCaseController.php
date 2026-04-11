<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\ExposureCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExposureCaseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:city_vet|super_admin|assistant_vet']);
    }

    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        $reportType = $request->get('report_type');
        $barangayId = $request->get('barangay_id');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $search = $request->get('search');

        $query = ExposureCase::with(['barangay', 'patientBarangay', 'user']);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($reportType) {
            $query->where('report_type', $reportType);
        }

        if ($barangayId) {
            $query->where('barangay_id', $barangayId);
        }

        if ($dateFrom) {
            $query->whereDate('date_reported', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('date_reported', '<=', $dateTo);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('case_number', 'like', "%{$search}%")
                    ->orWhere('patient_name', 'like', "%{$search}%")
                    ->orWhere('animal_owner_name', 'like', "%{$search}%");
            });
        }

        $cases = $query->orderBy('created_at', 'desc')->paginate(20);

        $stats = [
            'pending' => ExposureCase::where('status', 'pending')->count(),
            'approved' => ExposureCase::where('status', 'approved')->count(),
            'closed' => ExposureCase::where('status', 'closed')->count(),
            'total' => ExposureCase::count(),
        ];

        $barangays = Barangay::orderBy('barangay_name')->get(['barangay_id', 'barangay_name']);

        return view('dashboard.exposure-cases', compact('cases', 'stats', 'barangays'));
    }

    public function show(ExposureCase $exposureCase)
    {
        $exposureCase->load(['barangay', 'patientBarangay', 'user', 'originalReport']);
        return view('dashboard.exposure-case-view', compact('exposureCase'));
    }

    public function update(Request $request, ExposureCase $exposureCase)
    {
        $validated = $request->validate([
            'report_type' => 'sometimes|required|in:bite,suspected_rabies,confirmed_rabies',
            'status' => 'sometimes|required|in:pending,approved,closed',
            'notes' => 'nullable|string',
        ]);

        $exposureCase->update($validated);

        return back()->with('success', 'Case updated successfully.');
    }

    public function approve(Request $request, ExposureCase $exposureCase)
    {
        $action = $request->get('action', 'approve');

        if ($action === 'approve') {
            $exposureCase->update(['status' => 'approved']);
            return back()->with('success', 'Case approved and published to public map.');
        } elseif ($action === 'reject') {
            $exposureCase->update(['status' => 'closed']);
            return back()->with('success', 'Case rejected and closed.');
        }

        return back()->with('error', 'Invalid action.');
    }

    public function updateReportType(Request $request, ExposureCase $exposureCase)
    {
        $validated = $request->validate([
            'report_type' => 'required|in:bite,suspected_rabies,confirmed_rabies',
        ]);

        $exposureCase->update(['report_type' => $validated['report_type']]);

        return back()->with('success', 'Report type updated.');
    }

    public function close(ExposureCase $exposureCase)
    {
        $exposureCase->update(['status' => 'closed']);
        return back()->with('success', 'Case has been closed.');
    }

    public function geomapData(Request $request)
    {
        $year = (int) ($request->year ?? date('Y'));
        $month = $request->month ? (int) $request->month : null;
        $week = $request->week ? (int) $request->week : null;
        $reportType = $request->get('report_type');
        $barangayId = $request->get('barangay_id');

        $heatmapData = $this->getFilteredHeatmapData($year, $month, $week, $reportType, $barangayId);

        $stats = [
            'total' => collect($heatmapData)->sum('count'),
            'bites' => collect($heatmapData)->sum('bite_count'),
            'suspected' => collect($heatmapData)->sum('suspected_count'),
            'confirmed' => collect($heatmapData)->sum('confirmed_count'),
        ];

        $filterLabel = $year;
        if ($month) {
            $monthName = date('F', mktime(0, 0, 0, $month, 1));
            $filterLabel = $week ? "Week $week, $monthName $year" : "$monthName $year";
        }

        return response()->json([
            'heatmapData' => $heatmapData,
            'stats' => $stats,
            'filterLabel' => $filterLabel,
            'year' => $year,
            'month' => $month,
            'week' => $week,
        ]);
    }

    private function getFilteredHeatmapData(int $year, ?int $month = null, ?int $week = null, ?string $reportType = null, ?int $barangayId = null): array
    {
        $query = ExposureCase::whereYear('date_reported', $year)
            ->where('status', 'approved')
            ->whereNotNull('barangay_id');

        if ($month) {
            $query->whereMonth('date_reported', $month);
        }

        if ($week) {
            $query->whereRaw('WEEK(date_reported, 1) = ?', [$week]);
        }

        if ($reportType) {
            $query->where('report_type', $reportType);
        }

        if ($barangayId) {
            $query->where('barangay_id', $barangayId);
        }

        $byBarangay = $query
            ->selectRaw('barangay_id, report_type, COUNT(*) as count')
            ->groupBy('barangay_id', 'report_type')
            ->get();

        $barangays = Barangay::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['barangay_id', 'barangay_name', 'latitude', 'longitude']);

        $result = [];
        foreach ($barangays as $barangay) {
            $barangayCases = $byBarangay->where('barangay_id', $barangay->barangay_id);
            
            $biteCount = (int) $barangayCases->where('report_type', 'bite')->sum('count');
            $suspectedCount = (int) $barangayCases->where('report_type', 'suspected_rabies')->sum('count');
            $confirmedCount = (int) $barangayCases->where('report_type', 'confirmed_rabies')->sum('count');
            $totalCount = $biteCount + $suspectedCount + $confirmedCount;

            $result[] = [
                'id' => 'exp-' . $barangay->barangay_id,
                'barangay_id' => $barangay->barangay_id,
                'barangay' => $barangay->barangay_name,
                'name' => $barangay->barangay_name,
                'latitude' => (float) $barangay->latitude,
                'longitude' => (float) $barangay->longitude,
                'lat' => (float) $barangay->latitude,
                'lng' => (float) $barangay->longitude,
                'count' => $totalCount,
                'bite_count' => $biteCount,
                'suspected_count' => $suspectedCount,
                'confirmed_count' => $confirmedCount,
            ];
        }

        return $result;
    }

    public function migrate()
    {
        if (!Auth::user()->hasRole('super_admin')) {
            abort(403, 'Only super admins can run migration.');
        }

        $count = ExposureCase::migrateFromBiteRabiesReports();

        return back()->with('success', "Migration complete. {$count} cases created.");
    }
}