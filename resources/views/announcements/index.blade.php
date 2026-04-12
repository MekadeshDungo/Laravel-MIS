@php $rolePrefix = str_replace('_', '-', auth()->user()->role ?? 'admin'); @endphp

@extends('layouts.admin')

@section('title', 'Announcements')

@section('header', 'Announcements')
@section('subheader', 'Manage system announcements')

@section('content')
@php
    use App\Models\Announcement;
    
    $totalCount = Announcement::count();
    $publishedCount = Announcement::where('status', 'Published')->count();
    $draftCount = Announcement::where('status', 'Draft')->count();
    $archivedCount = Announcement::where('status', 'Archived')->count();
@endphp

<!-- Stats Cards -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500">Total</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalCount }}</p>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-megaphone text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500">Published</p>
                <p class="text-2xl font-bold text-green-600 mt-1">{{ $publishedCount }}</p>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-check-circle text-green-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500">Drafts</p>
                <p class="text-2xl font-bold text-yellow-500 mt-1">{{ $draftCount }}</p>
            </div>
            <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-pencil text-yellow-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500">Archived</p>
                <p class="text-2xl font-bold text-gray-500 mt-1">{{ $archivedCount }}</p>
            </div>
            <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-archive text-gray-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Announcements Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    @forelse(Announcement::orderBy('created_at', 'desc')->get() as $announcement)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 group">
            <!-- Card Header with Image -->
            <div class="relative h-40 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                @if($announcement->photo_path)
                    <img src="{{ $announcement->photo_url }}" alt="{{ $announcement->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-16 h-16 bg-white/50 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <i class="bi bi-image text-3xl text-gray-400"></i>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Card Body -->
            <div class="p-6">
                <!-- Category Badge -->
                <div class="mb-2">
                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">
                        {{ ucfirst($announcement->category) }}
                    </span>
                </div>

                <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">{{ $announcement->title }}</h3>
                <p class="text-gray-600 mb-3 line-clamp-2 text-sm">{{ $announcement->content }}</p>

                <!-- Meta Info -->
                <div class="flex flex-wrap gap-2 text-xs text-gray-500 mb-4">
                    <span class="inline-flex items-center px-2 py-1 bg-gray-100 rounded-lg">
                        <i class="bi bi-person mr-1 text-blue-500"></i>
                        {{ $announcement->createdBy->name ?? 'Unknown' }}
                    </span>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100">
                    <a href="{{ route($rolePrefix . '.announcements.show', $announcement) }}" class="flex items-center gap-1 px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-600 rounded-lg transition">
                        <i class="bi bi-eye"></i>
                        <span class="text-sm font-medium">View</span>
                    </a>
                    <a href="{{ route($rolePrefix . '.announcements.edit', $announcement) }}" class="flex items-center gap-1 px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition">
                        <i class="bi bi-pencil"></i>
                        <span class="text-sm font-medium">Edit</span>
                    </a>
                    <form action="{{ route($rolePrefix . '.announcements.destroy', $announcement) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex items-center gap-1 px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition" onclick="return confirm('Are you sure?')">
                            <i class="bi bi-trash"></i>
                            <span class="text-sm font-medium">Delete</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <!-- Empty State -->
        <div class="col-span-1 lg:col-span-2">
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-12 text-center border-2 border-dashed border-gray-200">
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <i class="bi bi-megaphone text-5xl text-gray-300"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">No Announcements Yet</h3>
                <p class="text-gray-500 mb-6 max-w-md mx-auto">Create your first announcement to get started.</p>
                <a href="{{ route($rolePrefix . '.announcements.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-medium rounded-lg shadow-lg hover:bg-blue-700 transition">
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
</style>
@endsection
