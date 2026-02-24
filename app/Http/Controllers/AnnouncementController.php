<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    /**
     * Check if user is admin or super_admin
     */
    private function isAdmin()
    {
        $user = Auth::user();
        return $user && in_array($user->role, ['super_admin', 'admin']);
    }

    /**
     * Get redirect route based on user role
     */
    private function getAdminRedirectRoute()
    {
        return Auth::user()->role === 'super_admin'
            ? 'super-admin.announcements.index'
            : 'admin.announcements.index';
    }

    /**
     * Show announcements page for citizens.
     */
    public function index()
    {
        $announcements = Announcement::where('is_active', true)
            ->latest()
            ->paginate(10);

        return view('announcements.index', compact('announcements'));
    }

    /**
     * Show public announcements for all authenticated users (non-admin).
     */
    public function publicIndex()
    {
        $announcements = Announcement::where('is_active', true)
            ->latest()
            ->paginate(10);

        return view('announcements.public-index', compact('announcements'));
    }

    /**
     * Mark recent announcements as read for the current user.
     * This is called via AJAX when opening the notification dropdown.
     */
    public function markAsRead()
    {
        $recentAnnouncements = Announcement::where('is_active', true)
            ->where('created_at', '>=', now()->subDays(7))
            ->get();

        $markedCount = 0;
        foreach ($recentAnnouncements as $announcement) {
            $alreadyRead = \App\Models\AnnouncementRead::where('announcement_id', $announcement->id)
                ->where('user_id', Auth::id())
                ->exists();

            if (!$alreadyRead) {
                \App\Models\AnnouncementRead::create([
                    'announcement_id' => $announcement->id,
                    'user_id' => Auth::id(),
                    'read_at' => now(),
                ]);
                $markedCount++;
            }
        }

        return response()->json([
            'success' => true,
            'marked_count' => $markedCount,
            'message' => 'Announcements marked as read'
        ]);
    }

    /**
     * Show the form for creating a new announcement.
     * Only admin and super_admin can access.
     */
    public function create()
    {
        if (!$this->isAdmin()) {
            return redirect()->route('announcements.index')
                ->with('error', 'You do not have permission to create announcements.');
        }

        return view('announcements.create');
    }

    /**
     * Store a newly created announcement.
     * Only admin and super_admin can create.
     */
    public function store(Request $request)
    {
        if (!$this->isAdmin()) {
            return redirect()->route('announcements.index')
                ->with('error', 'You do not have permission to create announcements.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|string|in:info,alert,reminder,update',
            'status' => 'nullable|string|in:draft,published',
            'content' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'event_date' => 'nullable|date',
            'event_time' => 'nullable',
            'location' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'organized_by' => 'nullable|string|max:255',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('announcements', 'public');
        }

        Announcement::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'type' => $validated['type'] ?? 'info',
            'status' => $validated['status'] ?? 'published',
            'description' => $validated['content'],
            'photo_path' => $photoPath,
            'event_date' => $validated['event_date'] ?? null,
            'event_time' => $validated['event_time'] ?? null,
            'location' => $validated['location'] ?? null,
            'contact_number' => $validated['contact_number'] ?? null,
            'organized_by' => $validated['organized_by'] ?? null,
            'is_active' => ($validated['status'] ?? 'published') === 'published',
        ]);

        return redirect()->route($this->getAdminRedirectRoute())
            ->with('success', 'Announcement posted successfully!');
    }

    /**
     * List all announcements (admin view).
     */
    public function list()
    {
        if (!$this->isAdmin()) {
            return redirect()->route('announcements.index')
                ->with('error', 'You do not have permission to view this page.');
        }

        $announcements = Announcement::with('user')
            ->latest()
            ->paginate(10);

        return view('announcements.list', compact('announcements'));
    }

    /**
     * Show a single announcement.
     */
    public function show(Announcement $announcement)
    {
        return view('announcements.show', compact('announcement'));
    }

    /**
     * Show the form for editing an announcement.
     * Only admin and super_admin can access.
     */
    public function edit(Announcement $announcement)
    {
        if (!$this->isAdmin()) {
            return redirect()->route('announcements.index')
                ->with('error', 'You do not have permission to edit announcements.');
        }

        return view('announcements.edit', compact('announcement'));
    }

    /**
     * Update an announcement.
     * Only admin and super_admin can update.
     */
    public function update(Request $request, Announcement $announcement)
    {
        if (!$this->isAdmin()) {
            return redirect()->route('announcements.index')
                ->with('error', 'You do not have permission to edit announcements.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|string|in:info,alert,reminder,update',
            'status' => 'nullable|string|in:draft,published',
            'content' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'event_date' => 'nullable|date',
            'event_time' => 'nullable',
            'location' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'organized_by' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($announcement->photo_path) {
                Storage::disk('public')->delete($announcement->photo_path);
            }
            $photoPath = $request->file('photo')->store('announcements', 'public');
            $validated['photo_path'] = $photoPath;
        }

        // Map form fields to database fields
        $updateData = [
            'title' => $validated['title'],
            'type' => $validated['type'] ?? 'info',
            'status' => $validated['status'] ?? 'published',
            'description' => $validated['content'],
            'event_date' => $validated['event_date'] ?? null,
            'event_time' => $validated['event_time'] ?? null,
            'location' => $validated['location'] ?? null,
            'contact_number' => $validated['contact_number'] ?? null,
            'organized_by' => $validated['organized_by'] ?? null,
            'is_active' => ($validated['status'] ?? 'published') === 'published',
        ];

        if (isset($validated['photo_path'])) {
            $updateData['photo_path'] = $validated['photo_path'];
        }

        $announcement->update($updateData);

        return redirect()->route($this->getAdminRedirectRoute())
            ->with('success', 'Announcement updated successfully!');
    }

    /**
     * Delete an announcement.
     * Only admin and super_admin can delete.
     */
    public function destroy(Announcement $announcement)
    {
        if (!$this->isAdmin()) {
            return redirect()->route('announcements.index')
                ->with('error', 'You do not have permission to delete announcements.');
        }

        // Delete photo if exists
        if ($announcement->photo_path) {
            Storage::disk('public')->delete($announcement->photo_path);
        }

        $announcement->delete();

        return redirect()->route($this->getAdminRedirectRoute())
            ->with('success', 'Announcement deleted successfully!');
    }
}
