<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AnnouncementController extends Controller
{
    private function canManage()
    {
        $user = Auth::user();
        return $user && in_array($user->role, ['super_admin', 'city_vet', 'admin_asst', 'admin_staff']);
    }

    private function getAdminRedirectRoute()
    {
        $role = Auth::user()->role;
        return match($role) {
            'super_admin' => 'super-admin.announcements.index',
            'city_vet' => 'admin.announcements.index',
            'admin_asst', 'admin_staff' => 'admin-staff.announcements.index',
            default => 'announcements.public.index',
        };
    }

    public function index(Request $request)
    {
        $query = Announcement::with('createdBy');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $announcements = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('announcements.index', compact('announcements'));
    }

    public function campaigns(Request $request)
    {
        $query = Announcement::with('createdBy')
            ->where('category', 'campaign');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $campaigns = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('public.campaigns.index', compact('campaigns'));
    }

    public function events(Request $request)
    {
        $query = Announcement::with('createdBy')
            ->where('category', 'event');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $events = $query->orderBy('event_date', 'asc')->paginate(15);

        return view('public.events.index', compact('events'));
    }

    public function show(Announcement $announcement)
    {
        $announcement->load('createdBy');

        return view('announcements.show', compact('announcement'));
    }

    public function create()
    {
        return view('announcements.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:campaign,event',
            'is_active' => 'nullable|boolean',
            'event_date' => 'nullable|required_if:category,event|date',
            'event_time' => 'nullable',
            'location' => 'nullable|required_if:category,event|string|max:255',
            'contact_number' => 'nullable|string|max:15',
            'photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'attachment_path' => 'nullable|mimes:pdf|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $photoPath = null;
        if ($request->hasFile('photo_path')) {
            $photoPath = $request->file('photo_path')->store('announcements', 'public');
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment_path')) {
            $attachmentPath = $request->file('attachment_path')->store('announcements', 'public');
        }

        Announcement::create(array_merge(
            $validator->validated(),
            [
                'photo_path' => $photoPath,
                'attachment_path' => $attachmentPath,
                'created_by' => auth()->id(),
            ]
        ));

        \App\Services\NotificationService::announcementCreated(Announcement::latest()->first()->id);

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement created successfully.');
    }

    public function edit(Announcement $announcement)
    {
        return view('announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:campaign,event',
            'is_active' => 'nullable|boolean',
            'event_date' => 'nullable|required_if:category,event|date',
            'event_time' => 'nullable',
            'location' => 'nullable|required_if:category,event|string|max:255',
            'contact_number' => 'nullable|string|max:15',
            'photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'attachment_path' => 'nullable|mimes:pdf|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        if ($request->hasFile('photo_path')) {
            if ($announcement->photo_path) {
                Storage::disk('public')->delete($announcement->photo_path);
            }
            $data['photo_path'] = $request->file('photo_path')->store('announcements', 'public');
        }

        if ($request->hasFile('attachment_path')) {
            if ($announcement->attachment_path) {
                Storage::disk('public')->delete($announcement->attachment_path);
            }
            $data['attachment_path'] = $request->file('attachment_path')->store('announcements', 'public');
        }

        $announcement->update($data);

        return redirect()->route('announcements.show', $announcement)
            ->with('success', 'Announcement updated successfully.');
    }

    public function destroy(Announcement $announcement)
    {
        if ($announcement->photo_path) {
            Storage::disk('public')->delete($announcement->photo_path);
        }
        if ($announcement->attachment_path) {
            Storage::disk('public')->delete($announcement->attachment_path);
        }

        $announcement->delete();

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement deleted successfully.');
    }

    public function publicShow(Announcement $announcement)
    {
        $announcement->load('createdBy');

        $view = $announcement->category === 'event' 
            ? 'public.events.show' 
            : 'public.campaigns.show';

        return view($view, compact('announcement'));
    }
}