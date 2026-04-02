<?php

namespace App\Http\Controllers\AdminAsst;

use App\Http\Controllers\Controller;
use App\Models\CrueltyReport;
use App\Models\Barangay;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CrueltyReportController extends Controller
{
    // Public store method for anonymous users
    public function publicStore(Request $request)
    {
        $validated = $request->validate([
            'reporter_first_name' => 'required|string|max:255',
            'reporter_last_name' => 'required|string|max:255',
            'reporter_email' => 'required|email|max:255',
            'reporter_phone' => 'required|string|max:20',
            'accused_first_name' => 'required|string|max:255',
            'accused_last_name' => 'required|string|max:255',
            'accused_address' => 'required|string|max:500',
            'testify_in_court' => 'required|in:yes,no',
            'attend_hearings' => 'required|in:yes,no',
            'complaint_details' => 'required|string',
            'location' => 'required|string|max:255',
            'barangay_id' => 'required|exists:barangays,barangay_id',
            'incident_date' => 'required|date',
            'animal_type' => 'required|string|max:100',
            'animal_description' => 'nullable|string',
            'animal_count' => 'required|integer|min:1',
            'violation_type' => 'required|string',
            // File upload validation
            'animal_photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'witness_affidavit.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        // Combine reporter first and last name
        $reporterName = $validated['reporter_first_name'] . ' ' . $validated['reporter_last_name'];

        // Combine accused first and last name
        $accusedName = $validated['accused_first_name'] . ' ' . $validated['accused_last_name'];

        // Prepare data for storage
        $data = [
            'report_number' => 'CR-' . date('Ymd') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT),
            'reporter_name' => $reporterName,
            'reporter_contact' => $validated['reporter_phone'],
            'reporter_email' => $validated['reporter_email'],
            'accused_name' => $accusedName,
            'accused_address' => $validated['accused_address'],
            'location' => $validated['location'],
            'barangay_id' => $validated['barangay_id'],
            'incident_date' => $validated['incident_date'],
            'animal_type' => $validated['animal_type'],
            'animal_description' => $validated['animal_description'] ?? null,
            'animal_count' => $validated['animal_count'],
            'violation_type' => $validated['violation_type'],
            'description' => $validated['complaint_details'],
            'testify_in_court' => $validated['testify_in_court'],
            'attend_hearings' => $validated['attend_hearings'],
            'status' => 'pending',
            'created_by' => null, // No user logged in
        ];

        // Handle file uploads if any
        if ($request->hasFile('animal_photos')) {
            $photos = [];
            foreach ($request->file('animal_photos') as $photo) {
                $path = $photo->store('cruelty-reports/photos', 'public');
                $photos[] = $path;
            }
            $data['animal_photos'] = json_encode($photos);
        }

        if ($request->hasFile('witness_affidavit')) {
            $affidavits = [];
            foreach ($request->file('witness_affidavit') as $affidavit) {
                $path = $affidavit->store('cruelty-reports/affidavits', 'public');
                $affidavits[] = $path;
            }
            $data['witness_affidavit'] = json_encode($affidavits);
        }

        CrueltyReport::create($data);

        return redirect()->route('cruelty-report.thank-you')
            ->with('success', 'Your cruelty report has been submitted successfully. Reference: ' . $data['report_number']);
    }

    public function index(Request $request)
    {
        $query = CrueltyReport::query();

        if ($request->filled('barangay_id')) {
            $query->where('barangay_id', $request->barangay_id);
        }

        if ($request->filled('violation_type')) {
            $query->where('violation_type', $request->violation_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('report_number', 'like', '%' . $request->search . '%')
                  ->orWhere('reporter_name', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        $reports = $query->orderBy('incident_date', 'desc')->paginate(15);
        $barangays = Barangay::orderBy('barangay_name')->get();

        return view('admin-asst.cruelty-reports.index', compact('reports', 'barangays'));
    }

    public function create()
    {
        $barangays = Barangay::orderBy('barangay_name')->get();
        return view('admin-asst.cruelty-reports.create', compact('barangays'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reporter_name' => 'required|string|max:255',
            'reporter_contact' => 'nullable|string|max:50',
            'location' => 'required|string|max:255',
            'barangay_id' => 'required|exists:barangays,barangay_id',
            'incident_date' => 'required|date',
            'animal_type' => 'required|string|max:100',
            'animal_description' => 'nullable|string',
            'animal_count' => 'required|integer|min:1',
            'violation_type' => 'required|string',
            'description' => 'required|string',
        ]);

        $validated['report_number'] = 'CR-' . date('Ymd') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
        $validated['created_by'] = Auth::id();
        $validated['status'] = 'pending';

        CrueltyReport::create($validated);

        return redirect()->route('admin-asst.cruelty-reports.index')
            ->with('success', 'Cruelty report created successfully.');
    }

    public function show(CrueltyReport $crueltyReport)
    {
        return view('admin-asst.cruelty-reports.show', compact('crueltyReport'));
    }

    public function edit(CrueltyReport $crueltyReport)
    {
        $barangays = Barangay::orderBy('barangay_name')->get();
        return view('admin-asst.cruelty-reports.edit', compact('crueltyReport', 'barangays'));
    }

    public function update(Request $request, CrueltyReport $crueltyReport)
    {
        $validated = $request->validate([
            'reporter_name' => 'required|string|max:255',
            'reporter_contact' => 'nullable|string|max:50',
            'location' => 'required|string|max:255',
            'barangay_id' => 'required|exists:barangays,barangay_id',
            'incident_date' => 'required|date',
            'animal_type' => 'required|string|max:100',
            'animal_description' => 'nullable|string',
            'animal_count' => 'required|integer|min:1',
            'violation_type' => 'required|string',
            'description' => 'required|string',
            'investigation_date' => 'nullable|date',
            'investigator_id' => 'nullable|exists:users,id',
            'findings' => 'nullable|string',
            'action_taken' => 'nullable|string',
            'status' => 'nullable|string',
            'outcome' => 'nullable|string',
        ]);

        $crueltyReport->update($validated);

        return redirect()->route('admin-asst.cruelty-reports.show', $crueltyReport)
            ->with('success', 'Cruelty report updated successfully.');
    }

    public function destroy(CrueltyReport $crueltyReport)
    {
        $crueltyReport->delete();

        return redirect()->route('admin-asst.cruelty-reports.index')
            ->with('success', 'Cruelty report deleted successfully.');
    }
}
