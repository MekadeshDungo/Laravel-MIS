<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RabiesCase;
use App\Models\AnimalBiteReport;
use App\Models\RabiesReport;
use Carbon\Carbon;

/**
 * DiseaseControlController - Assistant Veterinarian Module
 *
 * THESIS ROLE MAPPING:
 * - Primary Role: assistant_vet (Assistant Veterinarian / Vet 3)
 *
 * MODULE ASSIGNMENTS:
 * - Rabies Case Management (CRUD)
 * - Animal Bite Reports (Clinical Actions)
 * - Vaccination Records
 * - Spay/Neuter Program
 * - Cruelty Assessment
 *
 * ACCESSIBLE ROUTES:
 * - assistant-vet.dashboard
 * - assistant-vet.rabies-cases.*
 * - assistant-vet.animal-bite-reports.*
 * - assistant-vet.vaccinations.*
 * - assistant-vet.spay-neuter.*
 */
class DiseaseControlController extends Controller
{
    /**
     * Show disease control / Assistant Vet dashboard.
     *
     * Module: Dashboard & Analytics
     * Role: assistant_vet
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Get statistics for Animal Bite Reports
        $biteStats = [
            'total' => AnimalBiteReport::count(),
            'pending' => AnimalBiteReport::where('status', 'pending')->count(),
            'investigating' => AnimalBiteReport::where('status', 'investigating')->count(),
            'resolved' => AnimalBiteReport::where('status', 'resolved')->count(),
        ];

        // Get statistics for Rabies Reports
        $rabiesStats = [
            'total' => RabiesReport::count(),
            'pending' => RabiesReport::where('status', 'Pending Review')->count(),
            'under_review' => RabiesReport::where('status', 'Under Review')->count(),
            'resolved' => RabiesReport::where('status', 'Resolved')->count(),
            'closed' => RabiesReport::where('status', 'Closed')->count(),
        ];

        // Combined stats
        $stats = [
            'total_rabies_cases' => RabiesCase::count(),
            'open_cases' => RabiesCase::where('status', 'open')->count(),
            'total_bite_reports' => $biteStats['total'] + $rabiesStats['total'],
            'bite_stats' => $biteStats,
            'rabies_stats' => $rabiesStats,
        ];

        // Get recent cases with relationships
        $recentCases = RabiesCase::with(['barangay', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.assistant-veterinary', compact('user', 'stats', 'recentCases'));
    }

    /**
     * List rabies cases.
     *
     * Module: Rabies Case Management
     * Role: assistant_vet
     */
    public function indexCases(Request $request)
    {
        $user = Auth::user();
        $query = RabiesCase::with(['barangay', 'user']);

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $cases = $query->latest()->paginate(10);
        return view('dashboard.rabies-cases', compact('user', 'cases'));
    }

