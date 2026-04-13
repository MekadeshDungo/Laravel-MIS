<?php

namespace App\Http\Controllers\AdminAsst;

use App\Http\Controllers\Controller;
use App\Models\AdoptionRequest;
use App\Models\AdoptionStatusHistory;
use App\Models\ImpoundRecord;
use App\Models\StrayReport;
use App\Models\Barangay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdoptionController extends Controller
{
    /**
     * Display a listing of adoption requests.
     */
    public function index(Request $request)
    {
        $query = AdoptionRequest::with('impound');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('request_status', $request->status);
        }

        // Filter by barangay
        if ($request->filled('barangay_id')) {
            $query->whereHas('impound', function($q) use ($request) {
                $q->where('barangay_id', $request->barangay_id);
            });
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('adopter_name', 'like', '%' . $search . '%')
                  ->orWhere('adopter_contact', 'like', '%' . $search . '%')
                  ->orWhere('address', 'like', '%' . $search . '%');
            });
        }

        $adoptions = $query->orderBy('requested_at', 'desc')->paginate(15);
        $barangays = Barangay::orderBy('barangay_name')->get();

        // Statistics
        $totalCount = AdoptionRequest::count();
        $pendingCount = AdoptionRequest::where('request_status', 'pending')->count();
        $approvedCount = AdoptionRequest::where('request_status', 'approved')->count();
        $rejectedCount = AdoptionRequest::where('request_status', 'rejected')->count();
        $completedCount = AdoptionRequest::where('request_status', 'completed')->count();

        return view('admin-asst.adoptions.index', compact(
            'adoptions',
            'barangays',
            'totalCount',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'completedCount'
        ));
    }

    /**
     * Display the specified adoption request.
     */
    public function show(AdoptionRequest $adoption)
    {
        $adoption->load('impound.strayReport', 'statusHistory');
        
        return view('admin-asst.adoptions.show', compact('adoption'));
    }

    /**
     * Show the form for creating a new adoption request.
     */
    public function create(Request $request)
    {
        $availableImpounds = ImpoundRecord::where('current_disposition', 'impounded')
            ->with('strayReport')
            ->orderBy('intake_date', 'desc')
            ->get();

        $barangays = Barangay::orderBy('barangay_name')->get();

        return view('admin-asst.adoptions.create', compact('availableImpounds', 'barangays'));
    }

    /**
     * Store a newly created adoption request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'impound_id' => 'required|exists:impounds,impound_id',
            'adopter_name' => 'required|string|max:255',
            'adopter_contact' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'occupation' => 'nullable|string|max:255',
            'housing_type' => 'nullable|string|max:100',
            'has_other_pets' => 'nullable|boolean',
            'other_pets_details' => 'nullable|string',
            'previous_experience' => 'nullable|string',
            'reason_for_adoption' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $validated['requested_at'] = now();
        $validated['request_status'] = 'pending';

        $adoption = AdoptionRequest::create($validated);

        // Create initial status history
        AdoptionStatusHistory::create([
            'adoption_request_id' => $adoption->adoption_request_id,
            'status' => 'pending',
            'changed_by' => Auth::id(),
            'change_date' => now(),
            'notes' => 'Adoption request submitted.',
        ]);

        return redirect()->route('admin-asst.adoptions.show', $adoption)
            ->with('success', 'Adoption request submitted successfully!');
    }

    /**
     * Approve an adoption request.
     */
    public function approve(Request $request, AdoptionRequest $adoption)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::transaction(function () use ($adoption, $validated) {
            // Update adoption status
            $adoption->update([
                'request_status' => 'approved',
            ]);

            // Update impound disposition
            $adoption->impound->update([
                'current_disposition' => 'adopted',
            ]);

            // Create status history
            AdoptionStatusHistory::create([
                'adoption_request_id' => $adoption->adoption_request_id,
                'status' => 'approved',
                'changed_by' => Auth::id(),
                'change_date' => now(),
                'notes' => $validated['notes'] ?? 'Adoption request approved.',
            ]);
        });

        return redirect()->back()->with('success', 'Adoption request approved! Impound record updated.');
    }

    /**
     * Reject an adoption request.
     */
    public function reject(Request $request, AdoptionRequest $adoption)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        $adoption->update([
            'request_status' => 'rejected',
        ]);

        // Create status history
        AdoptionStatusHistory::create([
            'adoption_request_id' => $adoption->adoption_request_id,
            'status' => 'rejected',
            'changed_by' => Auth::id(),
            'change_date' => now(),
            'notes' => $validated['notes'] ?? 'Adoption request rejected.',
        ]);

        return redirect()->back()->with('success', 'Adoption request rejected.');
    }

    /**
     * Mark adoption as completed.
     */
    public function complete(Request $request, AdoptionRequest $adoption)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        $adoption->update([
            'request_status' => 'completed',
        ]);

        // Create status history
        AdoptionStatusHistory::create([
            'adoption_request_id' => $adoption->adoption_request_id,
            'status' => 'completed',
            'changed_by' => Auth::id(),
            'change_date' => now(),
            'notes' => $validated['notes'] ?? 'Adoption process completed. Animal delivered to adopter.',
        ]);

        return redirect()->back()->with('success', 'Adoption marked as completed!');
    }

    /**
     * Reset adoption status to pending.
     */
    public function reset(AdoptionRequest $adoption)
    {
        $adoption->update([
            'request_status' => 'pending',
        ]);

        // Reset impound disposition if previously approved
        if ($adoption->impound && $adoption->getOriginal('request_status') === 'approved') {
            $adoption->impound->update([
                'current_disposition' => 'impounded',
            ]);
        }

        // Create status history
        AdoptionStatusHistory::create([
            'adoption_request_id' => $adoption->adoption_request_id,
            'status' => 'pending',
            'changed_by' => Auth::id(),
            'change_date' => now(),
            'notes' => 'Adoption request reset to pending.',
        ]);

        return redirect()->back()->with('success', 'Adoption status reset to pending.');
    }

    /**
     * Get statistics for dashboard.
     */
    public function stats()
    {
        $stats = [
            'total' => AdoptionRequest::count(),
            'pending' => AdoptionRequest::where('request_status', 'pending')->count(),
            'approved' => AdoptionRequest::where('request_status', 'approved')->count(),
            'rejected' => AdoptionRequest::where('request_status', 'rejected')->count(),
            'completed' => AdoptionRequest::where('request_status', 'completed')->count(),
            'available_for_adoption' => ImpoundRecord::where('current_disposition', 'impounded')->count(),
        ];

        return response()->json($stats);
    }
}
