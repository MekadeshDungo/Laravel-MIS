<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AnimalBiteReport;
use App\Models\RabiesVaccinationReport;
use App\Models\MeatInspectionReport;
use App\Models\ImpoundRecord;
use App\Models\User;
use App\Models\Announcement;
use App\Models\StrayReport;
use App\Models\SystemLog;

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
        $isSuperAdmin = $user->role === 'super_admin';

        // Get all statistics from database
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'total_announcements' => Announcement::count(),
            'total_bite_reports' => AnimalBiteReport::count(),
            'total_vaccinations' => RabiesVaccinationReport::count(),
            'total_meat_inspections' => MeatInspectionReport::count(),
            'total_stray_reports' => StrayReport::count(),
        ];

        // Bite reports by status
        $biteStats = [
            'pending' => AnimalBiteReport::where('status', 'pending')->count(),
            'investigating' => AnimalBiteReport::where('status', 'investigating')->count(),
            'resolved' => AnimalBiteReport::where('status', 'resolved')->count(),
        ];

        // Rabies vaccinations by species
        $vaccinationStats = [
            'dogs' => RabiesVaccinationReport::where('pet_species', 'dog')->count(),
            'cats' => RabiesVaccinationReport::where('pet_species', 'cat')->count(),
            'other' => RabiesVaccinationReport::where('pet_species', 'other')->count(),
        ];

        // Meat inspections by compliance status
        $meatInspectionStats = [
            'compliant' => MeatInspectionReport::where('compliance_status', 'compliant')->count(),
            'non_compliant' => MeatInspectionReport::where('compliance_status', 'non_compliant')->count(),
            'pending' => MeatInspectionReport::where('compliance_status', 'pending')->count(),
        ];

        // User distribution by role
        $userRoles = User::selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray();

        // Recent activity (bite reports)
        $recentActivity = AnimalBiteReport::latest()->take(5)->get();

        // Get reports for export/generation
        $biteReports = AnimalBiteReport::latest()->get();
        $vaccinationReports = RabiesVaccinationReport::latest()->get();
        $inspectionReports = MeatInspectionReport::latest()->get();

        // Additional data for super_admin view
        $recentAnnouncements = Announcement::latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        // For super_admin, show simplified user-focused view
        if ($isSuperAdmin) {
            return view('super-admin.all-reports', compact(
                'user',
                'isSuperAdmin',
                'stats',
                'biteStats',
                'vaccinationStats',
                'meatInspectionStats',
                'userRoles',
                'recentActivity',
                'recentAnnouncements',
                'recentUsers',
                'biteReports',
                'vaccinationReports',
                'inspectionReports'
            ));
        }

        // For other admins (city_vet), show full reports view
        return view('admin.all-reports', compact(
            'user',
            'isSuperAdmin',
            'stats',
            'biteStats',
            'vaccinationStats',
            'meatInspectionStats',
            'userRoles',
            'recentActivity',
            'biteReports',
            'vaccinationReports',
            'inspectionReports'
        ));
    }

    /**
     * List all animal bite reports (from Barangay).
     */
    public function indexBiteReports(Request $request)
    {
        $user = Auth::user();

        // Get counts
        $stats = [
            'total' => AnimalBiteReport::count(),
            'pending' => AnimalBiteReport::where('status', 'pending')->count(),
            'in_progress' => AnimalBiteReport::where('status', 'in_progress')->count(),
            'resolved' => AnimalBiteReport::where('status', 'resolved')->count(),
        ];

        $query = AnimalBiteReport::query();

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $reports = $query->latest()->paginate(10);
        return view('dashboard.bite-reports', compact('user', 'reports', 'stats'));
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
     * List all impound records.
     */
    public function indexImpoundRecords()
    {
        $user = Auth::user();
        $impounds = ImpoundRecord::with('strayReport')->latest()->paginate(10);
        return view('dashboard.impound-records', compact('user', 'impounds'));
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
