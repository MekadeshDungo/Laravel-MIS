<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BiteRabiesReport;
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

        // Unified Bite & Rabies Report stats
        $reportStats = [
            'total' => BiteRabiesReport::count(),
            'pending' => BiteRabiesReport::where('status', 'Pending Review')->count(),
            'under_review' => BiteRabiesReport::where('status', 'Under Review')->count(),
            'resolved' => BiteRabiesReport::where('status', 'Resolved')->count(),
            'closed' => BiteRabiesReport::where('status', 'Closed')->count(),
        ];

        // Combined stats
        $stats = [
            'total_rabies_cases' => BiteRabiesReport::count(),
            'open_cases' => BiteRabiesReport::where('status', 'open')->count(),
            'total_reports' => $reportStats['total'],
            'report_stats' => $reportStats,
        ];

        // Get recent cases with relationships
        $recentCases = BiteRabiesReport::with(['barangay'])
            ->latest()
            ->take(5)
            ->get();

        // Get recent reports
        $recentReports = BiteRabiesReport::latest()->take(5)->get();

        return view('dashboard.assistant-veterinary', compact('user', 'stats', 'recentCases', 'recentReports'));
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
        $query = BiteRabiesReport::with(['barangay', 'user']);

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

        // Unified stats from BiteRabiesReport
        $stats = [
            'total' => BiteRabiesReport::count(),
            'pending' => BiteRabiesReport::where('status', 'Pending Review')->count(),
            'under_review' => BiteRabiesReport::where('status', 'Under Review')->count(),
            'resolved' => BiteRabiesReport::where('status', 'Resolved')->count(),
            'closed' => BiteRabiesReport::where('status', 'Closed')->count(),
        ];

        $query = BiteRabiesReport::with(['patientBarangay']);

        // Apply quick filter
        if ($request->has('quick_filter') && $request->quick_filter) {
            $today = Carbon::now()->startOfDay();
            switch ($request->quick_filter) {
                case 'today':
                    $query->whereDate('created_at', $today);
                    break;
                case 'week':
                    $query->where('created_at', '>=', Carbon::now()->startOfWeek());
                    break;
                case 'month':
                    $query->where('created_at', '>=', Carbon::now()->startOfMonth());
                    break;
            }
        }

        // Apply status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Date filters
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $reports = $query->latest()->paginate(15);

        return view('dashboard.bite-reports', compact('user', 'reports', 'stats'));
    }

    /**
     * Show rabies case details.
     */
    public function showCase(BiteRabiesReport $case)
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
    public function markComplete(BiteRabiesReport $case)
    {
        $case->update(['status' => 'closed']);
        return redirect()->back()->with('success', 'Case marked as complete.');
    }

    /**
     * Show bite report details.
     */
    public function showBiteReport(BiteRabiesReport $report)
    {
        $report->load(['patientBarangay', 'barangay', 'user']);
        return view('dashboard.bite-reports.show', compact('report'));
    }

    /**
     * Mark bite report as complete.
     *
     * Module: Clinical Actions
     * Role: assistant_vet
     */
    public function markBiteComplete(BiteRabiesReport $report)
    {
        $report->update(['status' => 'Under Review']);
        return redirect()->back()->with('success', 'Report checked and acknowledged.');
    }

    /**
     * Check/Acknowledge rabies report.
     *
     * Module: Clinical Actions
     * Role: assistant_vet
     */
    public function checkRabiesReport(BiteRabiesReport $rabiesReport)
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
        $user = Auth::user();
        $reports = \App\Models\RabiesVaccinationReport::latest()->paginate(10);
        return view('dashboard.vaccination-reports', compact('user', 'reports'));
    }

    /**
     * Show create vaccination form.
     */
    public function createVaccination()
    {
        return redirect()->route('assistant-vet.vaccinations.index')
            ->with('info', 'Vaccination creation is available through the Clinic portal.');
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

        return redirect()->route('assistant-vet.vaccinations.index')
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
        
        $totalReports = \App\Models\SpayNeuterReport::count();
        $completed = \App\Models\SpayNeuterReport::where('status', 'completed')->count();
        $scheduled = \App\Models\SpayNeuterReport::where('status', 'scheduled')->count();
        
        return view('dashboard.spay-neuter', compact('reports', 'totalReports', 'completed', 'scheduled'));
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

        $query = BiteRabiesReport::with(['patientBarangay']);

        // Filter by source (report_source)
        if ($request->has('source') && $request->source) {
            $query->where('report_source', $request->source);
        }

        // Get counts
        $stats = [
            'total' => BiteRabiesReport::count(),
            'pending' => BiteRabiesReport::where('status', 'Pending Review')->count(),
            'under_review' => BiteRabiesReport::where('status', 'Under Review')->count(),
            'resolved' => BiteRabiesReport::where('status', 'Resolved')->count(),
            'closed' => BiteRabiesReport::where('status', 'Closed')->count(),
        ];

        $reports = $query->latest()->paginate(10);

        return view('dashboard.bite-rabies-reports.index', compact('user', 'reports', 'stats'));
    }

    /**
     * Show rabies bite report details.
     */
    public function showRabiesReport(BiteRabiesReport $rabiesReport)
    {
        $rabiesReport->load(['patientBarangay', 'barangay']);
        return view('dashboard.bite-rabies-reports.show', compact('rabiesReport'));
    }

    /**
     * Accept a rabies bite report - start review.
     */
    public function acceptRabiesReport(BiteRabiesReport $rabiesReport)
    {
        $rabiesReport->update([
            'status' => 'Under Review',
        ]);

        return redirect()->back()->with('success', 'Report accepted and now under review.');
    }

    /**
     * Mark a rabies bite report as resolved.
     */
    public function resolveRabiesReport(BiteRabiesReport $rabiesReport)
    {
        $rabiesReport->update([
            'status' => 'Resolved',
        ]);

        return redirect()->back()->with('success', 'Report has been marked as resolved.');
    }

    /**
     * Decline a rabies bite report.
     */
    public function declineRabiesReport(Request $request, BiteRabiesReport $rabiesReport)
    {
        $request->validate([
            'decline_reason' => 'required|string|max:500',
        ]);

        $rabiesReport->update([
            'status' => 'Closed',
            'notes' => ($rabiesReport->notes ? $rabiesReport->notes . "\n\n" : '') . 'Declined: ' . $request->decline_reason,
        ]);

        return redirect()->back()->with('success', 'Report has been declined.');
    }

    /**
     * Show form to create Rabies Case from Rabies Report.
     *
     * Pre-fills form with data from the report.
     */
    public function createBiteRabiesReportFromReport(BiteRabiesReport $rabiesReport)
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
     * Store Rabies Case created from Bite & Rabies Report.
     */
    public function storeBiteRabiesReportFromReport(Request $request, BiteRabiesReport $rabiesReport)
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

        $case = BiteRabiesReport::create($validated);

        // Update the report status
        $rabiesReport->update([
            'status' => 'Under Review',
            'notes' => ($rabiesReport->notes ? $rabiesReport->notes . "\n\n" : '') . 'Converted to Rabies Case: ' . $case->case_number,
        ]);

        return redirect()->route('assistant-vet.rabies-cases.show', $case)
            ->with('success', 'Rabies Case created successfully from the report!');
    }

    /**
     * Map species from RabiesReport to BiteRabiesReport format.
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
    private function generateRemarksFromReport(BiteRabiesReport $report): string
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
