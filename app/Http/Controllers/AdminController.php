<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AnimalBiteReport;
use App\Models\RabiesVaccinationReport;
use App\Models\MeatInspectionReport;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard (System Admin - Full Access).
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Viewers cannot access the admin dashboard - redirect to their own
        if ($user->role === 'viewer') {
            return redirect()->route('viewer.dashboard');
        }
        
        // Get statistics
        $stats = [
            'total_bite_reports' => AnimalBiteReport::count(),
            'pending_bite_reports' => AnimalBiteReport::where('status', 'pending')->count(),
            'total_vaccination_reports' => RabiesVaccinationReport::count(),
            'total_meat_inspection_reports' => MeatInspectionReport::count(),
            'total_users' => User::count(),
            'compliant_meat_inspections' => MeatInspectionReport::where('compliance_status', 'compliant')->count(),
        ];
        
        // Get recent reports
        $recent_bites = AnimalBiteReport::latest()->take(5)->get();
        $recent_vaccinations = RabiesVaccinationReport::latest()->take(5)->get();
        $recent_meat_inspections = MeatInspectionReport::latest()->take(5)->get();
        
        return view('dashboard.admin', compact('user', 'stats', 'recent_bites', 'recent_vaccinations', 'recent_meat_inspections'));
    }

    /**
     * Show all reports (city-wide view).
     */
    public function allReports()
    {
        $user = Auth::user();
        
        $biteReports = AnimalBiteReport::latest()->get();
        $vaccinationReports = RabiesVaccinationReport::latest()->get();
        $inspectionReports = MeatInspectionReport::latest()->get();
        
        $layout = auth()->user()->role === 'super_admin' ? 'super-admin' : 'admin';
        
        return view($layout . '.all-reports', compact('biteReports', 'vaccinationReports', 'inspectionReports', 'user'));
    }

    /**
     * List all animal bite reports (from Barangay).
     */
    public function indexBiteReports()
    {
        $user = Auth::user();
        $reports = AnimalBiteReport::latest()->paginate(10);
        return view('dashboard.bite-reports', compact('user', 'reports'));
    }

    /**
     * Show animal bite report details.
     */
    public function showBiteReport(AnimalBiteReport $report)
    {
        $user = Auth::user();
        $report->load('user');
        return view('dashboard.bite-report-view', compact('report', 'user'));
    }

    /**
     * List all rabies vaccination reports (from Clinic).
     */
    public function indexVaccinationReports()
    {
        $user = Auth::user();
        $reports = RabiesVaccinationReport::latest()->paginate(10);
        return view('dashboard.vaccination-reports', compact('user', 'reports'));
    }

    /**
     * Show rabies vaccination report details.
     */
    public function showVaccinationReport(RabiesVaccinationReport $report)
    {
        $user = Auth::user();
        $report->load('user');
        return view('dashboard.vaccination-report-view', compact('report', 'user'));
    }

    /**
     * List all meat inspection reports.
     */
    public function indexMeatInspectionReports()
    {
        $user = Auth::user();
        $reports = MeatInspectionReport::latest()->paginate(10);
        return view('dashboard.meat-inspection', compact('user', 'reports'));
    }

    /**
     * Show meat inspection report details.
     */
    public function showMeatInspectionReport(MeatInspectionReport $report)
    {
        $user = Auth::user();
        $report->load('user');
        return view('dashboard.meat-inspection-view', compact('report', 'user'));
    }

    /**
     * Update animal bite report status.
     */
    public function updateBiteReport(Request $request, AnimalBiteReport $report)
    {
        $request->validate([
            'status' => 'required|in:pending,investigating,resolved',
        ]);
        
        $report->update(['status' => $request->status]);
        
        return redirect()->route('admin.bite-reports.index')->with('success', 'Report status updated successfully.');
    }
}
