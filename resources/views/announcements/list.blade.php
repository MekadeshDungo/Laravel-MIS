@php $rolePrefix = str_replace('_', '-', auth()->user()->role ?? 'admin'); @endphp
@extends('layouts.admin')

@section('title', 'Manage Announcements - VetMIS')

@section('content')
<div class="w-full">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h4 class="font-bold text-green-600 mb-1">
                <i class="bi bi-megaphone-fill me-2"></i>Manage Announcements
            </h4>
            <p class="text-gray-500 text-sm">Create and manage public announcements</p>
        </div>
        <a href="{{ route($rolePrefix . '.announcements.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            <i class="bi bi-plus-lg"></i>New Announcement
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="bi bi-check-circle text-green-600"></i>
                <span class="text-green-800">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    @endif

    @if($announcements->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px]">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Announcement</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created By</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($announcements as $announcement)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    @if($announcement->photo_path)
                                        <img src="{{ asset('storage/' . $announcement->photo_path) }}" 
                                             class="rounded-lg object-cover"
                                             alt="photo" 
                                             style="width: 50px; height: 50px;">
                                    @else
                                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                            <i class="bi bi-megaphone text-green-600 text-xl"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $announcement->title }}</p>
                                        <p class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($announcement->description, 50) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                @if($announcement->event_date)
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-gray-100 rounded-full text-sm text-gray-700">
                                        <i class="bi bi-calendar3 text-blue-500"></i>
                                        {{ \Carbon\Carbon::parse($announcement->event_date)->format('M d, Y') }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                @if($announcement->location)
                                    <span class="text-sm text-gray-600">
                                        <i class="bi bi-geo-alt text-green-500 mr-1"></i>
                                        {{ Str::limit($announcement->location, 20) }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <span class="text-sm text-gray-500">{{ $announcement->user->name ?? 'Unknown' }}</span>
                            </td>
                            <td class="px-4 py-4">
                                @if($announcement->is_active)
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="bi bi-check-circle"></i>Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                        <i class="bi bi-dash-circle"></i>Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route($rolePrefix . '.announcements.edit', $announcement) }}" 
                                       class="p-2 border border-green-600 text-green-600 rounded-lg hover:bg-green-50 transition"
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" 
                                            class="p-2 border border-red-600 text-red-600 rounded-lg hover:bg-red-50 transition"
                                            title="Delete"
                                            onclick="document.getElementById('deleteModal{{ $announcement->id }}').classList.remove('hidden')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Delete Confirmation Modal -->
                        <div id="deleteModal{{ $announcement->id }}" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
                            <div class="bg-white rounded-xl max-w-md w-full overflow-hidden">
                                <div class="bg-red-500 text-white px-6 py-4 flex items-center justify-between">
                                    <h5 class="font-semibold">
                                        <i class="bi bi-exclamation-triangle me-2"></i>Confirm Delete
                                    </h5>
                                    <button onclick="document.getElementById('deleteModal{{ $announcement->id }}').classList.add('hidden')" class="text-white hover:text-red-100">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>
                                <div class="p-6">
                                    <div class="text-center mb-4">
                                        <i class="bi bi-trash text-red-500 text-5xl mb-3 block"></i>
                                        <p class="text-gray-700">Are you sure you want to delete this announcement?</p>
                                        <p class="font-medium text-gray-800 mt-2">{{ $announcement->title }}</p>
                                    </div>
                                    @if($announcement->photo_path)
                                        <p class="text-sm text-gray-500 text-center mb-4">
                                            <i class="bi bi-image mr-1"></i>The associated photo will also be deleted.
                                        </p>
                                    @endif
                                    <div class="flex gap-3">
                                        <button type="button" 
                                                onclick="document.getElementById('deleteModal{{ $announcement->id }}').classList.add('hidden')"
                                                class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                                            <i class="bi bi-x mr-1"></i>Cancel
                                        </button>
                                        <form action="{{ route($rolePrefix . '.announcements.destroy', $announcement) }}" 
                                              method="POST" class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                                <i class="bi bi-trash mr-1"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <span class="text-sm text-gray-500">
                    Showing {{ $announcements->count() }} of {{ $announcements->total() }} announcements
                </span>
                <div class="flex gap-2">
                    {{ $announcements->links() }}
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">
            <i class="bi bi-megaphone text-gray-300 text-6xl mb-4 block"></i>
            <h4 class="text-gray-600 mb-2">No Announcements Yet</h4>
            <p class="text-gray-500 mb-4">Create your first announcement to keep the public informed.</p>
            <a href="{{ route($rolePrefix . '.announcements.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                <i class="bi bi-plus-lg"></i>Create Announcement
            </a>
        </div>
    @endif
</div>
@endsection
