<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\RabiesReport;
use App\Models\Barangay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RabiesReportController extends Controller
{
    /**
     * Display the rabies bite incident report form.
     */
    public function create()
    {
        // Get all barangays for the dropdown
        $barangays = Barangay::orderBy('barangay_name')->get();

        return view('Client.rabies_bite_report_form', compact('barangays'));
    }

    /**
     * Store a newly created rabies report.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = $this->validateRequest($request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create the rabies report
        $report = $this->createReport($request);

        // Redirect to success page with report number
        return redirect()->route('rabies-bite-report.success', ['report_number' => $report->report_number]);
    }

    /**
     * Display the success page after form submission.
     */
    public function success(Request $request)
    {
        $reportNumber = $request->query('report_number', 'Unknown');

        return view('Client.rabies_bite_report_success', compact('reportNumber'));
    }

    /**
     * Validate the incoming request.
     */
    private function validateRequest(Request $request)
    {
        $rules = [
            // Section I: Source of Report
            'reporting_facility' => 'required|string',
            'facility_name' => 'nullable|string|max:200',
            'date_reported' => 'required|date',

            // Section II: Patient Information
            'patient_name' => 'required|string|min:2|max:200',
            'patient_age' => 'required|integer|min:0|max:150',
            'patient_gender' => 'required|in:Male,Female',
            'patient_barangay_id' => 'required|exists:barangays,barangay_id',
            'patient_contact' => 'required|regex:/^[0-9]{11}$/',

            // Section III: Incident Details
            'incident_date' => 'required|date|before_or_equal:today',
            'nature_of_incident' => 'required|in:Bitten,Scratched,Licked (Open Wound)',
            'bite_site' => 'required|in:Head/Neck,Upper Extremities,Trunk,Lower Extremities',
            'exposure_category' => 'required|in:Category I (Lick),Category II (Scratch),Category III (Bite / Deep)',

            // Section IV: Animal Information
            'animal_species' => 'required|in:Dog,Cat,Others',
            'animal_status' => 'required|in:Stray,Owned,Wild',
            'animal_owner_name' => 'nullable|string|max:200',
            'animal_vaccination_status' => 'required|in:Vaccinated,Unvaccinated,Unknown',
            'animal_current_condition' => 'required|in:Healthy / Alive,Dead,Missing / Escaped,Euthanized',

            // Section V: Clinical Action
            'wound_management' => 'nullable|array',
            'wound_management.*' => 'in:Washed with Soap,Antiseptic Applied,None',
            'post_exposure_prophylaxis' => 'required|in:Yes,No',

            // Additional
            'notes' => 'nullable|string|max:1000',
            'barangay_id' => 'nullable|exists:barangays,barangay_id',
        ];

        $messages = [
            'patient_contact.regex' => 'The contact number must be exactly 11 digits.',
            'incident_date.before_or_equal' => 'The incident date cannot be in the future.',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    /**
     * Create the rabies report.
     */
    private function createReport(Request $request): RabiesReport
    {
        // Generate unique report number
        $reportNumber = RabiesReport::generateReportNumber();

        // Determine which barangay to use (patient's barangay or incident barangay)
        $barangayId = $request->input('barangay_id') ?? $request->input('patient_barangay_id');

        // Prepare wound management as JSON
        $woundManagement = $request->input('wound_management', []);

        return RabiesReport::create([
            'report_number' => $reportNumber,
            'status' => 'Pending Review',
            'assigned_to_role' => 'assistant_vet',

            // Section I
            'reporting_facility' => $request->input('reporting_facility'),
            'facility_name' => $request->input('facility_name'),
            'date_reported' => $request->input('date_reported'),

            // Section II
            'patient_name' => $request->input('patient_name'),
            'patient_age' => $request->input('patient_age'),
            'patient_gender' => $request->input('patient_gender'),
            'patient_barangay_id' => $request->input('patient_barangay_id'),
            'patient_contact' => $request->input('patient_contact'),

            // Section III
            'incident_date' => $request->input('incident_date'),
            'nature_of_incident' => $request->input('nature_of_incident'),
            'bite_site' => $request->input('bite_site'),
            'exposure_category' => $request->input('exposure_category'),

            // Section IV
            'animal_species' => $request->input('animal_species'),
            'animal_status' => $request->input('animal_status'),
            'animal_owner_name' => $request->input('animal_owner_name'),
            'animal_vaccination_status' => $request->input('animal_vaccination_status'),
            'animal_current_condition' => $request->input('animal_current_condition'),

            // Section V
            'wound_management' => $woundManagement,
            'post_exposure_prophylaxis' => $request->input('post_exposure_prophylaxis'),

            // Additional
            'notes' => $request->input('notes'),
            'barangay_id' => $barangayId,
        ]);
    }
}
