@extends('layouts.admin')

@section('title', 'All Reports - Super Admin')

@section('header', 'All Reports')
@section('subheader', 'System-wide user and announcement management')

@section('content')
<!-- Stats Overview - Only Users and Announcements -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    @php
        $statsCards = [
            ['label' => 'Total Users', 'count' => $stats['total_users'], 'icon' => 'bi-people', 'color' => 'blue'],
            ['label' => 'Announcements', 'count' => $stats['total_announcements'], 'icon' => 'bi-megaphone', 'color' => 'purple'],
            ['label' => 'Active Users', 'count' => $stats['active_users'] ?? 0, 'icon' => 'bi-check-circle', 'color' => 'green'],
        ];
    @endphp

    @foreach($statsCards as $stat)
        @php
            $colors = [
                'blue' => 'bg-blue-100 text-blue-600',
                'purple' => 'bg-purple-100 text-purple-600',
                'green' => 'bg-green-100 text-green-600',
                'yellow' => 'bg-yellow-100 text-yellow-600',
            ];
        @endphp
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xl {{ $colors[$stat['color']] }}"><i class="bi {{ $stat['icon'] }}"></i></span>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ $stat['count'] }}</p>
            <p class="text-xs text-gray-500">{{ $stat['label'] }}</p>
        </div>
    @endforeach
</div>

<!-- User Distribution -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">User Distribution by Role</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @forelse($userRoles as $role => $count)
            <div class="text-center p-4 bg-gray-50 rounded-xl">
                <p class="text-2xl font-bold text-gray-800">{{ $count }}</p>
                <p class="text-xs text-gray-500 capitalize">{{ str_replace('_', ' ', $role) }}</p>
            </div>
        @empty
            <div class="col-span-full text-center py-4 text-gray-500">
                No users found
            </div>
        @endforelse
    </div>
</div>

<!-- Recent Announcements -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="px-5 py-4 border-b border-gray-100 bg-purple-50">
        <h3 class="font-semibold text-gray-800">Recent Announcements</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($recentAnnouncements as $announcement)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-4 text-sm text-gray-700">{{ $announcement->title }}</td>
                        <td class="px-5 py-4 text-sm">
                            <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-700">
                                {{ ucfirst($announcement->type ?? 'general') }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-sm">
                            @if($announcement->is_active)
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Active</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-700">Inactive</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-500">{{ $announcement->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-8 text-center text-gray-500">
                            <i class="bi bi-megaphone text-3xl mb-2 block"></i>
                            <p>No announcements found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-3 border-t border-gray-100">
        <a href="{{ route('super-admin.announcements.index') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">
            View All Announcements <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
</div>

<!-- Recent Users -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100 bg-blue-50">
        <h3 class="font-semibold text-gray-800">Recently Registered Users</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Joined</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($recentUsers as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-4 text-sm text-gray-700">{{ $user->name }}</td>
                        <td class="px-5 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="px-5 py-4 text-sm">
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700 capitalize">
                                {{ str_replace('_', ' ', $user->role) }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-sm">
                            @if($user->status === 'active')
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Active</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">Inactive</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-gray-500">
                            <i class="bi bi-people text-3xl mb-2 block"></i>
                            <p>No users found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-3 border-t border-gray-100">
        <a href="{{ route('super-admin.users.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
            Manage All Users <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
</div>
@endsection