    /**
     * List animal bite reports.
     *
     * Module: Clinical Actions (Bite Reports)
     * Role: assistant_vet
     */
    public function indexBiteReports(Request $request)
    {
        $user = Auth::user();

        // Get Animal Bite Report stats
        $biteStats = [
            'total' => AnimalBiteReport::count(),
            'pending' => AnimalBiteReport::where('status', 'pending')->count(),
            'in_progress' => AnimalBiteReport::where('status', 'in_progress')->count(),
            'resolved' => AnimalBiteReport::where('status', 'resolved')->count(),
        ];

        // Get Rabies Report stats
        $rabiesStats = [
            'total' => RabiesReport::count(),
            'pending' => RabiesReport::where('status', 'Pending Review')->count(),
            'under_review' => RabiesReport::where('status', 'Under Review')->count(),
            'resolved' => RabiesReport::where('status', 'Resolved')->count(),
            'closed' => RabiesReport::where('status', 'Closed')->count(),
        ];

        // Combined stats
        $stats = [
            'bite' => $biteStats,
            'rabies' => $rabiesStats,
            'total' => $biteStats['total'] + $rabiesStats['total'],
        ];

        // Get type filter
        $type = $request->get('type', 'all');

        // Get reports based on type filter
        $biteQuery = AnimalBiteReport::with(['barangay']);
        $rabiesQuery = RabiesReport::with(['patientBarangay']);

        // Apply quick filter
        if ($request->has('quick_filter') && $request->quick_filter) {
            $today = Carbon::now()->startOfDay();
            switch ($request->quick_filter) {
                case 'today':
                    $biteQuery->whereDate('created_at', $today);
                    $rabiesQuery->whereDate('created_at', $today);
                    break;
                case 'week':
                    $biteQuery->where('created_at', '>=', Carbon::now()->startOfWeek());
                    $rabiesQuery->where('created_at', '>=', Carbon::now()->startOfWeek());
                    break;
                case 'month':
                    $biteQuery->where('created_at', '>=', Carbon::now()->startOfMonth());
                    $rabiesQuery->where('created_at', '>=', Carbon::now()->startOfMonth());
                    break;
            }
        }

        // Apply status filter to the appropriate query
        if ($request->has('status') && $request->status) {
            if ($type === 'bite' || $type === 'all') {
                $biteQuery->where('status', $request->status);
            }
            if ($type === 'rabies' || $type === 'all') {
                // Map status for rabies reports
                $rabiesStatusMap = [
                    'pending' => 'Pending Review',
                    'in_progress' => 'Under Review',
                    'resolved' => 'Resolved',
                    'closed' => 'Closed',
                ];
                $rabiesStatus = $rabiesStatusMap[$request->status] ?? $request->status;
                $rabiesQuery->where('status', $rabiesStatus);
            }
        }

        // Date filters
        if ($request->has('date_from') && $request->date_from) {
            if ($type === 'bite' || $type === 'all') {
                $biteQuery->whereDate('created_at', '>=', $request->date_from);
            }
            if ($type === 'rabies' || $type === 'all') {
                $rabiesQuery->whereDate('created_at', '>=', $request->date_from);
            }
        }
        if ($request->has('date_to') && $request->date_to) {
            if ($type === 'bite' || $type === 'all') {
                $biteQuery->whereDate('created_at', '<=', $request->date_to);
            }
            if ($type === 'rabies' || $type === 'all') {
                $rabiesQuery->whereDate('created_at', '<=', $request->date_to);
            }
        }

        // Get the reports
        $biteReports = $biteQuery->latest()->get();
        $rabiesReports = $rabiesQuery->latest()->get();

        // Add type indicator and combine
        $biteReports->each(function($r) { $r->report_type = 'bite'; });
        $rabiesReports->each(function($r) { $r->report_type = 'rabies'; });

        // Combine and paginate
        $combined = $biteReports->concat($rabiesReports)->sortByDesc('created_at');
        $perPage = 15;
        $page = request()->get('page', 1);
        $reports = new \Illuminate\Pagination\LengthAwarePaginator(
            $combined->forPage($page, $perPage),
            $combined->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('dashboard.bite-reports', compact('user', 'reports', 'stats', 'type'));
    }

    /**
     * Show rabies case details.
     */
    public function showCase(RabiesCase $case)
    {
        $case->load(['barangay', 'user', 'rabiesReport']);
        return view('dashboard.rabies-cases.show', compact('case'));
    }

    /**
     * Mark rabies case as complete.
     *
     * Module: Clinical Actions
     * Role: assistant_vet
     */
    public function markComplete(RabiesCase $case)
    {
        $case->update(['status' => 'closed']);
        return redirect()->back()->with('success', 'Case marked as complete.');
    }

    /**
     * Show bite report details.
     */
    public function showBiteReport(AnimalBiteReport $report)
    {
        $report->load(['barangay', 'user']);
        return view('dashboard.bite-reports.show', compact('report'));
    }

    /**
     * Mark bite report as complete.
     *
     * Module: Clinical Actions
     * Role: assistant_vet
     */
    public function markBiteComplete(AnimalBiteReport $report)
    {
        $report->update(['status' => 'investigating']);
        return redirect()->back()->with('success', 'Report checked and acknowledged.');
    }

    /**
     * Check/Acknowledge rabies report.
     *
     * Module: Clinical Actions
     * Role: assistant_vet
     */
    public function checkRabiesReport(RabiesReport $rabiesReport)
    {
        $rabiesReport->update(['status' => 'Under Review']);
        return redirect()->back()->with('success', 'Report checked and acknowledged.');
    }

    /**
     * List vaccination records.
     *
     * Module: Medical Records
     * Role: assistant_vet
     */
    public function indexVaccinations(Request $request)
    {
        $vaccinations = \App\Models\Vaccination::with(['pet', 'user'])
            ->latest()
            ->paginate(10);
        return view('dashboard.vaccinations.index', compact('vaccinations'));
    }

    /**
     * Show create vaccination form.
     */
    public function createVaccination()
    {
        $animals = \App\Models\Animal::all();
        return view('dashboard.vaccinations.create', compact('animals'));
    }

    /**
     * Store new vaccination.
     */
    public function storeVaccination(Request $request)
    {
        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'vaccine_type' => 'required|string',
            'vaccination_date' => 'required|date',
            'next_vaccination_date' => 'nullable|date',
            'batch_number' => 'nullable|string',
            'veterinarian' => 'nullable|string',
        ]);

