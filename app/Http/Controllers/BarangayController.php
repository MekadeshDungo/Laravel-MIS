<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Barangay;
use App\Models\BarangayUser;
use App\Models\StrayReport;
use App\Models\ImpoundRecord;
use App\Models\AdoptionRequest;
use App\Models\Notification;

class BarangayController extends Controller
{
    /**
     * Show barangay dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get barangay user info
        $barangayUser = BarangayUser::where('user_id', $user->id)->first();
        
        if (!$barangayUser) {
            return redirect()->route('login')->with('error', 'You are not assigned to any barangay.');
        }
        
        $barangay = $barangayUser->barangay;
        
        // Get statistics
        $stats = [
            'total_reports' => StrayReport::where('barangay_id', $barangay->barangay_id)->count(),
            'new_reports' => StrayReport::where('barangay_id', $barangay->barangay_id)->where('report_status', 'new')->count(),
            'responding' => StrayReport::where('barangay_id', $barangay->barangay_id)->where('report_status', 'responding')->count(),
            'closed' => StrayReport::where('barangay_id', $barangay->barangay_id)->where('report_status', 'closed')->count(),
            'impounded' => ImpoundRecord::whereHas('strayReport', function($q) use ($barangay) {
                $q->where('barangay_id', $barangay->barangay_id);
            })->count(),
            'pending_adoptions' => AdoptionRequest::whereHas('impound.strayReport', function($q) use ($barangay) {
                $q->where('barangay_id', $barangay->barangay_id);
            })->where('request_status', 'pending')->count(),
        ];
        
        // Get recent reports
        $recentReports = StrayReport::where('barangay_id', $barangay->barangay_id)
            ->latest()
            ->take(5)
            ->get();
        
        // Get unread notifications
        $notifications = Notification::where('barangay_user_id', $barangayUser->barangay_user_id)
            ->where('is_read', false)
            ->latest()
            ->take(5)
            ->get();
        
        return view('barangay.dashboard', compact('user', 'barangay', 'barangayUser', 'stats', 'recentReports', 'notifications'));
    }

    /**
     * Show data entry page.
     */
    public function showDataEntry()
    {
        return view('barangay.data-entry');
    }

    /**
     * List all stray reports.
     */
    public function indexStrayReports()
    {
        $user = Auth::user();
        $barangayUser = BarangayUser::where('user_id', $user->id)->first();
        
        if (!$barangayUser) {
            return redirect()->route('login')->with('error', 'You are not assigned to any barangay.');
        }
        
        $reports = StrayReport::where('barangay_id', $barangayUser->barangay_id)
            ->latest()
            ->paginate(10);
        
        return view('barangay.reports.index', compact('reports'));
    }

    /**
     * Show create stray report form.
     */
    public function createStrayReport()
    {
        return view('barangay.reports.create');
    }

    /**
     * Store new stray report.
     */
    public function storeStrayReport(Request $request)
    {
        $user = Auth::user();
        $barangayUser = BarangayUser::where('user_id', $user->id)->first();
        
        if (!$barangayUser) {
            return redirect()->back()->with('error', 'You are not assigned to any barangay.');
        }
        
        $validated = $request->validate([
            'report_type' => 'required|in:stray,nuisance,injured',
            'species' => 'required|in:dog,cat,other',
            'description' => 'nullable|string',
            'location_text' => 'nullable|string|max:255',
            'street_address' => 'nullable|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'urgency_level' => 'required|in:low,medium,high',
        ]);
        
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('stray-reports', 'public');
        }
        
        $report = StrayReport::create([
            'barangay_id' => $barangayUser->barangay_id,
            'reported_by_user_id' => $user->id,
            'report_type' => $validated['report_type'],
            'species' => $validated['species'],
            'description' => $validated['description'] ?? null,
            'location_text' => $validated['location_text'] ?? null,
            'street_address' => $validated['street_address'] ?? null,
            'landmark' => $validated['landmark'] ?? null,
            'image_path' => $imagePath,
            'urgency_level' => $validated['urgency_level'],
            'report_status' => 'new',
            'reported_at' => now(),
        ]);
        
        return redirect()->route('barangay.reports.index')->with('success', 'Stray report submitted successfully!');
    }

    /**
     * Show impound records.
     */
    public function indexImpoundRecords()
    {
        $user = Auth::user();
        $barangayUser = BarangayUser::where('user_id', $user->id)->first();
        
        if (!$barangayUser) {
            return redirect()->route('login')->with('error', 'You are not assigned to any barangay.');
        }
        
        $impounds = ImpoundRecord::whereHas('strayReport', function($q) use ($barangayUser) {
            $q->where('barangay_id', $barangayUser->barangay_id);
        })->latest()->paginate(10);
        
        return view('barangay.impounds.index', compact('impounds'));
    }

    /**
     * Show adoption requests.
     */
    public function indexAdoptionRequests()
    {
        $user = Auth::user();
        $barangayUser = BarangayUser::where('user_id', $user->id)->first();
        
        if (!$barangayUser) {
            return redirect()->route('login')->with('error', 'You are not assigned to any barangay.');
        }
        
        $adoptions = AdoptionRequest::whereHas('impound.strayReport', function($q) use ($barangayUser) {
            $q->where('barangay_id', $barangayUser->barangay_id);
        })->latest()->paginate(10);
        
        return view('barangay.adoptions.index', compact('adoptions'));
    }

    /**
     * Show notifications.
     */
    public function indexNotifications()
    {
        $user = Auth::user();
        $barangayUser = BarangayUser::where('user_id', $user->id)->first();
        
        if (!$barangayUser) {
            return redirect()->route('login')->with('error', 'You are not assigned to any barangay.');
        }
        
        $notifications = Notification::where('barangay_user_id', $barangayUser->barangay_user_id)
            ->latest()
            ->paginate(10);
        
        return view('barangay.notifications.index', compact('notifications'));
    }

    /**
     * Mark notification as read.
     */
    public function markNotificationRead(Notification $notification)
    {
        $user = Auth::user();
        $barangayUser = BarangayUser::where('user_id', $user->id)->first();
        
        if (!$barangayUser) {
            return redirect()->route('login')->with('error', 'You are not assigned to any barangay.');
        }
        
        // Verify the notification belongs to this user
        if ($notification->barangay_user_id !== $barangayUser->barangay_user_id) {
            return redirect()->back()->with('error', 'Notification not found.');
        }
        
        $notification->markAsRead();
        
        return redirect()->back();
    }
}
