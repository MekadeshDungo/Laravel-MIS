<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MeatInspectionReport;

class MeatInspectionController extends Controller
{
    /**
     * Show meat inspection dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $reports = MeatInspectionReport::where('user_id', $user->id)->latest()->take(5)->get();
        return view('dashboard.meat-inspection', compact('reports'));
    }

    /**
     * Show meat inspection report form.
     */
    public function createReport()
    {
        return view('reports.meat_inspection_form');
    }

    /**
     * Store meat inspection report.
     */
    public function storeReport(Request $request)
    {
        $validated = $request->validate([
            'establishment_name' => 'required|string|max:255',
            'establishment_type' => 'required|string|max:255',
            'establishment_address' => 'required|string',
            'owner_name' => 'required|string|max:255',
            'owner_contact' => 'required|string|max:255',
            'inspection_date' => 'required|date',
            'inspection_time' => 'required',
            'inspector_name' => 'required|string|max:255',
            'inspection_type' => 'required|string|in:routine,complaint,follow_up,special',
            'overall_rating' => 'required|string|in:excellent,good,satisfactory,poor,failed',
        ]);

        $report = MeatInspectionReport::create([
            'user_id' => Auth::id(),
            ...$validated,
        ]);

        return redirect()->route('meat-inspection.reports.index')
            ->with('success', 'Meat inspection report submitted successfully!');
    }

    /**
     * List meat inspection reports.
     */
    public function indexReports()
    {
        $reports = MeatInspectionReport::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        return view('reports.meat_inspection', compact('reports'));
    }

    /**
     * Show meat inspection report details.
     */
    public function showReport(MeatInspectionReport $report)
    {
        $this->authorizeReport($report);
        return view('reports.meat_inspection_form', compact('report'));
    }

    private function authorizeReport($report)
    {
        if ($report->user_id !== Auth::id() && !in_array(Auth::user()->role, ['super_admin', 'admin'])) {
            abort(403, 'Unauthorized action.');
        }
    }
}
