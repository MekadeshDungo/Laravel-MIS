<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RabiesCase;
use App\Models\AnimalBiteReport;
use App\Models\RabiesVaccinationReport;

class CityVetController extends Controller
{
    /**
     * Show city veterinarian dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Debug: Log user role
        \Log::debug('CityVetController - User Role: ' . ($user->role ?? 'no role'));
        
        // Get statistics - use correct column name 'case_status' for rabies cases
        $stats = [
            'total_rabies_cases' => RabiesCase::count(),
            'open_cases' => RabiesCase::where('status', 'open')->count(),
            'total_bite_reports' => AnimalBiteReport::count(),
            'total_vaccinations' => RabiesVaccinationReport::count(),
        ];
        
        // Get recent cases
        $recentCases = RabiesCase::latest()->take(5)->get();
        
        return view('dashboard.city-vet', compact('user', 'stats', 'recentCases'));
    }
}
