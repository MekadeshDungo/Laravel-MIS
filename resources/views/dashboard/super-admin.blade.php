@extends('layouts.admin')

@section('title', 'Dashboard - Super Admin')

@section('header', 'Super Admin Dashboard')
@section('subheader', 'System Administrator - Full System Access')

@section('content')
<!-- Welcome Banner (FIXED) -->
<div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl shadow-lg p-4 md:p-6 mb-6 text-white">
    <h2 class="text-xl md:text-2xl font-bold mb-2">
        Welcome back, {{ auth()->user()->name ?? 'System Administrator' }}!
    </h2>
    <p class="text-blue-100 text-sm md:text-base">
        Full system access and account management.
    </p>
</div>




<!-- Quick Stats -->
<div class="grid grid-cols-2 lg:grid-cols-5 gap-3 md:gap-6 mb-6">
    <!-- Total Users -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Users</p>
                <p class="text-xl md:text-3xl font-bold text-gray-800 mt-1">{{ \App\Models\User::count() }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-people text-blue-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Roles -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Roles</p>
                <p class="text-xl md:text-3xl font-bold text-gray-800 mt-1">{{ \Spatie\Permission\Models\Role::count() }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-person-gear text-purple-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Announcements -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Announc.</p>
                <p class="text-xl md:text-3xl font-bold text-gray-800 mt-1">{{ \App\Models\Announcement::count() }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-megaphone text-green-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Active Users -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Active</p>
                <p class="text-xl md:text-3xl font-bold text-gray-800 mt-1">{{ \App\Models\User::where('status', 'active')->count() }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-teal-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-person-check text-teal-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- System Logs -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Logs</p>
                <p class="text-xl md:text-3xl font-bold text-gray-800 mt-1">{{ \App\Models\SystemLog::count() }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-gray-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-journal-text text-gray-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 mb-6">
    <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
        <a href="{{ route('super-admin.users.create') }}" class="flex flex-col items-center p-3 md:p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition group">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-person-plus text-white text-lg md:text-xl"></i>
            </div>
            <span class="text-xs md:text-sm font-medium text-gray-700 text-center">Add User</span>
        </a>

        <a href="{{ route('super-admin.announcements.create') }}" class="flex flex-col items-center p-3 md:p-4 bg-green-50 hover:bg-green-100 rounded-xl transition group">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-green-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-megaphone text-white text-lg md:text-xl"></i>
            </div>
            <span class="text-xs md:text-sm font-medium text-gray-700 text-center">Announce</span>
        </a>

        <a href="{{ route('super-admin.system-logs.index') }}" class="flex flex-col items-center p-3 md:p-4 bg-gray-50 hover:bg-gray-100 rounded-xl transition group">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-gray-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-journal-text text-white text-lg md:text-xl"></i>
            </div>
            <span class="text-xs md:text-sm font-medium text-gray-700 text-center">Logs</span>
        </a>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-6">
    <!-- Recent Users -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6">
        <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-4">Recent Users</h3>
        <div class="divide-y divide-gray-100">
            @forelse(\App\Models\User::latest()->take(5)->get() as $user)
                <div class="py-3 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 md:w-10 md:h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 font-semibold text-xs md:text-sm">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500 capitalize">{{ str_replace('_', ' ', $user->getRoleAttribute()) }}</p>
                        </div>
                    </div>
                    <span class="text-xs text-gray-400">{{ $user->created_at->format('M d, Y') }}</span>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">No users yet</p>
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
                            <p class="text-xs text-gray-500 capitalize">{{ $announcement->status }}</p>
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

<!-- Recent System Logs -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 mb-6">
    <div class="flex items-center justify-between mb-4 flex-wrap gap-2">
        <h3 class="text-base md:text-lg font-semibold text-gray-800">System Logs</h3>
        <a href="{{ route('super-admin.system-logs.index') }}" class="text-blue-600 hover:text-blue-800 text-xs md:text-sm font-medium">View All</a>
    </div>
    <div class="overflow-x-auto -mx-4 md:mx-0">
        <table class="w-full min-w-[600px]">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 md:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                    <th class="px-3 md:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                    <th class="px-3 md:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Module</th>
                    <th class="px-3 md:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-3 md:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">When</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse(\App\Models\SystemLog::with('user')->latest()->take(10)->get() as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 md:px-4 py-3 text-xs md:text-sm">{{ $log->user->name ?? 'System' }}</td>
                        <td class="px-3 md:px-4 py-3 text-xs md:text-sm text-gray-700">{{ $log->action }}</td>
                        <td class="px-3 md:px-4 py-3 text-xs md:text-sm text-gray-600">{{ $log->module }}</td>
                        <td class="px-3 md:px-4 py-3">
                            @if($log->status == 'success')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Success</span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Failed</span>
                            @endif
                        </td>
                        <td class="px-3 md:px-4 py-3 text-xs md:text-sm text-gray-500">{{ $log->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-3 md:px-4 py-8 text-center text-gray-500 text-xs md:text-sm">No system logs yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
