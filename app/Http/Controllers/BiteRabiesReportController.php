<?php

namespace App\Http\Controllers;

use App\Models\BiteRabiesReport;
use App\Models\Barangay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BiteRabiesReportController extends Controller
{
    public function index(Request $request)
    {
        $query = BiteRabiesReport::with(['barangay', 'reportedBy']);

        if ($request->filled('barangay_id')) {
            $query->where('barangay_id', $request->barangay_id);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('animal_type')) {
            $query->where('animal_type', $request->animal_type);
        }

        if ($request->filled('search')) {
            $query->where('report_number', 'like', '%' . $request->search . '%')
                ->orWhere('patient_name', 'like', '%' . $request->search . '%');
        }

        $reports = $query->orderBy('created_at', 'desc')->paginate(15);
        $barangays = Barangay::orderBy('barangay_name')->get();

        return view('admin-staff.bite-rabies-reports.index', compact('reports', 'barangays'));
    }

    public function show(BiteRabiesReport $biteRabiesReport)
    {
        $biteRabiesReport->load(['barangay', 'reportedBy']);

        return view('admin-staff.bite-rabies-reports.show', compact('biteRabiesReport'));
    }

    public function create()
    {
        $barangays = Barangay::orderBy('barangay_name')->get();

        return view('admin-staff.bite-rabies-reports.create', compact('barangays'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_name' => 'required|string|max:200',
            'age' => 'required|integer|min:0|max:150',
            'gender' => 'required|in:Male,Female',
            'patient_address' => 'nullable|string|max:500',
            'patient_contact' => 'nullable|string|max:11',
            'barangay_id' => 'nullable|exists:barangays,barangay_id',
            'incident_date' => 'required|date',
            'exposure_type' => 'required|in:bite,scratch,lick',
            'bite_site' => 'nullable|string|max:100',
            'category' => 'required|in:I,II,III',
            'animal_type' => 'required|in:dog,cat,others',
            'animal_status' => 'required|in:stray,owned,wild',
            'vaccination_status' => 'required|in:vaccinated,unvaccinated,unknown',
            'animal_owner_name' => 'nullable|string|max:200',
            'animal_owner_contact' => 'nullable|string|max:11',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $reportNumber = BiteRabiesReport::generateReportNumber();

        $report = BiteRabiesReport::create(array_merge(
            $request->validated(),
            [
                'report_number' => $reportNumber,
                'reported_by' => auth()->id(),
            ]
        ));

        \App\Services\NotificationService::biteReportCreated($report->id);

        return redirect()->route('city-vet.rabies-bite-reports.index')
            ->with('success', 'Bite/Rabies report created successfully.');
    }

    public function edit(BiteRabiesReport $biteRabiesReport)
    {
        $biteRabiesReport->load('barangay');
        $barangays = Barangay::orderBy('barangay_name')->get();

        return view('admin-staff.bite-rabies-reports.edit', compact('biteRabiesReport', 'barangays'));
    }

    public function update(Request $request, BiteRabiesReport $biteRabiesReport)
    {
        $validator = Validator::make($request->all(), [
            'patient_name' => 'required|string|max:200',
            'age' => 'required|integer|min:0|max:150',
            'gender' => 'required|in:Male,Female',
            'patient_address' => 'nullable|string|max:500',
            'patient_contact' => 'nullable|string|max:11',
            'barangay_id' => 'nullable|exists:barangays,barangay_id',
            'incident_date' => 'required|date',
            'exposure_type' => 'required|in:bite,scratch,lick',
            'bite_site' => 'nullable|string|max:100',
            'category' => 'required|in:I,II,III',
            'animal_type' => 'required|in:dog,cat,others',
            'animal_status' => 'required|in:stray,owned,wild',
            'vaccination_status' => 'required|in:vaccinated,unvaccinated,unknown',
            'animal_owner_name' => 'nullable|string|max:200',
            'animal_owner_contact' => 'nullable|string|max:11',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $biteRabiesReport->update($request->validated());

        return redirect()->route('city-vet.rabies-bite-reports.show', $biteRabiesReport)
            ->with('success', 'Report updated successfully.');
    }

    public function destroy(BiteRabiesReport $biteRabiesReport)
    {
        $biteRabiesReport->delete();

        return redirect()->route('city-vet.rabies-bite-reports.index')
            ->with('success', 'Report deleted successfully.');
    }

    public function publicIndex()
    {
        $reports = BiteRabiesReport::with('barangay')
            ->orderBy('incident_date', 'desc')
            ->paginate(15);

        return view('public.bite-rabies-reports.index', compact('reports'));
    }

    public function publicShow(BiteRabiesReport $biteRabiesReport)
    {
        $biteRabiesReport->load('barangay');

        return view('public.bite-rabies-reports.show', compact('biteRabiesReport'));
    }
}