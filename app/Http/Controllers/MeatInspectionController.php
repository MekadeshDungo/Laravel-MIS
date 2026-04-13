<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MeatInspectionReport;
use App\Models\MeatShopInspection;
use App\Models\MeatEstablishment;
use App\Models\User;
use App\Models\Barangay;

class MeatInspectionController extends Controller
{
    /**
     * Show meat inspection dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $reports = MeatInspectionReport::where('inspector_user_id', $user->id)->latest()->take(5)->get();
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
            'inspector_user_id' => Auth::id(),
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
        $reports = MeatInspectionReport::where('inspector_user_id', Auth::id())
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

    /**
     * Show meat shop inspection form.
     */
    public function createMeatShopInspection()
    {
        $meatShops = MeatEstablishment::with('barangay')->orderBy('establishment_name')->get();
        return view('reports.meat_shop_inspection_form', compact('meatShops'));
    }

    /**
     * Store meat shop inspection.
     */
    public function storeMeatShopInspection(Request $request)
    {
        $validated = $request->validate([
            'meat_shop_id' => 'required|exists:meat_establishments,establishment_id',
            'inspection_date' => 'required|date',
            'ticket_number' => 'nullable|string|max:255',
            'licensing' => 'nullable|in:compliant,non_compliant',
            'storage' => 'nullable|in:compliant,non_compliant',
            'meat_quality' => 'nullable|in:compliant,non_compliant',
            'sanitation' => 'nullable|in:compliant,non_compliant',
            'lighting' => 'nullable|in:compliant,non_compliant',
            'personal_hygiene' => 'nullable|in:compliant,non_compliant',
            'equipment' => 'nullable|in:compliant,non_compliant',
            'apprehension_status' => 'nullable|in:none,1st_warning,2nd_warning,3rd_warning',
            'remarks' => 'nullable|string',
        ]);

        $validated['apprehended_by_user_id'] = Auth::id();

        $inspection = MeatShopInspection::create($validated);

        return redirect()->route('meat-inspection.meat-shop.index')
            ->with('success', 'Meat shop inspection submitted successfully!');
    }

    /**
     * List meat shop inspections.
     */
    public function indexMeatShopInspections()
    {
        $inspections = MeatShopInspection::with(['meatShop', 'inspector'])
            ->latest()
            ->paginate(10);
        return view('reports.meat_shop_inspections_list', compact('inspections'));
    }

    /**
     * Show meat shop inspection details.
     */
    public function showMeatShopInspection(MeatShopInspection $inspection)
    {
        $inspection->load(['meatShop', 'inspector']);
        $meatShops = MeatEstablishment::with('barangay')->orderBy('establishment_name')->get();
        return view('reports.meat_shop_inspection_form', compact('inspection', 'meatShops'));
    }

    /**
     * Update meat shop inspection.
     */
    public function updateMeatShopInspection(Request $request, MeatShopInspection $inspection)
    {
        $validated = $request->validate([
            'meat_shop_id' => 'required|exists:meat_establishments,establishment_id',
            'inspection_date' => 'required|date',
            'ticket_number' => 'nullable|string|max:255',
            'licensing' => 'nullable|in:compliant,non_compliant',
            'storage' => 'nullable|in:compliant,non_compliant',
            'meat_quality' => 'nullable|in:compliant,non_compliant',
            'sanitation' => 'nullable|in:compliant,non_compliant',
            'lighting' => 'nullable|in:compliant,non_compliant',
            'personal_hygiene' => 'nullable|in:compliant,non_compliant',
            'equipment' => 'nullable|in:compliant,non_compliant',
            'apprehension_status' => 'nullable|in:none,1st_warning,2nd_warning,3rd_warning',
            'remarks' => 'nullable|string',
        ]);

        $inspection->update($validated);

        return redirect()->route('meat-inspection.meat-shop.index')
            ->with('success', 'Meat shop inspection updated successfully!');
    }

    /**
     * Get meat shop address for AJAX.
     */
    public function getMeatShopAddress(Request $request)
    {
        $shop = MeatEstablishment::find($request->meat_shop_id);
        return response()->json([
            'address' => $shop ? $shop->address_text : ''
        ]);
    }

    /**
     * List meat establishments.
     */
    public function indexEstablishments()
    {
        $establishments = MeatEstablishment::with('barangay')->orderBy('establishment_name')->paginate(10);
        return view('reports.meat_establishments_list', compact('establishments'));
    }

    /**
     * Show create meat establishment form.
     */
    public function createEstablishment()
    {
        $barangays = Barangay::orderBy('barangay_name')->get();
        return view('reports.meat_establishment_form', compact('barangays'));
    }

    /**
     * Store new meat establishment.
     */
    public function storeEstablishment(Request $request)
    {
        $validated = $request->validate([
            'establishment_name' => 'required|string|max:255|unique:meat_establishments,establishment_name',
            'establishment_type' => 'required|in:meat_shop,slaughterhouse,livestock_farm,poultry_farm,meat_processing_plant',
            'owner_name' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'barangay_id' => 'required|exists:barangays,barangay_id',
            'address_text' => 'required|string',
            'landmark' => 'nullable|string|max:255',
            'permit_no' => 'nullable|string|max:255',
        ]);

        $validated['registered_by_user_id'] = Auth::id();

        MeatEstablishment::create($validated);

        return redirect()->route('meat-inspection.establishments.index')
            ->with('success', 'Meat establishment registered successfully!');
    }

    /**
     * Show meat establishment details.
     */
    public function showEstablishment(MeatEstablishment $establishment)
    {
        $barangays = Barangay::orderBy('barangay_name')->get();
        return view('reports.meat_establishment_form', compact('establishment', 'barangays'));
    }

    /**
     * Update meat establishment.
     */
    public function updateEstablishment(Request $request, MeatEstablishment $establishment)
    {
        $validated = $request->validate([
            'establishment_name' => 'required|string|max:255|unique:meat_establishments,establishment_name,' . $establishment->establishment_id . ',establishment_id',
            'establishment_type' => 'required|in:meat_shop,slaughterhouse,livestock_farm,poultry_farm,meat_processing_plant',
            'owner_name' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'barangay_id' => 'required|exists:barangays,barangay_id',
            'address_text' => 'required|string',
            'landmark' => 'nullable|string|max:255',
            'permit_no' => 'nullable|string|max:255',
        ]);

        $establishment->update($validated);

        return redirect()->route('meat-inspection.establishments.index')
            ->with('success', 'Meat establishment updated successfully!');
    }

    private function authorizeReport($report)
    {
        if ($report->inspector_user_id !== Auth::id() && !Auth::user()->hasAnyRole(['super_admin', 'city_vet'])) {
            abort(403, 'Unauthorized action.');
        }
    }
}
