<?php

namespace App\Http\Controllers\AdminAsst;

use App\Http\Controllers\Controller;
use App\Models\FormSubmission;
use App\Models\ServiceForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of appointment/service requests.
     */
    public function index(Request $request)
    {
        $query = FormSubmission::with('form', 'submitter');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by form type
        if ($request->filled('form_type')) {
            $query->whereHas('form', function($q) use ($request) {
                $q->where('form_type', $request->form_type);
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('submitted_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('submitted_at', '<=', $request->date_to);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('citizen_name', 'like', '%' . $search . '%')
                  ->orWhere('citizen_contact', 'like', '%' . $search . '%')
                  ->orWhere('submitted_by_user_id', 'like', '%' . $search . '%');
            });
        }

        $submissions = $query->orderBy('submitted_at', 'desc')->paginate(15);
        $serviceForms = ServiceForm::where('is_active', true)->orderBy('title')->get();

        // Statistics
        $pendingCount = FormSubmission::where('status', 'pending')->count();
        $approvedCount = FormSubmission::where('status', 'approved')->count();
        $rejectedCount = FormSubmission::where('status', 'rejected')->count();
        $todayCount = FormSubmission::whereDate('submitted_at', now()->toDateString())->count();

        return view('admin-asst.appointments.index', compact(
            'submissions',
            'serviceForms',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'todayCount'
        ));
    }

    /**
     * Display the specified appointment request.
     */
    public function show(FormSubmission $appointment)
    {
        $appointment->load('form', 'submitter', 'reviewer');
        
        return view('admin-asst.appointments.show', compact('appointment'));
    }

    /**
     * Approve an appointment request.
     */
    public function approve(Request $request, FormSubmission $appointment)
    {
        $validated = $request->validate([
            'review_notes' => 'nullable|string|max:1000',
        ]);

        $appointment->update([
            'status' => 'approved',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'review_notes' => $validated['review_notes'] ?? 'Approved by Admin Assistant',
        ]);

        return redirect()->back()->with('success', 'Appointment request approved successfully!');
    }

    /**
     * Reject an appointment request.
     */
    public function reject(Request $request, FormSubmission $appointment)
    {
        $validated = $request->validate([
            'review_notes' => 'nullable|string|max:1000',
        ]);

        $appointment->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'review_notes' => $validated['review_notes'] ?? 'Rejected by Admin Assistant',
        ]);

        return redirect()->back()->with('success', 'Appointment request rejected.');
    }

    /**
     * Mark appointment as completed.
     */
    public function complete(FormSubmission $appointment)
    {
        $appointment->update([
            'status' => 'completed',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Appointment marked as completed!');
    }

    /**
     * Reset appointment status to pending.
     */
    public function reset(FormSubmission $appointment)
    {
        $appointment->update([
            'status' => 'pending',
            'reviewed_by' => null,
            'reviewed_at' => null,
            'review_notes' => null,
        ]);

        return redirect()->back()->with('success', 'Appointment status reset to pending.');
    }

    /**
     * Bulk approve appointments.
     */
    public function bulkApprove(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:form_submissions,id',
        ]);

        $count = FormSubmission::whereIn('id', $validated['ids'])
            ->where('status', 'pending')
            ->update([
                'status' => 'approved',
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
            ]);

        return redirect()->back()->with('success', $count . ' appointment(s) approved successfully!');
    }

    /**
     * Get statistics for dashboard.
     */
    public function stats()
    {
        $stats = [
            'pending' => FormSubmission::where('status', 'pending')->count(),
            'approved' => FormSubmission::where('status', 'approved')->count(),
            'rejected' => FormSubmission::where('status', 'rejected')->count(),
            'completed' => FormSubmission::where('status', 'completed')->count(),
            'today' => FormSubmission::whereDate('submitted_at', now()->toDateString())->count(),
            'by_type' => FormSubmission::with('form')
                ->get()
                ->groupBy('form.form_type')
                ->map->count()
                ->toArray(),
        ];

        return response()->json($stats);
    }
}
