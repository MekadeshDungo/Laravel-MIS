<?php

namespace App\Http\Controllers\AdminAsst;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use App\Models\Barangay;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BusinessProfileController extends Controller
{
    /**
     * Display a listing of business profiles (establishments).
     */
    public function index(Request $request)
    {
        $query = Establishment::query()->with('barangay', 'user');

        // Filter by type (poultry, livestock_facility)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by barangay
        if ($request->filled('barangay_id')) {
            $query->where('barangay_id', $request->barangay_id);
        }

        // Search by name, owner, or permit number
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('owner_name', 'like', '%' . $search . '%')
                  ->orWhere('permit_no', 'like', '%' . $search . '%');
            });
        }

        $establishments = $query->orderBy('created_at', 'desc')->paginate(15);
        $barangays = Barangay::orderBy('barangay_name')->get();

        // Statistics
        $totalCount = Establishment::count();
        $poultryCount = Establishment::where('type', 'poultry')->count();
        $livestockCount = Establishment::where('type', 'livestock_facility')->count();
        $activeCount = Establishment::where('status', 'active')->count();
        $pendingCount = Establishment::where('status', 'pending')->count();

        return view('admin-asst.business-profiles.index', compact(
            'establishments',
            'barangays',
            'totalCount',
            'poultryCount',
            'livestockCount',
            'activeCount',
            'pendingCount'
        ));
    }

    /**
     * Show the form for creating a new business profile.
     */
    public function create()
    {
        $barangays = Barangay::orderBy('barangay_name')->get();
        $users = User::orderBy('name')->get();
        
        return view('admin-asst.business-profiles.create', compact('barangays', 'users'));
    }

    /**
     * Store a newly created business profile.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:poultry,livestock_facility,meat_shop,pet_shop,vet_clinic,other',
            'permit_no' => 'nullable|string|max:255',
            'address' => 'required|string|max:500',
            'contact_number' => 'nullable|string|max:50',
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'nullable|email|max:255',
            'barangay_id' => 'required|exists:barangays,barangay_id',
            'status' => 'nullable|in:active,inactive,suspended,pending',
            'business_type' => 'nullable|string|max:100',
            'capacity' => 'nullable|string|max:100',
            'operations_start' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = $validated['status'] ?? 'pending';

        // Generate permit number if not provided
        if (empty($validated['permit_no'])) {
            $prefix = match($validated['type']) {
                'poultry' => 'POUL',
                'livestock_facility' => 'LSTK',
                'meat_shop' => 'MTST',
                'pet_shop' => 'PTST',
                'vet_clinic' => 'VET',
                default => 'EST',
            };
            $validated['permit_no'] = $prefix . '-' . date('Y') . '-' . str_pad(Establishment::count() + 1, 5, '0', STR_PAD_LEFT);
        }

        Establishment::create($validated);

        return redirect()->route('admin-asst.business-profiles.index')
            ->with('success', 'Business profile created successfully!');
    }

    /**
     * Display the specified business profile.
     */
    public function show(Establishment $businessProfile)
    {
        $businessProfile->load('barangay', 'user', 'inspections');
        
        return view('admin-asst.business-profiles.show', compact('businessProfile'));
    }

    /**
     * Show the form for editing the specified business profile.
     */
    public function edit(Establishment $businessProfile)
    {
        $barangays = Barangay::orderBy('barangay_name')->get();
        $users = User::orderBy('name')->get();
        
        return view('admin-asst.business-profiles.edit', compact('businessProfile', 'barangays', 'users'));
    }

    /**
     * Update the specified business profile.
     */
    public function update(Request $request, Establishment $businessProfile)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:poultry,livestock_facility,meat_shop,pet_shop,vet_clinic,other',
            'permit_no' => 'nullable|string|max:255',
            'address' => 'required|string|max:500',
            'contact_number' => 'nullable|string|max:50',
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'nullable|email|max:255',
            'barangay_id' => 'required|exists:barangays,barangay_id',
            'status' => 'nullable|in:active,inactive,suspended,pending',
            'business_type' => 'nullable|string|max:100',
            'capacity' => 'nullable|string|max:100',
            'operations_start' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $businessProfile->update($validated);

        return redirect()->route('admin-asst.business-profiles.show', $businessProfile)
            ->with('success', 'Business profile updated successfully!');
    }

    /**
     * Remove the specified business profile.
     */
    public function destroy(Establishment $businessProfile)
    {
        $businessProfile->delete();

        return redirect()->route('admin-asst.business-profiles.index')
            ->with('success', 'Business profile deleted successfully!');
    }

    /**
     * Approve/activate a business profile.
     */
    public function approve(Establishment $businessProfile)
    {
        $businessProfile->update(['status' => 'active']);

        return redirect()->back()->with('success', 'Business profile approved and activated!');
    }

    /**
     * Suspend a business profile.
     */
    public function suspend(Establishment $businessProfile)
    {
        $businessProfile->update(['status' => 'suspended']);

        return redirect()->back()->with('success', 'Business profile suspended.');
    }

    /**
     * Get statistics for dashboard.
     */
    public function stats()
    {
        $stats = [
            'total' => Establishment::count(),
            'poultry' => Establishment::where('type', 'poultry')->count(),
            'livestock_facility' => Establishment::where('type', 'livestock_facility')->count(),
            'active' => Establishment::where('status', 'active')->count(),
            'pending' => Establishment::where('status', 'pending')->count(),
            'suspended' => Establishment::where('status', 'suspended')->count(),
            'by_barangay' => Establishment::select('barangay_id', DB::raw('count(*) as count'))
                ->groupBy('barangay_id')
                ->with('barangay')
                ->get()
                ->map(fn($item) => [
                    'barangay' => $item->barangay?->barangay_name ?? 'Unknown',
                    'count' => $item->count
                ])
                ->toArray(),
        ];

        return response()->json($stats);
    }

    /**
     * Export business profiles to CSV.
     */
    public function export(Request $request)
    {
        $query = Establishment::with('barangay');

        // Apply filters
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('barangay_id')) {
            $query->where('barangay_id', $request->barangay_id);
        }

        $establishments = $query->get();

        $csv = "ID,Name,Type,Permit No,Owner,Address,Barangay,Status,Created At\n";
        foreach ($establishments as $est) {
            $csv .= "{$est->id},\"{$est->name}\",{$est->type},{$est->permit_no},\"{$est->owner_name}\",\"{$est->address}\",\"{$est->barangay?->barangay_name}\",{$est->status},{$est->created_at}\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="business-profiles-' . date('Y-m-d') . '.csv"');
    }
}
