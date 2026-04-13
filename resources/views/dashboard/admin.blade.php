@extends('layouts.admin')

@section('title', 'Dashboard')

@section('header', 'Admin Dashboard')
@section('subheader', 'Operations Manager - Daily Operations Overview')

@section('content')
<!-- Welcome Banner (force visible) -->
<div class="relative z-10 bg-green-700 bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl shadow-lg p-4 md:p-6 mb-6 text-white">
    <h2 class="text-xl md:text-2xl font-bold mb-2">
        Welcome back, {{ auth()->user()->name ?? 'Admin' }}!
    </h2>
    <p class="text-green-100 text-sm md:text-base">
        Manage daily operations, staff accounts, and monitor department reports.
    </p>
</div>


<!-- Quick Stats -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 md:gap-6 mb-6">
    <!-- Pending Reports -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Pending</p>
                <p class="text-xl md:text-3xl font-bold text-yellow-600 mt-1">{{ \App\Models\BiteRabiesReport::where('status', 'Pending Review')->count() }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-yellow-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-clock-history text-yellow-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Active Staff -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Staff</p>
                <p class="text-xl md:text-3xl font-bold text-green-600 mt-1">{{ \App\Models\User::where('role', '!=', 'super_admin')->where('status', 'active')->count() }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-people text-green-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Open Cases -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Open Cases</p>
                <p class="text-xl md:text-3xl font-bold text-green-600 mt-1">{{ \App\Models\BiteRabiesReport::where('status', 'Under Review')->count() }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-folder2-open text-green-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- This Month -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">This Month</p>
                <p class="text-xl md:text-3xl font-bold text-purple-600 mt-1">{{ \App\Models\BiteRabiesReport::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count() }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-calendar3 text-purple-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Approvals -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Approvals</p>
                <p class="text-xl md:text-3xl font-bold text-red-600 mt-1">{{ \App\Models\Announcement::where('status', 'draft')->count() }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-red-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-check-circle text-red-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Response Time Indicators -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-6">
    @php
        $resolvedReports = \App\Models\BiteRabiesReport::where('status', 'resolved')->whereNotNull('action_taken')->get();
        $avgDays = $resolvedReports->count() > 0 ? round($resolvedReports->avg(function($r) {
            return $r->created_at->diffInDays($r->updated_at);
        }), 1) : 0;
        $olderThan7Days = \App\Models\BiteRabiesReport::where('status', '!=', 'resolved')
            ->where('created_at', '<', now()->subDays(7))
            ->count();
    @endphp

    <!-- Average Resolution Time -->
<!-- Average Resolution Time -->
<div class="relative overflow-hidden bg-green-600 bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-4 md:p-6 text-white">

    <!-- subtle overlay -->
    <div class="absolute inset-0 bg-black/10"></div>

    <div class="relative flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-green-100">Avg. Resolution</p>
            <p class="text-2xl md:text-3xl font-bold mt-1">
                {{ $avgDays }} <span class="text-lg font-normal">days</span>
            </p>
        </div>

        <div class="w-10 h-10 md:w-14 md:h-14 bg-white/25 rounded-xl flex items-center justify-center">
            <i class="bi bi-clock-check text-white text-xl md:text-2xl"></i>
        </div>
    </div>

</div>

<!-- Cases Older Than 7 Days -->
<div class="relative overflow-hidden bg-red-600 bg-gradient-to-r from-red-500 to-red-600 rounded-xl shadow-lg p-4 md:p-6 text-white">

    <div class="absolute inset-0 bg-black/10"></div>

    <div class="relative flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-red-100"> 7 Days Old</p>
            <p class="text-2xl md:text-3xl font-bold mt-1">
                {{ $olderThan7Days }}
            </p>
        </div>

        <div class="w-10 h-10 md:w-14 md:h-14 bg-white/25 rounded-xl flex items-center justify-center">
            <i class="bi bi-exclamation-circle text-white text-xl md:text-2xl"></i>
        </div>
    </div>

</div>



<!-- Pending Approvals -->
<div class="relative overflow-hidden bg-yellow-600 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-4 md:p-6 text-white">

    <div class="absolute inset-0 bg-black/10"></div>

    <div class="relative flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-yellow-100">Pending Announc.</p>
            <p class="text-2xl md:text-3xl font-bold mt-1">
                {{ \App\Models\Announcement::where('status', 'draft')->count() }}
            </p>
        </div>

        <div class="w-10 h-10 md:w-14 md:h-14 bg-white/25 rounded-xl flex items-center justify-center">
            <i class="bi bi-hourglass-split text-white text-xl md:text-2xl"></i>
        </div>
    </div>

</div>

</div>

<!-- Filter Controls -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 mb-6">
    <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-4">Filter Reports</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
        <!-- Date Range -->
        <div>
            <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Date Range</label>
            <input type="date" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500" />
        </div>

        <!-- Barangay Filter -->
        <div>
            <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Barangay</label>
            <select class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                <option value="">All Barangays</option>
                @foreach(\App\Models\Barangay::all() as $barangay)
                    <option value="{{ $barangay->barangay_name }}">{{ $barangay->barangay_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Status Filter -->
        <div>
            <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Status</label>
            <select class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="investigating">Investigating</option>
                <option value="resolved">Resolved</option>
            </select>
        </div>

        <!-- Severity Filter -->
        <div>
            <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Severity</label>
            <select class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                <option value="">All Severity</option>
                <option value="minor">Minor</option>
                <option value="moderate">Moderate</option>
                <option value="severe">Severe</option>
            </select>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 mb-6">
    <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-3 md:grid-cols-5 gap-2 md:gap-4">
        <a href="{{ route('admin.users.create') }}" class="flex flex-col items-center p-3 bg-green-50 hover:bg-green-100 rounded-xl transition group">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-green-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-person-plus text-white text-lg md:text-xl"></i>
            </div>
            <span class="text-xs font-medium text-gray-700 text-center">Add Staff</span>
        </a>

        <a href="{{ route('admin.announcements.create') }}" class="flex flex-col items-center p-3 bg-green-50 hover:bg-green-100 rounded-xl transition group">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-green-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-megaphone text-white text-lg md:text-xl"></i>
            </div>
            <span class="text-xs font-medium text-gray-700 text-center">Announce</span>
        </a>

        <a href="{{ route('admin.bite-reports.index') }}" class="flex flex-col items-center p-3 bg-red-50 hover:bg-red-100 rounded-xl transition group">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-red-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-exclamation-circle text-white text-lg md:text-xl"></i>
            </div>
            <span class="text-xs font-medium text-gray-700 text-center">Bites</span>
        </a>

        <a href="{{ route('admin.vaccination-reports.index') }}" class="flex flex-col items-center p-3 bg-purple-50 hover:bg-purple-100 rounded-xl transition group">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-purple-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-shield-check text-white text-lg md:text-xl"></i>
            </div>
            <span class="text-xs font-medium text-gray-700 text-center">Vaccines</span>
        </a>

        <a href="{{ route('admin.all-reports') }}" class="flex flex-col items-center p-3 bg-yellow-50 hover:bg-yellow-100 rounded-xl transition group">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-yellow-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-file-earmark-bar-graph text-white text-lg md:text-xl"></i>
            </div>
            <span class="text-xs font-medium text-gray-700 text-center">Reports</span>
        </a>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-6">
    <!-- Recent Staff -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6">
        <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-4">Recent Staff</h3>
        <div class="divide-y divide-gray-100">
            @forelse(\App\Models\User::where('role', '!=', 'super_admin')->latest()->take(5)->get() as $user)
                <div class="py-3 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 md:w-10 md:h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="text-green-600 font-semibold text-xs md:text-sm">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500 capitalize">{{ str_replace('_', ' ', $user->getRoleAttribute()) }}</p>
                        </div>
                    </div>
                    <span class="text-xs text-gray-400">{{ $user->created_at->format('M d, Y') }}</span>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">No staff accounts yet</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Announcements -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6">
        <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-4">Announcements</h3>
        <div class="divide-y divide-gray-100">
            @forelse(\App\Models\Announcement::latest()->take(5)->get() as $announcement)
                <div class="py-3 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 md:w-10 md:h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="bi bi-megaphone text-green-600 text-sm md:text-base"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $announcement->title }}</p>
                            <p class="text-xs text-gray-500">{{ $announcement->status === 'published' ? 'Published' : 'Draft' }}</p>
                        </div>
                    </div>
                    <span class="text-xs text-gray-400">{{ $announcement->created_at->format('M d, Y') }}</span>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">No announcements yet</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Admin Capabilities Info -->
<div class="bg-green-50 border border-green-200 rounded-xl p-4 md:p-6">
    <h4 class="font-semibold text-green-800 mb-3 text-sm md:text-base">Admin Operations Manager</h4>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs md:text-sm">
        <div>
            <p class="font-medium text-green-700 mb-1">You Can:</p>
            <ul class="list-disc list-inside text-green-600 space-y-1">
                <li>Create staff accounts</li>
                <li>Manage announcements</li>
                <li>View and approve reports</li>
                <li>Monitor all departments</li>
            </ul>
        </div>
        <div>
            <p class="font-medium text-green-700 mb-1">You Cannot:</p>
            <ul class="list-disc list-inside text-gray-500 space-y-1">
                <li>Delete super admin accounts</li>
                <li>Change system roles</li>
                <li>Access system settings</li>
            </ul>
        </div>
    </div>
</div>
@endsection
