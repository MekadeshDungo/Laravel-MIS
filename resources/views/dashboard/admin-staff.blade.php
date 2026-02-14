@extends('layouts.admin')

@section('title', 'Admin Staff Dashboard')
@section('header', 'Admin Staff Dashboard')
@section('subheader', 'Administrative support operations')

@section('content')
@php
    $role = auth()->user()->role ?? 'admin_staff';
    $isAdminPortal = in_array($role, ['admin', 'super_admin']);
    $annPrefix = $role === 'super_admin' ? 'super-admin' : 'admin';
@endphp

<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl p-6 mb-8 text-white">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold mb-2">Admin Staff Portal</h2>
            <p class="text-blue-100">Supporting administrative and records management.</p>
        </div>
        <div class="hidden md:block">
            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center">
                <i class="bi bi-person-badge text-4xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards (make these role-safe) -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Announcements</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Announcement::count() }}</p>
            </div>
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-megaphone text-purple-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Bite Reports</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\AnimalBiteReport::count() }}</p>
            </div>
            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-file-text text-red-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Vaccination Reports</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\RabiesVaccinationReport::count() }}</p>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-shield-check text-green-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Meat Inspection</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\MeatInspectionReport::count() }}</p>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-clipboard-check text-blue-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions (role-safe) -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        {{-- View announcements: admin/super-admin -> portal list, others -> public --}}
        <a href="{{ $isAdminPortal ? route($annPrefix . '.announcements.index') : route('announcements.public.index') }}"
           class="flex flex-col items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-megaphone text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Announcements</span>
        </a>

        {{-- Bite reports: admin has admin route; non-admin should go to a safe page (dashboard or a read-only list you create) --}}
        @if($isAdminPortal)
            <a href="{{ route('admin.bite-reports.index') }}"
               class="flex flex-col items-center p-4 bg-red-50 hover:bg-red-100 rounded-xl transition group">
                <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                    <i class="bi bi-exclamation-triangle text-white text-xl"></i>
                </div>
                <span class="text-sm font-medium text-gray-700">Bite Reports</span>
            </a>
        @else
            <a href="{{ route('dashboard') }}"
               class="flex flex-col items-center p-4 bg-red-50 hover:bg-red-100 rounded-xl transition group">
                <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                    <i class="bi bi-exclamation-triangle text-white text-xl"></i>
                </div>
                <span class="text-sm font-medium text-gray-700">Bite Reports</span>
            </a>
        @endif

        {{-- Records / Encoding (point to records-staff if you want admin_staff to do records; otherwise remove) --}}
        <a href="{{ route('dashboard') }}"
           class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-folder2-open text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Records</span>
        </a>

        {{-- Reports summary: admin only --}}
        @if($isAdminPortal)
            <a href="{{ route('admin.all-reports') }}"
               class="flex flex-col items-center p-4 bg-yellow-50 hover:bg-yellow-100 rounded-xl transition group">
                <div class="w-12 h-12 bg-yellow-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                    <i class="bi bi-file-earmark-bar-graph text-white text-xl"></i>
                </div>
                <span class="text-sm font-medium text-gray-700">Reports Summary</span>
            </a>
        @endif
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Announcements -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Recent Announcements</h3>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse(\App\Models\Announcement::latest()->take(4)->get() as $announcement)
                <a class="block p-4 hover:bg-gray-50 transition"
                   href="{{ $isAdminPortal ? route($annPrefix . '.announcements.show', $announcement->id) : route('announcements.public.index') }}">
                    <div class="flex items-start justify-between mb-1">
                        <p class="text-sm font-medium text-gray-800">{{ $announcement->title }}</p>
                        <span class="text-xs text-gray-400">{{ $announcement->created_at->format('M d') }}</span>
                    </div>
                    <p class="text-xs text-gray-500 truncate">{{ Str::limit($announcement->content, 60) }}</p>
                    @if($announcement->type)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium mt-2 capitalize
                            @switch($announcement->type)
                                @case('alert') bg-yellow-100 text-yellow-700 @break
                                @case('info') bg-blue-100 text-blue-700 @break
                                @default bg-gray-100 text-gray-700
                            @endswitch">
                            {{ $announcement->type }}
                        </span>
                    @endif
                </a>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <i class="bi bi-inbox text-3xl mb-2 block"></i>
                    <p class="text-sm">No announcements yet</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Users (admin only) -->
    @if($isAdminPortal)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Recent Users</h3>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse(\App\Models\User::latest()->take(4)->get() as $user)
                <div class="p-4 flex items-center justify-between hover:bg-gray-50 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 font-semibold text-sm">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                        </div>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full capitalize bg-gray-100 text-gray-700">
                        {{ str_replace('_', ' ', $user->role) }}
                    </span>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <i class="bi bi-inbox text-3xl mb-2 block"></i>
                    <p class="text-sm">No users yet</p>
                </div>
            @endforelse
        </div>
    </div>
    @endif
</div>
@endsection
