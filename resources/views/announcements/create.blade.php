@php $rolePrefix = str_replace('_', '-', auth()->user()->role ?? 'admin'); @endphp

@extends('layouts.admin')

@section('title', 'Create Announcement')

@section('header', 'Create Announcement')
@section('subheader', 'Create a new system announcement')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route($rolePrefix . '.announcements.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Announcements</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">New Announcement Details</h3>
            <p class="text-sm text-gray-500">Fill in the information below to create a new announcement</p>
        </div>

        <form action="{{ route($rolePrefix . '.announcements.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('title') border-red-500 @enderror"
                    placeholder="Enter announcement title" required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Type Row -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category <span class="text-red-500">*</span></label>
                    <select name="category" id="category" 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('category') border-red-500 @enderror" required>
                        <option value="">Select category</option>
                        <option value="campaign" {{ old('category') == 'campaign' ? 'selected' : '' }}>Campaign</option>
                        <option value="event" {{ old('category') == 'event' ? 'selected' : '' }}>Event</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Event Date -->
                <div>
                    <label for="event_date" class="block text-sm font-medium text-gray-700 mb-2">Event Date (Optional)</label>
                    <input type="date" name="event_date" id="event_date" value="{{ old('event_date') }}" 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('event_date') border-red-500 @enderror">
                    @error('event_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Event Time -->
                <div>
                    <label for="event_time" class="block text-sm font-medium text-gray-700 mb-2">Event Time (Optional)</label>
                    <input type="time" name="event_time" id="event_time" value="{{ old('event_time') }}" 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('event_time') border-red-500 @enderror">
                    @error('event_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location (Optional)</label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}" 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('location') border-red-500 @enderror"
                        placeholder="Enter event location">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Additional Event Details -->
            <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-6">
                <!-- Contact Number -->
                <div>
                    <label for="contact_number" class="block text-sm font-medium text-gray-700 mb-2">Contact Number (Optional)</label>
                    <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number') }}" 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('contact_number') border-red-500 @enderror"
                        placeholder="Enter contact number">
                    @error('contact_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Content -->
            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content <span class="text-red-500">*</span></label>
                <textarea name="content" id="content" rows="8"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('content') border-red-500 @enderror"
                    placeholder="Enter announcement content" required>{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Photo and Attachment Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Photo -->
                <div>
                    <label for="photo_path" class="block text-sm font-medium text-gray-700 mb-2">Photo (Optional)</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition cursor-pointer">
                        <input type="file" name="photo_path" id="photo_path" class="hidden" accept="image/jpeg,image/png,image/jpg,image/gif">
                        <label for="photo_path" class="cursor-pointer">
                            <i class="bi bi-cloud-upload text-3xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-600">Click to upload photo</p>
                            <p class="text-xs text-gray-400 mt-1">PNG, JPG up to 2MB</p>
                        </label>
                    </div>
                    @error('photo_path')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Attachment -->
                <div>
                    <label for="attachment_path" class="block text-sm font-medium text-gray-700 mb-2">Attachment (Optional)</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition cursor-pointer">
                        <input type="file" name="attachment_path" id="attachment_path" class="hidden" accept="application/pdf">
                        <label for="attachment_path" class="cursor-pointer">
                            <i class="bi bi-file-earmark-text text-3xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-600">Click to upload file</p>
                            <p class="text-xs text-gray-400 mt-1">PDF up to 5MB</p>
                        </label>
                    </div>
                    @error('attachment_path')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                <a href="{{ route($rolePrefix . '.announcements.index') }}" class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition shadow-sm">
                    <i class="bi bi-check-lg mr-2"></i>Create Announcement
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
