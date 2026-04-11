<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Pet;
use App\Models\Client;
use App\Models\AdoptionRequest;

/**
 * AdminStaffController - Administrative Staff Module
 *
 * THESIS ROLE MAPPING:
 * - Primary Role: admin_staff (Administrative Assistant IV / Book Binder 4)
 * - Legacy Alias: admin_asst (for backward compatibility)
 *
 * MODULE ASSIGNMENTS:
 * - Pet Registration (Portal Gatekeeper)
 * - Owner Records Management
 * - Vaccination Encoding
 * - Records Search
 * - Adoption Management
 * - Inventory Control
 *
 * ACCESSIBLE ROUTES:
 * - admin-staff.dashboard
 * - admin-staff.pets.*
 * - admin-staff.owners.*
 * - admin-staff.vaccinations.*
 * - admin-staff.search
 * - admin-staff.adoptions.*
 * - admin-staff.announcements.index
 */
class AdminStaffController extends Controller
{
    /**
     * Show admin staff dashboard.
     *
     * Module: Dashboard
     * Role: admin_staff
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Get statistics
        // Note: adoption_requests table was dropped in migration
        // Keeping this as 0 for now - can be restored if needed
        $stats = [
            'total_animals' => Pet::count(),
            'total_owners' => Client::count(),
            'pending_adoptions' => 0, // Table was dropped in migration
        ];

        return view('dashboard.admin-staff', compact('user', 'stats'));
    }

    /**
     * List adoption requests.
     *
     * Module: Adoption Management
     * Role: admin_staff
     */
    public function indexAdoptions(Request $request)
    {
        $query = AdoptionRequest::with(['pet', 'user']);

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $adoptions = $query->latest()->paginate(10);
        return view('dashboard.adoptions.index', compact('adoptions'));
    }

    /**
     * Show adoption request details.
     */
    public function showAdoption(AdoptionRequest $adoption)
    {
        $adoption->load(['pet', 'user']);
        return view('dashboard.adoptions.show', compact('adoption'));
    }

    /**
     * Approve adoption request.
     *
     * Module: Adoption Management
     * Role: admin_staff
     */
    public function approveAdoption(AdoptionRequest $adoption)
    {
        $adoption->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Adoption request approved.');
    }

    /**
     * Reject adoption request.
     *
     * Module: Adoption Management
     * Role: admin_staff
     */
    public function rejectAdoption(AdoptionRequest $adoption)
    {
        $adoption->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Adoption request rejected.');
    }
}
