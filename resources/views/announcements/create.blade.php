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

            <!-- Type, Audience, Priority Row -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type <span class="text-red-500">*</span></label>
                    <select name="type" id="type" 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('type') border-red-500 @enderror" required>
                        <option value="">Select type</option>
                        <option value="Vaccination Program" {{ old('type') == 'Vaccination Program' ? 'selected' : '' }}>Vaccination Program</option>
                        <option value="Rabies Alert" {{ old('type') == 'Rabies Alert' ? 'selected' : '' }}>Rabies Alert</option>
                        <option value="Livestock Advisory" {{ old('type') == 'Livestock Advisory' ? 'selected' : '' }}>Livestock Advisory</option>
                        <option value="Meat Inspection Notice" {{ old('type') == 'Meat Inspection Notice' ? 'selected' : '' }}>Meat Inspection Notice</option>
                        <option value="General Announcement" {{ old('type') == 'General Announcement' ? 'selected' : '' }}>General Announcement</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Audience -->
                <div>
                    <label for="audience" class="block text-sm font-medium text-gray-700 mb-2">Audience <span class="text-red-500">*</span></label>
                    <select name="audience" id="audience" 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('audience') border-red-500 @enderror" required>
                        <option value="">Select audience</option>
                        <option value="Public" {{ old('audience') == 'Public' ? 'selected' : '' }}>Public</option>
                        <option value="Pet Owners" {{ old('audience') == 'Pet Owners' ? 'selected' : '' }}>Pet Owners</option>
                        <option value="Farmers / Livestock Owners" {{ old('audience') == 'Farmers / Livestock Owners' ? 'selected' : '' }}>Farmers / Livestock Owners</option>
                        <option value="Internal Staff" {{ old('audience') == 'Internal Staff' ? 'selected' : '' }}>Internal Staff</option>
                    </select>
                    @error('audience')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority -->
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">Priority <span class="text-red-500">*</span></label>
                    <select name="priority" id="priority" 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('priority') border-red-500 @enderror" required>
                        <option value="">Select priority</option>
                        <option value="Normal" {{ old('priority') == 'Normal' ? 'selected' : '' }}>Normal</option>
                        <option value="Important" {{ old('priority') == 'Important' ? 'selected' : '' }}>Important</option>
                        <option value="Urgent" {{ old('priority') == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                    </select>
                    @error('priority')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Status and Dates Row -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                    <select name="status" id="status" 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('status') border-red-500 @enderror" required>
                        <option value="">Select status</option>
                        <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                        <option value="Published" {{ old('status') == 'Published' ? 'selected' : '' }}>Published</option>
                        <option value="Archived" {{ old('status') == 'Archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Publish Date -->
                <div>
                    <label for="publish_date" class="block text-sm font-medium text-gray-700 mb-2">Publish Date <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="publish_date" id="publish_date" value="{{ old('publish_date') }}" 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('publish_date') border-red-500 @enderror"
                        required>
                    @error('publish_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Expiry Date -->
                <div>
                    <label for="expiry_date" class="block text-sm font-medium text-gray-700 mb-2">Expiry Date (Optional)</label>
                    <input type="datetime-local" name="expiry_date" id="expiry_date" value="{{ old('expiry_date') }}" 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('expiry_date') border-red-500 @enderror">
                    @error('expiry_date')
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
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Photo (Optional)</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition cursor-pointer">
                        <input type="file" name="photo" id="photo" class="hidden" accept="image/jpeg,image/png,image/jpg,image/gif">
                        <label for="photo" class="cursor-pointer">
                            <i class="bi bi-cloud-upload text-3xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-600">Click to upload photo</p>
                            <p class="text-xs text-gray-400 mt-1">PNG, JPG up to 2MB</p>
                        </label>
                    </div>
                    @error('photo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Attachment -->
                <div>
                    <label for="attachment" class="block text-sm font-medium text-gray-700 mb-2">Attachment (Optional)</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition cursor-pointer">
                        <input type="file" name="attachment" id="attachment" class="hidden" accept="application/pdf">
                        <label for="attachment" class="cursor-pointer">
                            <i class="bi bi-file-earmark-text text-3xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-600">Click to upload file</p>
                            <p class="text-xs text-gray-400 mt-1">PDF up to 5MB</p>
                        </label>
                    </div>
                    @error('attachment')
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
