<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RabiesCase;
use App\Models\AnimalBiteReport;

class DiseaseControlController extends Controller
{
    /**
     * Show disease control dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get statistics
        $stats = [
            'total_rabies_cases' => RabiesCase::count(),
            'open_cases' => RabiesCase::where('status', 'open')->count(),
            'total_bite_reports' => AnimalBiteReport::count(),
            'pending_bite_reports' => AnimalBiteReport::where('status', 'pending')->count(),
        ];
        
        // Get recent cases
        $recentCases = RabiesCase::latest()->take(5)->get();
        
        return view('dashboard.disease-control', compact('user', 'stats', 'recentCases'));
    }
    
    /**
     * List rabies cases.
     */
    public function indexCases(Request $request)
    {
        $user = Auth::user();
        $query = RabiesCase::query();
        
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        $cases = $query->latest()->paginate(10);
        return view('dashboard.rabies-cases', compact('user', 'cases'));
    }
    
    /**
     * List animal bite reports.
     */
    public function indexBiteReports(Request $request)
    {
        $user = Auth::user();
        $query = AnimalBiteReport::query();
        
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        $reports = $query->latest()->paginate(10);
        return view('dashboard.bite-reports', compact('user', 'reports'));
    }
}
