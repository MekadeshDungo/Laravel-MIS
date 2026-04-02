<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Barangay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = MedicalRecord::query();

        if ($request->filled('barangay_id')) {
            $query->where('barangay_id', $request->barangay_id);
        }

        if ($request->filled('record_type')) {
            $query->where('record_type', $request->record_type);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('animal_name', 'like', '%' . $request->search . '%')
                  ->orWhere('owner_name', 'like', '%' . $request->search . '%');
            });
        }

        $records = $query->orderBy('record_date', 'desc')->paginate(15);
        $barangays = Barangay::orderBy('barangay_name')->get();

        return view('admin-asst.medical-records.index', compact('records', 'barangays'));
    }

    public function create()
    {
        $barangays = Barangay::orderBy('barangay_name')->get();
        return view('admin-asst.medical-records.create', compact('barangays'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'record_type' => 'required|in:medical,vaccination',
            'animal_name' => 'required|string|max:255',
            'species' => 'required|string|max:100',
            'breed' => 'nullable|string|max:100',
            'owner_name' => 'required|string|max:255',
            'owner_contact' => 'nullable|string|max:50',
            'record_date' => 'required|date',
            'barangay_id' => 'required|exists:barangays,barangay_id',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'vaccine_name' => 'nullable|string|max:255',
            'vaccination_date' => 'nullable|date',
            'next_vaccination_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $validated['created_by'] = Auth::id();

        MedicalRecord::create($validated);

        return redirect()->route('medical-records.index')
            ->with('success', 'Medical/Vaccination record created successfully.');
    }

    public function show(MedicalRecord $medicalRecord)
    {
        return view('admin-asst.medical-records.show', compact('medicalRecord'));
    }

    public function edit(MedicalRecord $medicalRecord)
    {
        $barangays = Barangay::orderBy('barangay_name')->get();
        return view('admin-asst.medical-records.edit', compact('medicalRecord', 'barangays'));
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $validated = $request->validate([
            'record_type' => 'required|in:medical,vaccination',
            'animal_name' => 'required|string|max:255',
            'species' => 'required|string|max:100',
            'breed' => 'nullable|string|max:100',
            'owner_name' => 'required|string|max:255',
            'owner_contact' => 'nullable|string|max:50',
            'record_date' => 'required|date',
            'barangay_id' => 'required|exists:barangays,barangay_id',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'vaccine_name' => 'nullable|string|max:255',
            'vaccination_date' => 'nullable|date',
            'next_vaccination_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $medicalRecord->update($validated);

        return redirect()->route('medical-records.show', $medicalRecord)
            ->with('success', 'Record updated successfully.');
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        $medicalRecord->delete();

        return redirect()->route('medical-records.index')
            ->with('success', 'Record deleted successfully.');
    }
}