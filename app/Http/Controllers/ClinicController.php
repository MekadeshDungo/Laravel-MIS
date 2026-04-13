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
        $caseNumber = 'BITE-' . date('Y') . '-' . str_pad(BiteRabiesReport::count() + 1, 5, '0', STR_PAD_LEFT);
        return view('reports.animal_bite_form', compact('barangays', 'caseNumber'));
    }

    /**
     * Store bite report.
     */
    public function storeBiteReport(Request $request)
    {
        $validated = $request->validate([
            'victim_last_name' => 'required|string|max:255',
            'victim_first_name' => 'required|string|max:255',
            'victim_middle_name' => 'nullable|string|max:255',
            'victim_suffix' => 'nullable|string|max:50',
            'victim_case_id' => 'nullable|string|max:50',
            'victim_age' => 'required|integer|min:0|max:150',
            'victim_sex' => 'required|in:male,female',
            'victim_contact' => 'nullable|string|max:11',
            'victim_address' => 'required|string|max:500',
            'victim_barangay' => 'nullable|string|max:255',
            'incident_barangay' => 'required|string|max:255',
            'exact_location' => 'nullable|string|max:500',
            'incident_date' => 'required|date',
            'animal_type' => 'required|in:dog,cat,others',
            'ownership_status' => 'required|in:owned,stray,wild',
            'vaccination_status' => 'nullable|in:vaccinated,unvaccinated,unknown',
            'bite_category' => 'required|in:category_i,category_ii,category_iii',
            'body_part' => 'required|string|max:255',
            'location_description' => 'nullable|string|max:500',
            'pep' => 'nullable|in:yes,no',
            'wound_management' => 'nullable|array',
            'hospital_referred' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        // Find barangay_id from incident_barangay name
        $barangay = \App\Models\Barangay::where('barangay_name', $validated['incident_barangay'])->first();
        $barangayId = $barangay ? $barangay->barangay_id : null;

        $patientName = trim($validated['victim_first_name'] . ' ' . 
            ($validated['victim_middle_name'] ? $validated['victim_middle_name'] . ' ' : '') . 
            $validated['victim_last_name']);

        $reportNumber = $validated['victim_case_id'] 
            ? $validated['victim_case_id'] 
            : ($request->input('case_number') ?? BiteRabiesReport::generateReportNumber());
        
        $report = BiteRabiesReport::create([
            'report_number' => $reportNumber,
            'status' => 'Under Investigation', // Auto-approve to show on map
            'date_reported' => now()->toDateString(),
            'reporting_facility' => Auth::user()->name,
            'reported_by' => Auth::id(),
            'patient_name' => $patientName,
            'patient_first_name' => $validated['victim_first_name'],
            'patient_middle_name' => $validated['victim_middle_name'] ?? null,
            'patient_suffix' => $validated['victim_suffix'] ?? null,
            'age' => $validated['victim_age'],
            'gender' => ucfirst($validated['victim_sex']),
            'patient_contact' => $validated['victim_contact'] ?? '',
            'patient_address' => $validated['victim_address'],
            'barangay_id' => $barangayId,
            'incident_date' => \Carbon\Carbon::parse($validated['incident_date'])->toDateString(),
            'incident_barangay' => $validated['incident_barangay'] ?? null,
            'exact_location' => $validated['exact_location'] ?? null,
            'exposure_type' => 'bite',
            'bite_site' => $validated['body_part'],
            'category' => strtoupper(str_replace('category_', '', $validated['bite_category'])),
            'animal_type' => $validated['animal_type'],
            'animal_status' => $validated['ownership_status'],
            'vaccination_status' => $validated['vaccination_status'] ?? 'unknown',
            'wound_management' => $validated['wound_management'] ?? [],
            'post_exposure_prophylaxis' => $validated['pep'] ?? 'No',
            'notes' => $validated['remarks'] ?? '',
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
