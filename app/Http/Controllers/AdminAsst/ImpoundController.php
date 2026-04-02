<?php

namespace App\Http\Controllers\AdminAsst;

use App\Http\Controllers\Controller;
use App\Models\ImpoundRecord;
use App\Models\ImpoundStatusHistory;
use App\Models\Barangay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpoundController extends Controller
{
    /**
     * Display a listing of impounded animals.
     */
    public function index(Request $request)
    {
        $query = ImpoundRecord::with('strayReport');

        // Filter by disposition
        if ($request->filled('disposition')) {
            $query->where('current_disposition', $request->disposition);
        }

        // Filter by barangay
        if ($request->filled('barangay_id')) {
            $query->where('barangay_id', $request->barangay_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('animal_tag_code', 'like', '%' . $search . '%')
                  ->orWhere('intake_location', 'like', '%' . $search . '%')
                  ->orWhere('intake_condition', 'like', '%' . $search . '%');
            });
        }

        $impounds = $query->orderBy('intake_date', 'desc')->paginate(15);
        $barangays = Barangay::orderBy('barangay_name')->get();

        // Statistics
        $totalCount = ImpoundRecord::count();
        $impoundedCount = ImpoundRecord::where('current_disposition', 'impounded')->count();
        $claimedCount = ImpoundRecord::where('current_disposition', 'claimed')->count();
        $adoptedCount = ImpoundRecord::where('current_disposition', 'adopted')->count();

        return view('admin-asst.impounds.index', compact(
            'impounds',
            'barangays',
            'totalCount',
            'impoundedCount',
            'claimedCount',
            'adoptedCount'
        ));
    }

    /**
     * Display the specified impound record.
     */
    public function show(ImpoundRecord $impound)
    {
        $impound->load('strayReport', 'statusHistory', 'adoptionRequests');
        
        return view('admin-asst.impounds.show', compact('impound'));
    }

    /**
     * Update impound disposition.
     */
    public function updateDisposition(Request $request, ImpoundRecord $impound)
    {
        $validated = $request->validate([
            'current_disposition' => 'required|in:impounded,claimed,adopted,transferred,euthanized',
            'notes' => 'nullable|string|max:500',
        ]);

        $oldDisposition = $impound->current_disposition;
        
        $impound->update([
            'current_disposition' => $validated['current_disposition'],
        ]);

        // Create status history
        ImpoundStatusHistory::create([
            'impound_id' => $impound->impound_id,
            'status' => $validated['current_disposition'],
            'changed_by' => Auth::id(),
            'change_date' => now(),
            'notes' => $validated['notes'] ?? 'Disposition updated from ' . $oldDisposition . ' to ' . $validated['current_disposition'],
        ]);

        return redirect()->back()->with('success', 'Impound disposition updated successfully!');
    }

    /**
     * Get statistics.
     */
    public function stats()
    {
        $stats = [
            'total' => ImpoundRecord::count(),
            'impounded' => ImpoundRecord::where('current_disposition', 'impounded')->count(),
            'claimed' => ImpoundRecord::where('current_disposition', 'claimed')->count(),
            'adopted' => ImpoundRecord::where('current_disposition', 'adopted')->count(),
            'transferred' => ImpoundRecord::where('current_disposition', 'transferred')->count(),
            'euthanized' => ImpoundRecord::where('current_disposition', 'euthanized')->count(),
        ];

        return response()->json($stats);
    }
}
