@extends('layouts.admin')

@section('title', 'Announcement Details')
@section('header', 'Announcement Details')

@section('content')
@php
    // Decide which route prefix to use based on role
    $role = auth()->user()->role ?? null;
    $prefix = ($role === 'super_admin') ? 'super-admin' : 'admin';
    $canManage = in_array($role, ['super_admin', 'city_vet', 'admin_staff']);
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
                                <i class="bi bi-person mr-2"></i>
                                By {{ $announcement->user->name ?? 'Unknown' }}
                            </span>
                            <span class="flex items-center">
                                <i class="bi bi-calendar3 mr-2"></i>
                                Created: {{ $announcement->created_at->format('F d, Y') }}
                            </span>
                        </div>
                    </div>
                    <!-- Priority Badge -->
                    @if($announcement->priority)
                    <span class="px-3 py-1 rounded-full text-sm font-semibold 
                        @if($announcement->priority === 'Urgent') bg-danger text-white
                        @elseif($announcement->priority === 'Important') bg-warning text-dark
                        @else bg-secondary text-white @endif">
                        {{ $announcement->priority }}
                    </span>
                    @endif
                </div>
                
                <!-- Type and Status Badges -->
                <div class="flex flex-wrap gap-2 mt-4">
                    @if($announcement->type)
                    <span class="px-2 py-1 rounded text-xs font-medium bg-white/20">
                        {{ $announcement->type }}
                    </span>
                    @endif
                    @if($announcement->audience)
                    <span class="px-2 py-1 rounded text-xs font-medium bg-white/20">
                        <i class="bi bi-people mr-1"></i>{{ $announcement->audience }}
                    </span>
                    @endif
                    @if($announcement->status)
                    <span class="px-2 py-1 rounded text-xs font-semibold 
                        @if($announcement->status === 'Published') bg-success text-white
                        @elseif($announcement->status === 'Draft') bg-secondary text-white
                        @else bg-dark text-white @endif">
                        {{ $announcement->status }}
                    </span>
                    @endif
                </div>
            </div>

            <!-- Photo -->
            @if($announcement->image_path)
            <div class="w-full">
                <img src="{{ $announcement->image_url }}"
                     alt="{{ $announcement->title }}"
                     class="w-full h-auto object-cover max-h-96">
            </div>
            @endif

            <!-- Content -->
            <div class="px-6 py-8">
                <!-- Dates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="bi bi-calendar-check text-green-600 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-500">Publish Date</p>
                            <p class="font-medium text-gray-900">
                                {{ $announcement->publish_date ? \Carbon\Carbon::parse($announcement->publish_date)->format('F d, Y g:i A') : 'Not set' }}
                            </p>
                        </div>
                    </div>
                    @if($announcement->expiry_date)
                    <div class="flex items-center">
                        <i class="bi bi-calendar-x text-red-600 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-500">Expiry Date</p>
                            <p class="font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($announcement->expiry_date)->format('F d, Y g:i A') }}
                            </p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Main Content -->
                <div class="prose max-w-none">
                    <div class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $announcement->content }}</div>
                </div>

                <!-- Attachment -->
                @if($announcement->attachment_path)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="bi bi-paperclip mr-2"></i>Attachment
                    </h3>
                    <a href="{{ $announcement->attachment_url }}" target="_blank" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition">
                        <i class="bi bi-file-earmark-pdf"></i>
                        <span>View Attachment (PDF)</span>
                        <i class="bi bi-box-arrow-up-right ml-1"></i>
                    </a>
                </div>
                @endif
            </div>

            <!-- Footer Actions -->
            @auth
            @if($canManage)
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
