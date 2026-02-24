@php
$rolePrefix = str_replace('_', '-', auth()->user()->role ?? 'admin');
$canManage = in_array(auth()->user()->role ?? '', ['super_admin', 'admin']);
@endphp

@extends('layouts.admin')

@section('title', 'Announcements')

@section('header', 'Announcements')
@section('subheader', 'Stay updated with the latest news')

@section('content')
<!-- Announcements Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
    @forelse(\App\Models\Announcement::where('is_active', true)->latest()->get() as $announcement)
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
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-4 md:p-6">
                <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">{{ $announcement->title }}</h3>
                <p class="text-gray-600 mb-3 text-sm whitespace-pre-line">{{ $announcement->description }}</p>

                <!-- Meta Info -->
                <div class="flex flex-wrap gap-2 text-xs md:text-sm text-gray-500 mb-4">
                    @if($announcement->event_date)
                        <span class="inline-flex items-center px-2 py-1 bg-gray-100 rounded-lg">
                            <i class="bi bi-calendar-event mr-1 text-blue-500"></i>
                            {{ \Carbon\Carbon::parse($announcement->event_date)->format('M d, Y') }}
                        </span>
                    @endif
                    @if($announcement->event_time)
                        <span class="inline-flex items-center px-2 py-1 bg-gray-100 rounded-lg">
                            <i class="bi bi-clock mr-1 text-blue-500"></i>
                            {{ $announcement->event_time }}
                        </span>
                    @endif
                    @if($announcement->location)
                        <span class="inline-flex items-center px-2 py-1 bg-gray-100 rounded-lg">
                            <i class="bi bi-geo-alt mr-1 text-red-500"></i>
                            {{ $announcement->location }}
                        </span>
                    @endif
                    @if($announcement->contact_number)
                        <span class="inline-flex items-center px-2 py-1 bg-gray-100 rounded-lg">
                            <i class="bi bi-phone mr-1 text-green-500"></i>
                            {{ $announcement->contact_number }}
                        </span>
                    @endif
                    @if($announcement->organized_by)
                        <span class="inline-flex items-center px-2 py-1 bg-gray-100 rounded-lg">
                            <i class="bi bi-person mr-1 text-purple-500"></i>
                            {{ $announcement->organized_by }}
                        </span>
                    @endif
                    <span class="inline-flex items-center px-2 py-1 bg-gray-100 rounded-lg">
                        <i class="bi bi-clock mr-1 text-gray-400"></i>
                        {{ $announcement->created_at->format('M d, Y') }}
                    </span>
                </div>

                <!-- Action Buttons - Only for Admins -->
                @if($canManage)
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
                @endif
            </div>
        </div>
    @empty
        <!-- Empty State -->
        <div class="col-span-1 lg:col-span-2">
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 md:p-12 text-center border-2 border-dashed border-gray-200">
                <div class="w-16 h-16 md:w-24 md:h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-4 md:mb-6 shadow-lg">
                    <i class="bi bi-megaphone text-3xl md:text-5xl text-gray-300"></i>
                </div>
                <h3 class="text-lg md:text-2xl font-bold text-gray-700 mb-2">No Announcements</h3>
                <p class="text-gray-500 mb-4 md:mb-6 max-w-md mx-auto text-sm md:text-base">There are no announcements at the moment. Please check back later.</p>
            </div>
        </div>
    @endforelse
</div>
@endsection
