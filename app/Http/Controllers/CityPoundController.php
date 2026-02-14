<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StrayReport;
use App\Models\ImpoundRecord;

class CityPoundController extends Controller
{
    /**
     * Show city pound dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get statistics
        $stats = [
            'total_reports' => StrayReport::count(),
            'new_reports' => StrayReport::where('report_status', 'new')->count(),
            'total_impounds' => ImpoundRecord::count(),
            'pending_adoptions' => 0,
        ];
        
        // Get recent reports
        $recentReports = StrayReport::latest()->take(5)->get();
        
        return view('dashboard.city-pound', compact('user', 'stats', 'recentReports'));
    }
}
