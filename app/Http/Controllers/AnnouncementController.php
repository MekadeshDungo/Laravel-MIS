<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    /**
     * Check if user can manage announcements (create/edit/delete).
     * Roles: super_admin, city_vet, admin_staff can manage
     */
    private function canManage()
    {
        $user = Auth::user();
        return $user && in_array($user->role, ['super_admin', 'city_vet', 'admin_staff']);
    }

    /**
     * Check if user can view all announcements (admin view).
     */
    private function canViewAll()
    {
        $user = Auth::user();
        return $user && !in_array($user->role, ['citizen']);
    }

    /**
     * Get redirect route based on user role
     */
    private function getAdminRedirectRoute()
    {
        $role = Auth::user()->role;
        return match($role) {
            'super_admin' => 'super-admin.announcements.index',
            'city_vet' => 'admin.announcements.index',
            'admin_staff' => 'admin-staff.announcements.index',
            default => 'announcements.portal.index',
        };
    }

    /**
     * Show announcements list (public/citizen view).
     * Only show: status = Published, publish_date <= now, (expiry_date is null OR expiry_date >= now)
     */
    public function index()
    {
        // Get published announcements (visible to public)
        $announcements = Announcement::published()
            ->orderedByPriority()
            ->orderBy('publish_date', 'desc')
            ->paginate(10);

        return view('announcements.index', compact('announcements'));
    }

    /**
     * Show announcements for authenticated users (non-citizen portal).
     */
    public function publicIndex()
    {
        // If user can manage, show all (including drafts)
        if ($this->canManage()) {
            $announcements = Announcement::with('user')
                ->orderedByPriority()
                ->orderBy('publish_date', 'desc')
                ->paginate(10);
        } else {
            // Show only published (visible) announcements
            $announcements = Announcement::published()
                ->orderedByPriority()
                ->orderBy('publish_date', 'desc')
                ->paginate(10);
        }

        return view('announcements.public-index', compact('announcements'));
    }

    /**
     * Show a single announcement (public view).
     */
    public function show(Announcement $announcement)
    {
        // Check if user can view this announcement
        $user = Auth::user();
        
        // If announcement is not visible (not published or expired)
        if (!$announcement->isVisible()) {
            // Only admins can view unpublished/archived
            if (!$this->canManage()) {
                return redirect()->route('announcements.index')
                    ->with('error', 'This announcement is not available.');
            }
        }

        return view('announcements.show', compact('announcement'));
    }

    /**
     * Show the form for creating a new announcement.
     * Only admin roles can access.
     */
    public function create()
    {
        if (!$this->canManage()) {
            return redirect()->route('announcements.index')
                ->with('error', 'You do not have permission to create announcements.');
        }

        return view('announcements.create');
    }

    /**
     * Store a newly created announcement.
     */
    public function store(Request $request)
    {
        if (!$this->canManage()) {
            return redirect()->route('announcements.index')
                ->with('error', 'You do not have permission to create announcements.');
        }

        // Validation rules
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:' . implode(',', Announcement::getTypes()),
            'audience' => 'required|string|in:' . implode(',', Announcement::getAudiences()),
            'priority' => 'required|string|in:' . implode(',', Announcement::getPriorities()),
            'status' => 'required|string|in:' . implode(',', Announcement::getStatuses()),
            'publish_date' => 'required|date',
            'expiry_date' => 'nullable|date|after_or_equal:publish_date',
            'content' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'attachment' => 'nullable|mimes:pdf|max:5120',
        ]);

        // Handle file uploads
        $imagePath = null;
        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('announcements', 'public');
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('announcements', 'public');
        }

        // Create announcement with created_by = Auth::id()
        Announcement::create([
            'user_id' => Auth::id(), // created_by
            'title' => $validated['title'],
            'type' => $validated['type'],
            'audience' => $validated['audience'],
            'priority' => $validated['priority'],
            'status' => $validated['status'],
            'publish_date' => $validated['publish_date'],
            'expiry_date' => $validated['expiry_date'] ?? null,
            'content' => $validated['content'],
            'image_path' => $imagePath,
            'attachment_path' => $attachmentPath,
            'is_active' => $validated['status'] === 'Published',
        ]);

        return redirect()->route($this->getAdminRedirectRoute())
            ->with('success', 'Announcement created successfully!');
    }

    /**
     * Show the form for editing an announcement.
     */
    public function edit(Announcement $announcement)
    {
        if (!$this->canManage()) {
            return redirect()->route('announcements.index')
                ->with('error', 'You do not have permission to edit announcements.');
        }

        return view('announcements.edit', compact('announcement'));
    }

    /**
     * Update an announcement.
     */
    public function update(Request $request, Announcement $announcement)
    {
        if (!$this->canManage()) {
            return redirect()->route('announcements.index')
                ->with('error', 'You do not have permission to edit announcements.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:' . implode(',', Announcement::getTypes()),
            'audience' => 'required|string|in:' . implode(',', Announcement::getAudiences()),
            'priority' => 'required|string|in:' . implode(',', Announcement::getPriorities()),
            'status' => 'required|string|in:' . implode(',', Announcement::getStatuses()),
            'publish_date' => 'required|date',
            'expiry_date' => 'nullable|date|after_or_equal:publish_date',
            'content' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'attachment' => 'nullable|mimes:pdf|max:5120',
        ]);

        // Handle image upload
        $imagePath = $announcement->image_path;
        if ($request->hasFile('photo')) {
            // Delete old image if exists
            if ($announcement->image_path) {
                Storage::disk('public')->delete($announcement->image_path);
            }
            $imagePath = $request->file('photo')->store('announcements', 'public');
        }

        // Handle attachment upload
        $attachmentPath = $announcement->attachment_path;
        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($announcement->attachment_path) {
                Storage::disk('public')->delete($announcement->attachment_path);
            }
            $attachmentPath = $request->file('attachment')->store('announcements', 'public');
        }

        // Update announcement
        $announcement->update([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'audience' => $validated['audience'],
            'priority' => $validated['priority'],
            'status' => $validated['status'],
            'publish_date' => $validated['publish_date'],
            'expiry_date' => $validated['expiry_date'] ?? null,
            'content' => $validated['content'],
            'image_path' => $imagePath,
            'attachment_path' => $attachmentPath,
            'is_active' => $validated['status'] === 'Published',
        ]);

        return redirect()->route($this->getAdminRedirectRoute())
            ->with('success', 'Announcement updated successfully!');
    }

    /**
     * Delete an announcement.
     */
    public function destroy(Announcement $announcement)
    {
        if (!$this->canManage()) {
            return redirect()->route('announcements.index')
                ->with('error', 'You do not have permission to delete announcements.');
        }

        // Delete associated files
        if ($announcement->image_path) {
            Storage::disk('public')->delete($announcement->image_path);
        }
        if ($announcement->attachment_path) {
            Storage::disk('public')->delete($announcement->attachment_path);
        }

        $announcement->delete();

        return redirect()->route($this->getAdminRedirectRoute())
            ->with('success', 'Announcement deleted successfully!');
    }

    /**
     * Mark recent announcements as read.
     */
    public function markAsRead()
    {
        $recentAnnouncements = Announcement::published()
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
     * List all announcements (admin view).
     */
    public function list()
    {
        if (!$this->canManage()) {
            return redirect()->route('announcements.index')
                ->with('error', 'You do not have permission to view this page.');
        }

        $announcements = Announcement::with('user')
            ->orderedByPriority()
            ->orderBy('publish_date', 'desc')
            ->paginate(10);

        return view('announcements.list', compact('announcements'));
    }

    /**
     * API: Get published announcements (for mobile/public API).
     */
    public function apiPublished()
    {
        $announcements = Announcement::published()
            ->orderedByPriority()
            ->orderBy('publish_date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $announcements
        ]);
    }
}