        $validated['vaccinated_by'] = auth()->id();
        \App\Models\Vaccination::create($validated);

        return redirect()->route('disease-control.vaccinations.index')
            ->with('success', 'Vaccination recorded successfully.');
    }

    /**
     * List spay/neuter records.
     *
     * Module: Spay/Neuter Program
     * Role: assistant_vet
     */
    public function indexSpayNeuter(Request $request)
    {
        $reports = \App\Models\SpayNeuterReport::with(['barangay'])
            ->latest()
            ->paginate(10);
        return view('dashboard.spay-neuter.index', compact('reports'));
    }

    /**
     * Show create spay/neuter form.
     */
    public function createSpayNeuter()
    {
        return view('dashboard.spay-neuter.create');
    }

    /**
     * Store new spay/neuter record.
     */
    public function storeSpayNeuter(Request $request)
    {
        $validated = $request->validate([
            'species' => 'required|string',
            'breed' => 'nullable|string',
            'age' => 'nullable|integer',
            'sex' => 'required|string',
            'procedure_type' => 'required|string',
            'procedure_date' => 'required|date',
            'vet_name' => 'nullable|string',
            'barangay_id' => 'nullable|exists:barangays,barangay_id',
        ]);

        $validated['recorded_by'] = auth()->id();
        \App\Models\SpayNeuterReport::create($validated);

        return redirect()->route('disease-control.spay-neuter.index')
            ->with('success', 'Spay/Neuter record created successfully.');
    }

    // ==============================
    // RABIES BITE REPORTS MODULE (Client Submission)
    // ==============================

    /**
     * List rabies bite reports for assistant_vet.
     *
     * Module: Rabies Bite Incident Reports
     * Role: assistant_vet
     */
    public function indexRabiesReports(Request $request)
    {
        $user = Auth::user();

        $query = RabiesReport::with(['patientBarangay']);

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Get counts
        $stats = [
            'total' => RabiesReport::count(),
            'pending' => RabiesReport::where('status', 'Pending Review')->count(),
            'under_review' => RabiesReport::where('status', 'Under Review')->count(),
            'resolved' => RabiesReport::where('status', 'Resolved')->count(),
            'closed' => RabiesReport::where('status', 'Closed')->count(),
        ];

        $reports = $query->latest()->paginate(10);

        return view('dashboard.rabies-bite-reports.index', compact('user', 'reports', 'stats'));
    }

    /**
     * Show rabies bite report details.
     */
    public function showRabiesReport(RabiesReport $rabiesReport)
    {
        $rabiesReport->load(['patientBarangay', 'barangay']);
        return view('dashboard.rabies-bite-reports.show', compact('rabiesReport'));
    }

    /**
     * Accept a rabies bite report - start review.
     */
    public function acceptRabiesReport(RabiesReport $rabiesReport)
    {
        $rabiesReport->update([
            'status' => 'Under Review',
        ]);

        return redirect()->back()->with('success', 'Rabies Bite Report accepted and now under review.');
    }

    /**
     * Mark a rabies bite report as resolved.
     */
    public function resolveRabiesReport(RabiesReport $rabiesReport)
    {
        $rabiesReport->update([
            'status' => 'Resolved',
        ]);

        return redirect()->back()->with('success', 'Rabies Bite Report has been marked as resolved.');
    }

    /**
     * Decline a rabies bite report.
     */
    public function declineRabiesReport(Request $request, RabiesReport $rabiesReport)
    {
        $request->validate([
            'decline_reason' => 'required|string|max:500',
        ]);

        $rabiesReport->update([
            'status' => 'Closed',
            'notes' => ($rabiesReport->notes ? $rabiesReport->notes . '\n\n' : '') . 'Declined: ' . $request->decline_reason,
        ]);

        return redirect()->back()->with('success', 'Rabies Bite Report has been declined.');
    }

    /**
     * Show form to create Rabies Case from Rabies Report.
     *
     * Pre-fills form with data from the report.
     */
    public function createRabiesCaseFromReport(RabiesReport $rabiesReport)
    {
        $barangays = \App\Models\Barangay::pluck('barangay_name', 'barangay_id');

        // Pre-fill data from report
        $prefill = [
            'case_type' => 'suspect',
            'species' => $this->mapSpecies($rabiesReport->animal_species),
            'animal_name' => $rabiesReport->patient_name, // Use patient name as identifier
            'owner_name' => $rabiesReport->animal_owner_name,
            'incident_date' => $rabiesReport->incident_date,
            'incident_location' => $rabiesReport->patientBarangay->barangay_name ?? '',
            'barangay_id' => $rabiesReport->patient_barangay_id,
            'remarks' => $this->generateRemarksFromReport($rabiesReport),
        ];

        return view('rabies-cases.create', compact('barangays', 'prefill', 'rabiesReport'));
    }

    /**
     * Store Rabies Case created from Rabies Report.
     */
    public function storeRabiesCaseFromReport(Request $request, RabiesReport $rabiesReport)
    {
        $validated = $request->validate([
            'case_type' => 'required|string|in:positive,probable,suspect,negative',
            'species' => 'required|string|in:dog,cat,other',
            'animal_name' => 'nullable|string|max:255',
            'owner_name' => 'nullable|string|max:255',
            'owner_contact' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'barangay_id' => 'nullable|exists:barangays,barangay_id',
            'incident_date' => 'required|date',
            'incident_location' => 'nullable|string',
            'status' => 'nullable|string|in:open,closed,under_investigation',
            'findings' => 'nullable|string',
            'actions_taken' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = $validated['status'] ?? 'open';
        $validated['rabies_report_id'] = $rabiesReport->id;

        // Auto-generate case number if not provided
        if (empty($validated['case_number'])) {
            $validated['case_number'] = 'RAB-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));
        }

        $case = RabiesCase::create($validated);

        // Update the rabies report status
        $rabiesReport->update([
            'status' => 'Under Review',
            'notes' => ($rabiesReport->notes ? $rabiesReport->notes . '\n\n' : '') . 'Converted to Rabies Case: ' . $case->case_number,
        ]);

        return redirect()->route('assistant-vet.rabies-cases.show', $case)
            ->with('success', 'Rabies Case created successfully from the report!');
    }

    /**
     * Map species from RabiesReport to RabiesCase format.
     */
    private function mapSpecies(string $reportSpecies): string
    {
        return match($reportSpecies) {
            'Dog' => 'dog',
            'Cat' => 'cat',
            default => 'other',
        };
    }

    /**
     * Generate remarks from Rabies Report data.
     */
    private function generateRemarksFromReport(RabiesReport $report): string
    {
        $remarks = [];
        $remarks[] = "Created from Rabies Bite Report: {$report->report_number}";
        $remarks[] = "Nature of Incident: {$report->nature_of_incident}";
        $remarks[] = "Exposure Category: {$report->exposure_category}";
        $remarks[] = "Animal Status: {$report->animal_status}";
        $remarks[] = "Vaccination Status: {$report->animal_vaccination_status}";
        $remarks[] = "Current Condition: {$report->animal_current_condition}";
        $remarks[] = "Bite Site: {$report->bite_site}";
        $remarks[] = "Wound Management: " . (is_array($report->wound_management) ? implode(', ', $report->wound_management) : 'None');
        $remarks[] = "PEP: {$report->post_exposure_prophylaxis}";

        if ($report->patient_contact) {
            $remarks[] = "Patient Contact: {$report->patient_contact}";
        }

        return implode('\n', $remarks);
    }
}
