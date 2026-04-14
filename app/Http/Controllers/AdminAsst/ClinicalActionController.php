<?php

namespace App\Http\Controllers\AdminAsst;

use App\Http\Controllers\Controller;
use App\Models\ClinicalAction;
use App\Models\Barangay;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClinicalActionController extends Controller
{
    public function index(Request $request)
    {
        $query = ClinicalAction::query();

        if ($request->filled('barangay_id')) {
            $query->where('barangay_id', $request->barangay_id);
        }

        if ($request->filled('action_type')) {
            $query->where('action_type', $request->action_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('animal_name', 'like', '%' . $request->search . '%')
                  ->orWhere('owner_name', 'like', '%' . $request->search . '%')
                  ->orWhere('report_number', 'like', '%' . $request->search . '%');
            });
        }

        $actions = $query->orderBy('action_date', 'desc')->paginate(15);
        $barangays = Barangay::orderBy('barangay_name')->get();
        $veterinarians = User::where('role', 'veterinarian')->orWhere('role', 'assistant_vet')->get();

        return view('admin-asst.clinical-actions.index', compact('actions', 'barangays', 'veterinarians'));
    }

    public function create()
    {
        $barangays = Barangay::orderBy('barangay_name')->get();
        $veterinarians = User::where('role', 'veterinarian')->orWhere('role', 'assistant_vet')->get();
        return view('admin-asst.clinical-actions.create', compact('barangays', 'veterinarians'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'action_type' => 'required|string',
            'animal_name' => 'required|string|max:255',
            'species' => 'required|string|max:100',
            'owner_name' => 'required|string|max:255',
            'owner_contact' => 'nullable|string|max:50',
            'action_date' => 'required|date',
            'barangay_id' => 'required|exists:barangays,barangay_id',
            'description' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'treatment_given' => 'nullable|string',
            'medication' => 'nullable|string',
            'follow_up_date' => 'nullable|date',
            'outcome' => 'nullable|string',
            'veterinarian_id' => 'nullable|exists:admin_users,id',
        ]);

        $validated['created_by'] = Auth::id();

        ClinicalAction::create($validated);

        return redirect()->route('admin-asst.clinical-actions.index')
            ->with('success', 'Clinical action record created successfully.');
    }

    public function show(ClinicalAction $clinicalAction)
    {
        return view('admin-asst.clinical-actions.show', compact('clinicalAction'));
    }

    public function edit(ClinicalAction $clinicalAction)
    {
        $barangays = Barangay::orderBy('barangay_name')->get();
        $veterinarians = User::where('role', 'veterinarian')->orWhere('role', 'assistant_vet')->get();
        return view('admin-asst.clinical-actions.edit', compact('clinicalAction', 'barangays', 'veterinarians'));
    }

    public function update(Request $request, ClinicalAction $clinicalAction)
    {
        $validated = $request->validate([
            'action_type' => 'required|string',
            'animal_name' => 'required|string|max:255',
            'species' => 'required|string|max:100',
            'owner_name' => 'required|string|max:255',
            'owner_contact' => 'nullable|string|max:50',
            'action_date' => 'required|date',
            'barangay_id' => 'required|exists:barangays,barangay_id',
            'description' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'treatment_given' => 'nullable|string',
            'medication' => 'nullable|string',
            'follow_up_date' => 'nullable|date',
            'outcome' => 'nullable|string',
            'veterinarian_id' => 'nullable|exists:admin_users,id',
        ]);

        $clinicalAction->update($validated);

        return redirect()->route('admin-asst.clinical-actions.show', $clinicalAction)
            ->with('success', 'Clinical action updated successfully.');
    }

    public function destroy(ClinicalAction $clinicalAction)
    {
        $clinicalAction->delete();

        return redirect()->route('admin-asst.clinical-actions.index')
            ->with('success', 'Clinical action deleted successfully.');
    }
}