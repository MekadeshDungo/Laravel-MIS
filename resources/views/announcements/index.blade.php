@php $rolePrefix = str_replace('_', '-', auth()->user()->role ?? 'admin'); @endphp

@extends('layouts.admin')

@section('title', 'Announcements')

@section('header', 'Announcements')
@section('subheader', 'Manage system announcements')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Total</p>
                <p class="text-xl md:text-3xl font-bold text-gray-800 mt-1">{{ \App\Models\Announcement::count() }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-megaphone text-blue-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Published</p>
                <p class="text-xl md:text-3xl font-bold text-green-600 mt-1">{{ \App\Models\Announcement::where('status', 'published')->count() }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-check-circle text-green-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Drafts</p>
                <p class="text-xl md:text-3xl font-bold text-yellow-500 mt-1">{{ \App\Models\Announcement::where('status', 'draft')->count() }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-yellow-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-pencil text-yellow-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 mb-6">
    <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
        <a href="{{ route($rolePrefix . '.announcements.create') }}" class="flex flex-col items-center p-3 md:p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition group">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-plus-circle text-white text-lg md:text-xl"></i>
            </div>
            <span class="text-xs md:text-sm font-medium text-gray-700 text-center">New</span>
        </a>

        <a href="{{ route($rolePrefix . '.announcements.index') }}" class="flex flex-col items-center p-3 md:p-4 bg-green-50 hover:bg-green-100 rounded-xl transition group">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-green-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-list text-white text-lg md:text-xl"></i>
            </div>
            <span class="text-xs md:text-sm font-medium text-gray-700 text-center">All</span>
        </a>

        <div class="flex flex-col items-center p-3 md:p-4 bg-purple-50 hover:bg-purple-100 rounded-xl transition group cursor-pointer">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-purple-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-file-earmark-bar-graph text-white text-lg md:text-xl"></i>
            </div>
            <span class="text-xs md:text-sm font-medium text-gray-700 text-center">Analytics</span>
        </div>

        <div class="flex flex-col items-center p-3 md:p-4 bg-orange-50 hover:bg-orange-100 rounded-xl transition group cursor-pointer">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-orange-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-gear text-white text-lg md:text-xl"></i>
            </div>
            <span class="text-xs md:text-sm font-medium text-gray-700 text-center">Settings</span>
        </div>
    </div>
</div>

<!-- Announcements Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
    @forelse(\App\Models\Announcement::latest()->get() as $announcement)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 group">
            <!-- Card Header with Image -->
            <div class="relative h-40 md:h-48 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                @if($announcement->photo_path && Storage::disk('public')->exists($announcement->photo_path))
                    <img src="{{ Storage::url($announcement->photo_path) }}" alt="{{ $announcement->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-16 h-16 md:w-20 md:h-20 bg-white/50 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <i class="bi bi-image text-3xl md:text-4xl text-gray-400"></i>
                        </div>
                    </div>
                @endif

                <!-- Badges Overlay -->
                <div class="absolute top-3 left-3 flex gap-2 flex-wrap">
                    @switch($announcement->type)
                        @case('alert')
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-red-500 text-white shadow-lg">
                                <i class="bi bi-exclamation-triangle mr-1"></i> Alert
                            </span>
                            @break
                        @case('info')
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-blue-500 text-white shadow-lg">
                                <i class="bi bi-info-circle mr-1"></i> Info
                            </span>
                            @break
                        @case('reminder')
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-orange-500 text-white shadow-lg">
                                <i class="bi bi-bell mr-1"></i> Reminder
                            </span>
                            @break
                        @default
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-gray-500 text-white shadow-lg">
                                <i class="bi bi-megaphone mr-1"></i> Update
                            </span>
                    @endswitch

                    @if($announcement->status == 'published')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-green-500 text-white shadow-lg">
                            <i class="bi bi-check-circle mr-1"></i> Published
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-yellow-500 text-white shadow-lg">
                            <i class="bi bi-pencil mr-1"></i> Draft
                        </span>
                    @endif
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-4 md:p-6">
                <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">{{ $announcement->title }}</h3>
                <p class="text-gray-600 mb-3 line-clamp-2 md:line-clamp-3 text-sm">{{ $announcement->description }}</p>

                <!-- Meta Info -->
                <div class="flex flex-wrap gap-2 text-xs md:text-sm text-gray-500 mb-4">
                    @if($announcement->event_date)
                        <span class="inline-flex items-center px-2 py-1 bg-gray-100 rounded-lg">
                            <i class="bi bi-calendar-event mr-1 text-blue-500"></i>
                            {{ \Carbon\Carbon::parse($announcement->event_date)->format('M d, Y') }}
                        </span>
                    @endif
                    @if($announcement->location)
                        <span class="inline-flex items-center px-2 py-1 bg-gray-100 rounded-lg">
                            <i class="bi bi-geo-alt mr-1 text-red-500"></i>
                            {{ Str::limit($announcement->location, 15) }}
                        </span>
                    @endif
                    <span class="inline-flex items-center px-2 py-1 bg-gray-100 rounded-lg">
                        <i class="bi bi-clock mr-1 text-gray-400"></i>
                        {{ $announcement->created_at->format('M d, Y') }}
                    </span>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100">
                    <a href="{{ route($rolePrefix . '.announcements.edit', $announcement) }}" class="flex items-center gap-1 md:gap-2 px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition group">
                        <i class="bi bi-pencil"></i>
                        <span class="text-xs md:text-sm font-medium">Edit</span>
                    </a>
                    <form action="{{ route($rolePrefix . '.announcements.destroy', $announcement) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex items-center gap-1 md:gap-2 px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition" onclick="return confirm('Are you sure?')">
                            <i class="bi bi-trash"></i>
                            <span class="text-xs md:text-sm font-medium">Delete</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <!-- Empty State -->
        <div class="col-span-1 lg:col-span-2">
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 md:p-12 text-center border-2 border-dashed border-gray-200">
                <div class="w-16 h-16 md:w-24 md:h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-4 md:mb-6 shadow-lg">
                    <i class="bi bi-megaphone text-3xl md:text-5xl text-gray-300"></i>
                </div>
                <h3 class="text-lg md:text-2xl font-bold text-gray-700 mb-2">No Announcements Yet</h3>
                <p class="text-gray-500 mb-4 md:mb-6 max-w-md mx-auto text-sm md:text-base">Create your first announcement to get started.</p>
                <a href="{{ route($rolePrefix . '.announcements.create') }}" class="inline-flex items-center gap-2 px-4 md:px-6 py-2 md:py-3 bg-blue-600 text-white font-medium rounded-lg shadow-lg hover:bg-blue-700 transition">
                    <i class="bi bi-plus-circle text-lg"></i>
                    Create Announcement
                </a>
            </div>
        </div>
    @endforelse
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
