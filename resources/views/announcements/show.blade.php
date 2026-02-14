@extends('layouts.admin')

@section('title', 'Announcement Details')
@section('header', 'Announcement Details')

@section('content')
@php
    // Decide which route prefix to use based on role
    $role = auth()->user()->role ?? null;
    $prefix = ($role === 'super_admin') ? 'super-admin' : 'admin';
@endphp

<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route($prefix . '.announcements.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700">
                <i class="bi bi-arrow-left mr-2"></i>
                Back to Announcements
            </a>
        </div>

        <!-- Announcement Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header -->
            <div class="bg-linear-to-r from-blue-600 to-blue-700 px-6 py-8 text-white">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold mb-2">{{ $announcement->title }}</h1>
                        <div class="flex flex-wrap items-center gap-4 text-blue-100">
                            <span class="flex items-center">
                                <i class="bi bi-calendar3 mr-2"></i>
                                {{ $announcement->created_at->format('F d, Y') }}
                            </span>
                            <span class="flex items-center">
                                <i class="bi bi-clock mr-2"></i>
                                {{ $announcement->created_at->format('g:i A') }}
                            </span>
                            @if($announcement->user)
                            <span class="flex items-center">
                                <i class="bi bi-person mr-2"></i>
                                {{ $announcement->user->name }}
                            </span>
                            @endif
                        </div>
                    </div>
                    @if($announcement->type)
                    <span class="px-3 py-1 rounded-full text-sm font-semibold bg-white text-blue-600">
                        {{ ucfirst($announcement->type) }}
                    </span>
                    @endif
                </div>
            </div>

            <!-- Photo -->
            @if($announcement->photo_path)
            <div class="w-full">
                <img src="{{ Storage::url($announcement->photo_path) }}"
                     alt="{{ $announcement->title }}"
                     class="w-full h-auto object-cover max-h-96">
            </div>
            @endif

            <!-- Content -->
            <div class="px-6 py-8">
                <div class="prose max-w-none">
                    <div class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $announcement->content }}</div>
                </div>

                <!-- Event Details -->
                @if($announcement->event_date || $announcement->location || $announcement->organized_by)
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Event Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($announcement->event_date)
                        <div class="flex items-start">
                            <i class="bi bi-calendar-event text-blue-600 text-xl mr-3 mt-1"></i>
                            <div>
                                <p class="text-sm text-gray-500">Date</p>
                                <p class="font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($announcement->event_date)->format('F d, Y') }}
                                    @if($announcement->event_time)
                                        at {{ $announcement->event_time }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        @endif

                        @if($announcement->location)
                        <div class="flex items-start">
                            <i class="bi bi-geo-alt text-blue-600 text-xl mr-3 mt-1"></i>
                            <div>
                                <p class="text-sm text-gray-500">Location</p>
                                <p class="font-medium text-gray-900">{{ $announcement->location }}</p>
                            </div>
                        </div>
                        @endif

                        @if($announcement->organized_by)
                        <div class="flex items-start">
                            <i class="bi bi-people text-blue-600 text-xl mr-3 mt-1"></i>
                            <div>
                                <p class="text-sm text-gray-500">Organized By</p>
                                <p class="font-medium text-gray-900">{{ $announcement->organized_by }}</p>
                            </div>
                        </div>
                        @endif

                        @if($announcement->contact_number)
                        <div class="flex items-start">
                            <i class="bi bi-telephone text-blue-600 text-xl mr-3 mt-1"></i>
                            <div>
                                <p class="text-sm text-gray-500">Contact</p>
                                <p class="font-medium text-gray-900">{{ $announcement->contact_number }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Footer Actions -->
            @auth
            @if(auth()->user()->role === 'super_admin' || auth()->user()->role === 'admin')
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                <a href="{{ route($prefix . '.announcements.edit', $announcement->id) }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="bi bi-pencil mr-2"></i>Edit
                </a>

                <form action="{{ route($prefix . '.announcements.destroy', $announcement->id) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        <i class="bi bi-trash mr-2"></i>Delete
                    </button>
                </form>
            </div>
            @endif
            @endauth
        </div>
    </div>
</div>
@endsection
