<?php

namespace App\Http\Controllers\AdminAsst;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\CrueltyReport;
use App\Models\InventoryControl;
use App\Models\AdoptionRequest;
use App\Models\ImpoundRecord;
use App\Models\FormSubmission;
use App\Models\ServiceForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin assistant dashboard.
     */
    public function index()
    {
        // Pet Registration Statistics
        $totalPets = Animal::count();
        $pendingPetRegistrations = Animal::where('license_number', null)->count();
        
        // Appointment/Service Request Statistics (via FormSubmissions)
        $pendingAppointments = FormSubmission::where('status', 'pending')->count();
        $todayAppointments = FormSubmission::whereDate('submitted_at', now()->toDateString())->count();
        
        // Cruelty Report Statistics
        $totalCrueltyReports = CrueltyReport::count();
        $pendingCrueltyReports = CrueltyReport::where('status', 'pending')->count();
        $resolvedCrueltyReports = CrueltyReport::where('status', 'resolved')->count();
        
        // Inventory Statistics
        $totalInventoryItems = InventoryControl::count();
        $lowStockItems = InventoryControl::whereRaw('quantity <= minimum_stock')->count();
        $expiringItems = InventoryControl::whereNotNull('expiry_date')
            ->where('expiry_date', '<=', now()->addDays(30))
            ->where('expiry_date', '>=', now())
            ->count();
        
        // Adoption Statistics
        $totalAdoptions = AdoptionRequest::count();
        $pendingAdoptions = AdoptionRequest::where('request_status', 'pending')->count();
        $approvedAdoptions = AdoptionRequest::where('request_status', 'approved')->count();
        
        // Impound Statistics
        $totalImpounds = ImpoundRecord::count();
        $availableForAdoption = ImpoundRecord::where('current_disposition', 'impounded')->count();
        
        // Recent Activity
        $recentPetRegistrations = Animal::latest()->take(5)->get();
        $recentCrueltyReports = CrueltyReport::latest()->take(5)->get();
        $recentAdoptions = AdoptionRequest::with('impound')->latest()->take(5)->get();
        $recentSubmissions = FormSubmission::with('form')->latest()->take(5)->get();
        
        // Monthly Statistics for Charts
        $monthlyRegistrations = Animal::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->whereYear('created_at', now()->year)
        ->groupBy('month')
        ->pluck('count', 'month')
        ->toArray();
        
        $monthlyCrueltyReports = CrueltyReport::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->whereYear('created_at', now()->year)
        ->groupBy('month')
        ->pluck('count', 'month')
        ->toArray();
        
        return view('admin-asst.dashboard', compact(
            'totalPets',
            'pendingPetRegistrations',
            'pendingAppointments',
            'todayAppointments',
            'totalCrueltyReports',
            'pendingCrueltyReports',
            'resolvedCrueltyReports',
            'totalInventoryItems',
            'lowStockItems',
            'expiringItems',
            'totalAdoptions',
            'pendingAdoptions',
            'approvedAdoptions',
            'totalImpounds',
            'availableForAdoption',
            'recentPetRegistrations',
            'recentCrueltyReports',
            'recentAdoptions',
            'recentSubmissions',
            'monthlyRegistrations',
            'monthlyCrueltyReports'
        ));
    }
}
