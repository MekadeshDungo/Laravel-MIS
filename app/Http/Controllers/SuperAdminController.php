<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Animal;
use App\Models\Announcement;
use App\Models\SystemLog;
use App\Models\RabiesCase;
use App\Models\RabiesVaccinationReport;
use App\Models\AnimalBiteReport;
use App\Models\Barangay;
use Carbon\Carbon;

class SuperAdminController extends Controller
{
    /**
     * Show super admin dashboard.
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $year = $request->year ?? date('Y');

        // Get comprehensive statistics
        $stats = [
            // User statistics
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'inactive_users' => User::where('status', 'inactive')->count(),

            // Role breakdown - Clean structure (8 active roles)
            'super_admins' => User::where('role', 'super_admin')->count(),
            'city_vets' => User::where('role', 'city_vet')->count(),
            'admin_assistants' => User::where('role', 'admin_asst')->count(),
            'assistant_vets' => User::whereIn('role', ['assistant_vet', 'disease_control'])->count(),
            'veterinarians' => User::where('role', 'veterinarian')->count(),
            'livestock_inspectors' => User::where('role', 'livestock_inspector')->count(),
            'meat_inspectors' => User::where('role', 'meat_inspector')->count(),
            'records_staff' => User::where('role', 'records_staff')->count(),
            'barangay_encoders' => User::where('role', 'barangay_encoder')->count(),
            'viewers' => User::where('role', 'viewer')->count(),

            // Client & Animal statistics
            'total_clients' => User::where('role', 'citizen')->count(),
            'total_animals' => Animal::count(),

            // Case statistics
            'total_rabies_cases' => RabiesCase::whereYear('incident_date', $year)->count(),
            'total_vaccinations' => RabiesVaccinationReport::whereYear('vaccination_date', $year)->count(),
            'total_bite_reports' => AnimalBiteReport::whereRaw('YEAR(bite_date) = ?', [$year])->count(),

            // System statistics
            'total_barangays' => Barangay::count(),
            'total_announcements' => Announcement::count(),
            'active_announcements' => Announcement::where('is_active', true)->count(),
        ];

        // Get recent users
        $recentUsers = User::latest()->take(10)->get();

        // Get recent system logs
        $recentLogs = SystemLog::with('user')->latest()->take(10)->get();

        // Get recent announcements
        $recentAnnouncements = Announcement::latest()->take(5)->get();

        // Get monthly user registration trend
        $monthlyUserRegistrations = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Get monthly rabies cases trend
        $monthlyRabiesCases = RabiesCase::selectRaw('MONTH(incident_date) as month, COUNT(*) as count')
            ->whereYear('incident_date', $year)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        return view('dashboard.super-admin', compact(
            'user',
            'stats',
            'recentUsers',
            'recentLogs',
            'recentAnnouncements',
            'monthlyUserRegistrations',
            'monthlyRabiesCases',
            'year'
        ));
    }

    /**
     * Get system statistics API endpoint.
     */
    public function systemStats(Request $request)
    {
        $year = $request->year ?? date('Y');

        $stats = [
            'total_users' => User::count(),
            'total_clients' => User::where('role', 'citizen')->count(),
            'total_animals' => Animal::count(),
            'total_rabies_cases' => RabiesCase::whereYear('incident_date', $year)->count(),
            'total_vaccinations' => RabiesVaccinationReport::whereYear('vaccination_date', $year)->count(),
            'total_bite_reports' => AnimalBiteReport::whereRaw('YEAR(bite_date) = ?', [$year])->count(),
            'total_barangays' => Barangay::count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
            'year' => $year
        ]);
    }

    /**
     * Get user statistics by role.
     */
    public function userStats()
    {
        $roles = User::selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray();

        $roleNames = [
            'super_admin' => 'Super Admin (IT)',
            'city_vet' => 'City Veterinarian',
            'admin_asst' => 'Administrative Assistant IV',
            'veterinarian' => 'Veterinarian III',
            'livestock_inspector' => 'Livestock Inspector',
            'meat_inspector' => 'Meat Inspector',
            'records_staff' => 'Records Staff',
            'disease_control' => 'Assistant Veterinary',
            'barangay_encoder' => 'Barangay Encoder',
            'viewer' => 'Viewer/Supervisor',
        ];

        $formattedRoles = [];
        foreach ($roles as $role => $count) {
            $formattedRoles[] = [
                'role' => $role,
                'label' => $roleNames[$role] ?? $role,
                'count' => $count,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $formattedRoles,
            'total' => array_sum($roles)
        ]);
    }

    /**
     * Get activity logs.
     */
    public function activityLogs(Request $request)
    {
        $perPage = $request->per_page ?? 20;
        $search = $request->search;
        $action = $request->action;

        $query = SystemLog::with('user');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($action) {
            $query->where('action', $action);
        }

        $logs = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $logs
        ]);
    }

    /**
     * Export system report.
     */
    public function exportReport(Request $request)
    {
        $type = $request->type ?? 'summary';
        $year = $request->year ?? date('Y');
        $format = $request->format ?? 'csv';

        $data = [];
        $filename = 'system_report_' . $year . '_' . now()->format('YmdHis');

        switch ($type) {
            case 'users':
                $data = User::select(['id', 'name', 'email', 'role', 'status', 'created_at'])
                    ->get()
                    ->toArray();
                $filename = 'users_report_' . $year;
                break;

            case 'rabies':
                $data = RabiesCase::with('barangay')
                    ->whereYear('incident_date', $year)
                    ->get()
                    ->toArray();
                $filename = 'rabies_cases_report_' . $year;
                break;

            case 'vaccinations':
                $data = RabiesVaccinationReport::whereYear('vaccination_date', $year)
                    ->get()
                    ->toArray();
                $filename = 'vaccinations_report_' . $year;
                break;

            case 'bite_reports':
                $data = AnimalBiteReport::whereYear('bite_date', $year)
                    ->get()
                    ->toArray();
                $filename = 'bite_reports_report_' . $year;
                break;

            case 'summary':
            default:
                $data = [
                    'generated_at' => now()->toIso8601String(),
                    'period' => $year,
                    'total_users' => User::count(),
                    'total_clients' => User::where('role', 'citizen')->count(),
                    'total_animals' => Animal::count(),
                    'total_rabies_cases' => RabiesCase::whereYear('incident_date', $year)->count(),
                    'total_vaccinations' => RabiesVaccinationReport::whereYear('vaccination_date', $year)->count(),
                    'total_bite_reports' => AnimalBiteReport::whereRaw('YEAR(bite_date) = ?', [$year])->count(),
                    'total_barangays' => Barangay::count(),
                    'total_announcements' => Announcement::count(),
                ];
                $filename = 'system_summary_' . $year;
                break;
        }

        // Log the export action
        SystemLog::create([
            'user_id' => auth()->id(),
            'action' => 'export_report',
            'description' => "Exported {$type} report for year {$year}",
            'ip_address' => request()->ip(),
        ]);

        return response()->json([
            'success' => true,
            'data' => $data,
            'filename' => $filename,
            'format' => $format
        ]);
    }

    /**
     * System configuration settings.
     */
    public function settings(Request $request)
    {
        $user = Auth::user();

        // Get system settings (in production, these would come from a settings table)
        $settings = [
            'system_name' => config('app.name', 'Vet MIS'),
            'system_version' => '1.0.0',
            'timezone' => config('app.timezone', 'Asia/Manila'),
            'date_format' => 'Y-m-d',
            'time_format' => 'H:i:s',
            'maintenance_mode' => false,
            'registration_enabled' => true,
            'email_verification_required' => true,
        ];

        return view('super-admin.settings', compact('user', 'settings'));
    }

    /**
     * Update system settings.
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'system_name' => 'nullable|string|max:255',
            'maintenance_mode' => 'nullable|boolean',
            'registration_enabled' => 'nullable|boolean',
        ]);

        // In production, save to settings table
        // For now, log the changes
        SystemLog::create([
            'user_id' => auth()->id(),
            'action' => 'update_settings',
            'description' => "Updated system settings: " . json_encode($validated),
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('super-admin.settings')
            ->with('success', 'System settings updated successfully.');
    }

    /**
     * View all users with filtering.
     */
    public function users(Request $request)
    {
        $search = $request->get('search', '');
        $role = $request->get('role', '');
        $status = $request->get('status', '');

        $query = User::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role) {
            $query->where('role', $role);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $users = $query->latest()->paginate(20);
        $roles = User::distinct()->pluck('role');

        return view('super-admin.users', compact('users', 'roles', 'search', 'role', 'status'));
    }

    /**
     * Toggle user status.
     */
    public function toggleUserStatus(User $user)
    {
        // Policy check using Gate
        if (Gate::denies('toggleStatus', $user)) {
            return back()->with('error', 'You do not have permission to change this user\'s status.');
        }

        // Cannot toggle own status
        if ($user->isSelf()) {
            return back()->with('error', 'You cannot change your own status.');
        }

        // Super admin self-protection
        if ($user->isSuperAdmin() && $user->isSelf()) {
            return back()->with('error', 'You cannot deactivate your own Super Administrator account.');
        }

        $newStatus = $user->status === 'active' ? 'inactive' : 'active';

        $user->update(['status' => $newStatus]);

        SystemLog::create([
            'user_id' => auth()->id(),
            'action' => 'toggle_user_status',
            'description' => "Changed user {$user->name} status to {$newStatus}",
            'ip_address' => request()->ip(),
        ]);

        $statusText = $newStatus === 'active' ? 'activated' : 'deactivated';
        return back()->with('success', "User {$user->name} {$statusText} successfully.");
    }
}
