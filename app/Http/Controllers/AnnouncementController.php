<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
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
     * Show the form for creating a new announcement.
     */
    public function create()
    {
        return view('announcements.create');
    }

    /**
     * Store a newly created announcement.
     */
    public function store(Request $request)
    {
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

        // Determine redirect route based on user role
        $redirectRoute = Auth::user()->role === 'super_admin' 
            ? 'super-admin.announcements.index' 
            : 'admin.announcements.index';

        return redirect()->route($redirectRoute)
            ->with('success', 'Announcement posted successfully!');
    }

    /**
     * List all announcements (admin view).
     */
    public function list()
    {
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
     */
    public function edit(Announcement $announcement)
    {
        return view('announcements.edit', compact('announcement'));
    }

    /**
     * Update an announcement.
     */
    public function update(Request $request, Announcement $announcement)
    {
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

        // Determine redirect route based on user role
        $redirectRoute = Auth::user()->role === 'super_admin' 
            ? 'super-admin.announcements.index' 
            : 'admin.announcements.index';

        return redirect()->route($redirectRoute)
            ->with('success', 'Announcement updated successfully!');
    }

    /**
     * Delete an announcement.
     */
    public function destroy(Announcement $announcement)
    {
        // Delete photo if exists
        if ($announcement->photo_path) {
            Storage::disk('public')->delete($announcement->photo_path);
        }
        
        $announcement->delete();

        // Determine redirect route based on user role
        $redirectRoute = Auth::user()->role === 'super_admin' 
            ? 'super-admin.announcements.index' 
            : 'admin.announcements.index';

        return redirect()->route($redirectRoute)
            ->with('success', 'Announcement deleted successfully!');
    }
}
