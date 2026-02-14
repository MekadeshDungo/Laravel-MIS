<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RabiesVaccinationReport;

class ClinicController extends Controller
{
    /**
     * Show clinic dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $reports = RabiesVaccinationReport::where('user_id', $user->id)->latest()->take(5)->get();
        return view('dashboard.clinic', compact('reports'));
    }

    /**
     * Show data entry form.
     */
    public function showDataEntry()
    {
        return view('dashboard.clinic-data-entry');
    }

    /**
     * Show rabies vaccination report form.
     */
    public function createVaccinationReport()
    {
        return view('reports.rabies_vaccination_form');
    }

    /**
     * Store rabies vaccination report.
     */
    public function storeVaccinationReport(Request $request)
    {
        $validated = $request->validate([
            'clinic_name' => 'required|string|max:255',
            'patient_name' => 'required|string|max:255',
            'patient_contact' => 'required|string|max:255',
            'patient_address' => 'required|string',
            'pet_name' => 'nullable|string|max:255',
            'pet_species' => 'required|string|max:255',
            'pet_breed' => 'nullable|string|max:255',
            'pet_age' => 'nullable|integer|min:0|max:30',
            'pet_gender' => 'nullable|string|in:male,female',
            'pet_color' => 'nullable|string|max:255',
            'vaccine_brand' => 'required|string|max:255',
            'vaccine_batch_number' => 'nullable|string|max:255',
            'vaccination_date' => 'required|date',
            'vaccination_time' => 'required',
            'vaccination_type' => 'required|string|in:primary,booster',
        ]);

        $report = RabiesVaccinationReport::create([
            'user_id' => Auth::id(),
            ...$validated,
        ]);

        return redirect()->route('clinic.vaccination-reports.index')
            ->with('success', 'Rabies vaccination report submitted successfully!');
    }

    /**
     * List rabies vaccination reports.
     */
    public function indexVaccinationReports()
    {
        $reports = RabiesVaccinationReport::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        return view('reports.rabies_vaccination_index', compact('reports'));
    }
}
