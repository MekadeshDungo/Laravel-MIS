<?php

namespace App\Http\Controllers;

use App\Models\ImpoundRecord;
use App\Models\ImpoundStatusHistory;
use App\Models\Barangay;
use App\Models\AdoptionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ImpoundController extends Controller
{
    public function index(Request $request)
    {
        $query = ImpoundRecord::with(['barangay', 'recordedBy', 'approvedBy']);

        if ($request->filled('current_disposition')) {
            $query->where('current_disposition', $request->current_disposition);
        }

        if ($request->filled('barangay_id')) {
            $query->where('barangay_id', $request->barangay_id);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('animal_tag_code', 'like', '%' . $request->search . '%')
                    ->orWhere('animal_name', 'like', '%' . $request->search . '%')
                    ->orWhere('intake_location', 'like', '%' . $request->search . '%');
            });
        }

        $impounds = $query->orderBy('intake_date', 'desc')->paginate(15);
        $barangays = Barangay::orderBy('barangay_name')->get();

        return view('admin-staff.impounds.index', compact('impounds', 'barangays'));
    }

    public function show(ImpoundRecord $impound)
    {
        $impound->load(['barangay', 'recordedBy', 'approvedBy', 'strayReport', 'statusHistory', 'adoptionRequests']);

        return view('admin-staff.impounds.show', compact('impound'));
    }

    public function create()
    {
        $barangays = Barangay::orderBy('barangay_name')->get();

        return view('admin-staff.impounds.create', compact('barangays'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'animal_type' => 'nullable|string|max:50',
            'animal_name' => 'nullable|string|max:100',
            'species' => 'nullable|string|max:50',
            'breed' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:50',
            'gender' => 'nullable|in:male,female,unknown',
            'age' => 'nullable|integer|min:0',
            'owner_name' => 'nullable|string|max:200',
            'owner_contact' => 'nullable|string|max:11',
            'animal_tag_code' => 'nullable|string|max:50',
            'intake_condition' => 'nullable|string|max:100',
            'intake_location' => 'required|string|max:200',
            'intake_date' => 'required|date',
            'barangay_id' => 'nullable|exists:barangays,barangay_id',
            'current_disposition' => 'nullable|in:impounded,claimed,adopted,transferred,euthanized',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $impound = ImpoundRecord::create(array_merge(
            $request->validated(),
            [
                'current_disposition' => $request->current_disposition ?? 'impounded',
                'recorded_by' => auth()->id(),
            ]
        ));

        ImpoundStatusHistory::create([
            'impound_id' => $impound->impound_id,
            'status' => 'impounded',
            'remarks' => 'Initial impound record created',
            'updated_by_user_id' => auth()->id(),
        ]);

        return redirect()->route('impounds.show', $impound)
            ->with('success', 'Impound record created successfully.');
    }

    public function edit(ImpoundRecord $impound)
    {
        $impound->load('barangay');
        $barangays = Barangay::orderBy('barangay_name')->get();

        return view('admin-staff.impounds.edit', compact('impound', 'barangays'));
    }

    public function update(Request $request, ImpoundRecord $impound)
    {
        $validator = Validator::make($request->all(), [
            'animal_type' => 'nullable|string|max:50',
            'animal_name' => 'nullable|string|max:100',
            'species' => 'nullable|string|max:50',
            'breed' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:50',
            'gender' => 'nullable|in:male,female,unknown',
            'age' => 'nullable|integer|min:0',
            'owner_name' => 'nullable|string|max:200',
            'owner_contact' => 'nullable|string|max:11',
            'animal_tag_code' => 'nullable|string|max:50',
            'intake_condition' => 'nullable|string|max:100',
            'intake_location' => 'required|string|max:200',
            'intake_date' => 'required|date',
            'barangay_id' => 'nullable|exists:barangays,barangay_id',
            'current_disposition' => 'nullable|in:impounded,claimed,adopted,transferred,euthanized',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $oldDisposition = $impound->current_disposition;
        $newDisposition = $request->current_disposition ?? $oldDisposition;

        $impound->update($request->validated());

        if ($oldDisposition !== $newDisposition) {
            ImpoundStatusHistory::create([
                'impound_id' => $impound->impound_id,
                'status' => $newDisposition,
                'remarks' => 'Status changed from ' . $oldDisposition . ' to ' . $newDisposition,
                'updated_by_user_id' => auth()->id(),
            ]);
        }

        return redirect()->route('impounds.show', $impound)
            ->with('success', 'Impound record updated successfully.');
    }

    public function updateDisposition(Request $request, ImpoundRecord $impound)
    {
        $validator = Validator::make($request->all(), [
            'current_disposition' => 'required|in:impounded,claimed,adopted,transferred,euthanized',
            'remarks' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $oldDisposition = $impound->current_disposition;
        $newDisposition = $request->current_disposition;

        $impound->update(['current_disposition' => $newDisposition]);

        ImpoundStatusHistory::create([
            'impound_id' => $impound->impound_id,
            'status' => $newDisposition,
            'remarks' => $request->remarks ?? 'Disposition changed from ' . $oldDisposition . ' to ' . $newDisposition,
            'updated_by_user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Disposition updated successfully.');
    }

    public function approve(Request $request, ImpoundRecord $impound)
    {
        $impound->update([
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Impound record approved successfully.');
    }

    public function destroy(ImpoundRecord $impound)
    {
        $impound->delete();

        return redirect()->route('impounds.index')
            ->with('success', 'Impound record deleted successfully.');
    }

    public function history(ImpoundRecord $impound)
    {
        $history = ImpoundStatusHistory::where('impound_id', $impound->impound_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin-staff.impounds.history', compact('impound', 'history'));
    }

    public function stats()
    {
        return response()->json([
            'total' => ImpoundRecord::count(),
            'impounded' => ImpoundRecord::where('current_disposition', 'impounded')->count(),
            'claimed' => ImpoundRecord::where('current_disposition', 'claimed')->count(),
            'adopted' => ImpoundRecord::where('current_disposition', 'adopted')->count(),
            'transferred' => ImpoundRecord::where('current_disposition', 'transferred')->count(),
            'euthanized' => ImpoundRecord::where('current_disposition', 'euthanized')->count(),
        ]);
    }
}