<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Announcement;

class ViewerController extends Controller
{
    /**
     * Show viewer dashboard (read-only access).
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get latest announcements
        $announcements = Announcement::where('is_published', true)
            ->latest()
            ->take(5)
            ->get();
        
        return view('dashboard.viewer', compact('user', 'announcements'));
    }
}
