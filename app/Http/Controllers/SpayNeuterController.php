<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SpayNeuterReport;

class SpayNeuterController extends Controller
{
    /**
     * Show spay/neuter dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $reports = SpayNeuterReport::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
        
        $totalReports = SpayNeuterReport::count();
        $completed = SpayNeuterReport::where('status', 'completed')->count();
        $scheduled = SpayNeuterReport::where('status', 'scheduled')->count();
        
        return view('dashboard.spay-neuter', compact('reports', 'totalReports', 'completed', 'scheduled'));
    }

    /**
     * Show spay/neuter report form.
     */
    public function create()
    {
        return view('reports.spay_neuter_form');
    }

    /**
     * Store spay/neuter report.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pet_name' => 'nullable|string|max:255',
            'pet_type' => 'required|string|in:dog,cat,other',
            'pet_breed' => 'nullable|string|max:255',
            'pet_age' => 'nullable|integer|min:0',
            'pet_sex' => 'required|string|in:male,female',
            'color_markings' => 'nullable|string|max:255',
            'owner_name' => 'required|string|max:255',
            'owner_contact' => 'nullable|string|max:255',
            'owner_address' => 'nullable|string',
            'procedure_type' => 'required|string|in:spay,neuter,both',
            'procedure_date' => 'required|date',
            'veterinarian' => 'nullable|string|max:255',
            'clinic_name' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|in:scheduled,completed,cancelled,pending',
            'remarks' => 'nullable|string',
            'barangay' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['report_date'] = now();

        SpayNeuterReport::create($validated);

        \App\Services\NotificationService::spayNeuterCreated(SpayNeuterReport::latest()->first()->id);

        return redirect()->route('spay-neuter.reports.index')
            ->with('success', 'Spay/Neuter report submitted successfully!');
    }

    /**
     * List spay/neuter reports.
     */
    public function index(Request $request)
    {
        $query = SpayNeuterReport::query();

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by procedure type
        if ($request->has('procedure_type') && $request->procedure_type) {
            $query->where('procedure_type', $request->procedure_type);
        }

        // Filter by pet type
        if ($request->has('pet_type') && $request->pet_type) {
            $query->where('pet_type', $request->pet_type);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('procedure_date', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('procedure_date', '<=', $request->end_date);
        }

        // Non-admin users can only see their own reports
        if (!in_array(Auth::user()->role, ['super_admin', 'admin', 'city_vet', 'disease_control'])) {
            $query->where('user_id', Auth::id());
        }

        $reports = $query->latest()->paginate(10);
        return view('reports.spay_neuter_index', compact('reports'));
    }

    /**
     * Show spay/neuter report details.
     */
    public function show(SpayNeuterReport $report)
    {
        $this->authorizeReport($report);
        return view('reports.spay_neuter_show', compact('report'));
    }

    /**
     * Edit spay/neuter report.
     */
    public function edit(SpayNeuterReport $report)
    {
        $this->authorizeReport($report);
        return view('reports.spay_neuter_form', compact('report'));
    }

    /**
     * Update spay/neuter report.
     */
    public function update(Request $request, SpayNeuterReport $report)
    {
        $this->authorizeReport($report);

        $validated = $request->validate([
            'pet_name' => 'nullable|string|max:255',
            'pet_type' => 'required|string|in:dog,cat,other',
            'pet_breed' => 'nullable|string|max:255',
            'pet_age' => 'nullable|integer|min:0',
            'pet_sex' => 'required|string|in:male,female',
            'color_markings' => 'nullable|string|max:255',
            'owner_name' => 'required|string|max:255',
            'owner_contact' => 'nullable|string|max:255',
            'owner_address' => 'nullable|string',
            'procedure_type' => 'required|string|in:spay,neuter,both',
            'procedure_date' => 'required|date',
            'veterinarian' => 'nullable|string|max:255',
            'clinic_name' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|in:scheduled,completed,cancelled,pending',
            'remarks' => 'nullable|string',
            'barangay' => 'nullable|string|max:255',
        ]);

        $report->update($validated);

        return redirect()->route('spay-neuter.reports.index')
            ->with('success', 'Spay/Neuter report updated successfully!');
    }

    /**
     * Delete spay/neuter report.
     */
    public function destroy(SpayNeuterReport $report)
    {
        $this->authorizeReport($report);
        $report->delete();

        return redirect()->route('spay-neuter.reports.index')
            ->with('success', 'Spay/Neuter report deleted successfully!');
    }

    /**
     * Export reports to PDF.
     */
    public function export(Request $request)
    {
        // Implementation for PDF export
        return redirect()->back()->with('info', 'PDF export feature coming soon!');
    }

    /**
     * Authorize report access.
     */
    private function authorizeReport($report)
    {
        if ($report->user_id !== Auth::id() && 
            !in_array(Auth::user()->role, ['super_admin', 'admin', 'city_vet', 'disease_control'])) {
            abort(403, 'Unauthorized action.');
        }
    }
}
