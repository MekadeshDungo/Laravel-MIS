<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RabiesVaccinationReport;
use App\Models\BiteRabiesReport;
use App\Models\Barangay;

class ClinicController extends Controller
{
    /**
     * Show clinic dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $biteReports = BiteRabiesReport::where('reported_by', $user->id)->latest()->take(5)->get();
        $rabiesReports = RabiesVaccinationReport::where('user_id', $user->id)->latest()->take(5)->get();
        
        $stats = [
            'total_bite' => BiteRabiesReport::where('reported_by', $user->id)->count(),
            'total_rabies' => RabiesVaccinationReport::where('user_id', $user->id)->count(),
        ];
        
        return view('dashboard.clinic', compact('biteReports', 'rabiesReports', 'stats'));
    }

    /**
     * Show data entry form.
     */
    public function showDataEntry()
    {
        return view('dashboard.clinic-data-entry');
    }

    // ==============================
    // BITE REPORTS
    // ==============================

    /**
     * List clinic's bite reports.
     */
    public function indexBiteReports()
    {
        $reports = BiteRabiesReport::where('reported_by', Auth::id())
            ->latest()
            ->paginate(10);
        return view('dashboard.clinic-bite-reports', compact('reports'));
    }

    /**
     * Show bite report create form.
     */
    public function createBiteReport()
    {
        $barangays = Barangay::orderBy('barangay_name')->get();
        return view('dashboard.clinic-bite-report-create', compact('barangays'));
    }

    /**
     * Store bite report.
     */
    public function storeBiteReport(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_age' => 'required|integer|min:0|max:150',
            'patient_gender' => 'required|in:Male,Female,Other',
            'patient_barangay_id' => 'required|exists:barangays,barangay_id',
            'patient_contact' => 'required|string|max:255',
            'patient_full_address' => 'nullable|string|max:500',
            'incident_date' => 'required|date',
            'nature_of_incident' => 'required|in:Bitten,Scratched,Licked (Open Wound)',
            'bite_site' => 'required|in:Head/Neck,Upper Extremities,Trunk,Lower Extremities',
            'exposure_category' => 'required|in:Category I (Lick),Category II (Scratch),Category III (Bite / Deep)',
            'animal_species' => 'required|in:Dog,Cat,Others',
            'animal_status' => 'required|in:Stray,Owned,Wild',
            'animal_owner_name' => 'nullable|string|max:255',
            'animal_vaccination_status' => 'nullable|in:Vaccinated,Unvaccinated,Unknown',
            'animal_current_condition' => 'nullable|in:Healthy / Alive,Dead,Missing / Escaped,Euthanized',
            'wound_management' => 'nullable|array',
            'post_exposure_prophylaxis' => 'nullable|in:Yes,No',
            'notes' => 'nullable|string',
        ]);

        $report = BiteRabiesReport::create([
            'report_number' => BiteRabiesReport::generateReportNumber(),
            'report_source' => 'clinic',
            'status' => 'Under Review', // Auto-approved for clinics
            'reporting_facility' => 'Registered Veterinary Clinics',
            'facility_name' => Auth::user()->name,
            'date_reported' => now()->toDateString(),
            'reported_by' => Auth::id(),
            ...$validated,
        ]);

        return redirect()->route('clinic.bite-reports.index')
            ->with('success', 'Bite report submitted successfully!');
    }

    /**
     * Show bite report detail.
     */
    public function showBiteReport(BiteRabiesReport $report)
    {
        $this->authorizeBiteReport($report);
        return view('dashboard.clinic-bite-report-view', compact('report'));
    }

    private function authorizeBiteReport($report)
    {
        if ($report->reported_by !== Auth::id() && !Auth::user()->hasRole('super_admin')) {
            abort(403);
        }
    }

    // ==============================
    // RABIES VACCINATION REPORTS
    // ==============================

    /**
     * Show rabies vaccination report form.
     */
    public function createVaccinationReport()
    {
        return view('reports.rabies_vaccination_form');
    }

    /**
     * Store rabies vaccination report.
     */
    public function storeVaccinationReport(Request $request)
    {
        $validated = $request->validate([
            'clinic_name' => 'required|string|max:255',
            'patient_name' => 'required|string|max:255',
            'patient_contact' => 'required|string|max:255',
            'patient_address' => 'required|string',
            'pet_name' => 'nullable|string|max:255',
            'pet_species' => 'required|string|max:255',
            'pet_breed' => 'nullable|string|max:255',
            'pet_age' => 'nullable|integer|min:0|max:30',
            'pet_gender' => 'nullable|string|in:male,female',
            'pet_color' => 'nullable|string|max:255',
            'vaccine_brand' => 'required|string|max:255',
            'vaccine_batch_number' => 'nullable|string|max:255',
            'vaccination_date' => 'required|date',
            'vaccination_time' => 'required',
            'vaccination_type' => 'required|string|in:primary,booster',
        ]);

        $report = RabiesVaccinationReport::create([
            'user_id' => Auth::id(),
            ...$validated,
        ]);

        return redirect()->route('clinic.vaccination-reports.index')
            ->with('success', 'Rabies vaccination report submitted successfully!');
    }

    /**
     * List rabies vaccination reports.
     */
    public function indexVaccinationReports()
    {
        $reports = RabiesVaccinationReport::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        return view('reports.rabies_vaccination_index', compact('reports'));
    }

    /**
     * Show rabies vaccination report detail.
     */
    public function showVaccinationReport(RabiesVaccinationReport $report)
    {
        if ($report->reported_by !== Auth::id() && !Auth::user()->hasRole('super_admin')) {
            abort(403);
        }
        return view('reports.rabies_vaccination_show', compact('report'));
    }
}
