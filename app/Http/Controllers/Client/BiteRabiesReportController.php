<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BiteRabiesReport;
use App\Models\Barangay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BiteRabiesReportController extends Controller
{
    public function create()
    {
        $barangays = Barangay::orderBy('barangay_name')->get();

        return view('Client.bite_rabies_report_form', compact('barangays'));
    }

    public function store(Request $request)
    {
        $validator = $this->validateRequest($request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $report = $this->createReport($request);

        \App\Services\NotificationService::biteReportCreated($report->id);

        return redirect()->route('bite-rabies-report.success', ['report_number' => $report->report_number]);
    }

    public function success(Request $request)
    {
        $reportNumber = $request->query('report_number', 'Unknown');

        return view('Client.bite_rabies_report_success', compact('reportNumber'));
    }

    private function validateRequest(Request $request)
    {
        $rules = [
            'reporting_facility' => 'required|string',
            'facility_name' => 'nullable|string|max:200',
            'date_reported' => 'required|date',
            'patient_name' => 'required|string|min:2|max:200',
            'patient_age' => 'required|integer|min:0|max:150',
            'patient_gender' => 'required|in:Male,Female',
            'patient_barangay_id' => 'required|exists:barangays,barangay_id',
            'patient_contact' => 'required|regex:/^[0-9]{11}$/',
            'incident_date' => 'required|date|before_or_equal:today',
            'nature_of_incident' => 'required|in:Bitten,Scratched,Licked (Open Wound)',
            'bite_site' => 'required|in:Head/Neck,Upper Extremities,Trunk,Lower Extremities',
            'exposure_category' => 'required|in:Category I (Lick),Category II (Scratch),Category III (Bite / Deep)',
            'animal_species' => 'required|in:Dog,Cat,Others',
            'animal_status' => 'required|in:Stray,Owned,Wild',
            'animal_owner_name' => 'nullable|string|max:200',
            'animal_vaccination_status' => 'required|in:Vaccinated,Unvaccinated,Unknown',
            'animal_current_condition' => 'required|in:Healthy / Alive,Dead,Missing / Escaped,Euthanized',
            'wound_management' => 'nullable|array',
            'wound_management.*' => 'in:Washed with Soap,Antiseptic Applied,None',
            'post_exposure_prophylaxis' => 'required|in:Yes,No',
            'notes' => 'nullable|string|max:1000',
            'barangay_id' => 'required|exists:barangays,barangay_id',
        ];

        $messages = [
            'patient_contact.regex' => 'The contact number must be exactly 11 digits.',
            'incident_date.before_or_equal' => 'The incident date cannot be in the future.',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    private function createReport(Request $request): BiteRabiesReport
    {
        $reportNumber = BiteRabiesReport::generateReportNumber();
        
        // Use patient_barangay_id for barangay_id (incident location)
        $barangayId = $request->input('barangay_id') ?: $request->input('patient_barangay_id');
        
        $woundManagement = $request->input('wound_management', []);

        // Map client field names to standard field names
        $animalTypeMap = [
            'Dog' => 'dog',
            'Cat' => 'cat',
            'Others' => 'others',
        ];

        $animalStatusMap = [
            'Stray' => 'stray',
            'Owned' => 'owned',
            'Wild' => 'wild',
        ];

        return BiteRabiesReport::create([
            'report_number' => $reportNumber,
            'report_source' => 'client_submission',
            'status' => 'Under Investigation', // Auto-approve to show on map
            'assigned_to_role' => 'assistant_vet',
            'reporting_facility' => $request->input('reporting_facility'),
            'facility_name' => $request->input('facility_name'),
            'date_reported' => $request->input('date_reported'),
            'patient_name' => $request->input('patient_name'),
            'age' => $request->input('patient_age'),
            'gender' => $request->input('patient_gender'),
            'patient_barangay' => $request->input('patient_barangay_id'), // Store name as patient_barangay
            'patient_contact' => $request->input('patient_contact'),
            'incident_date' => $request->input('incident_date'),
            'exposure_type' => strtolower($request->input('nature_of_incident')),
            'bite_site' => $request->input('bite_site'),
            'category' => $request->input('exposure_category'),
            'animal_type' => $animalTypeMap[$request->input('animal_species')] ?? 'others',
            'animal_status' => $animalStatusMap[$request->input('animal_status')] ?? 'stray',
            'animal_owner_name' => $request->input('animal_owner_name'),
            'vaccination_status' => strtolower($request->input('animal_vaccination_status')),
            'wound_management' => $woundManagement,
            'post_exposure_prophylaxis' => $request->input('post_exposure_prophylaxis'),
            'notes' => $request->input('notes'),
            'barangay_id' => $barangayId, // Now properly set from patient_barangay_id if empty
        ]);
    }
}
