@php $rolePrefix = str_replace('_', '-', auth()->user()->role ?? 'admin'); @endphp

@extends('layouts.admin')

@section('title', 'Edit Announcement - VetMIS')

@section('content')
<div class="w-full max-w-4xl mx-auto">
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
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="bi bi-pencil-square me-2"></i>Edit Announcement
            </h3>
            <p class="text-sm text-gray-500">Update the announcement details below</p>
        </div>

        @if(session('success'))
            <div class="m-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="bi bi-check-circle text-green-600"></i>
                    <span class="text-green-800">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif

        <form action="{{ route($rolePrefix . '.announcements.update', $announcement) }}" method="POST" 
              enctype="multipart/form-data" id="announcementForm">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="p-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="bi bi-card-heading me-1 text-green-600"></i>Title <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('title') border-red-500 @enderror" 
                       id="title" 
                       name="title" 
                       value="{{ old('title', $announcement->title) }}" 
                       placeholder="Enter announcement title"
                       required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Type and Status Row -->
            <div class="px-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-tag me-1 text-green-600"></i>Type <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('type') border-red-500 @enderror" 
                            id="type" name="type" required>
                        <option value="">Select type</option>
                        <option value="info" {{ old('type', $announcement->type) == 'info' ? 'selected' : '' }}>Information</option>
                        <option value="alert" {{ old('type', $announcement->type) == 'alert' ? 'selected' : '' }}>Alert</option>
                        <option value="reminder" {{ old('type', $announcement->type) == 'reminder' ? 'selected' : '' }}>Reminder</option>
                        <option value="update" {{ old('type', $announcement->type) == 'update' ? 'selected' : '' }}>Update</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-circle-fill me-1 text-green-600"></i>Status <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('status') border-red-500 @enderror" 
                            id="status" name="status" required>
                        <option value="">Select status</option>
                        <option value="draft" {{ old('status', $announcement->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $announcement->status) == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Content -->
            <div class="px-6 mt-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="bi bi-text-paragraph me-1 text-green-600"></i>Content <span class="text-red-500">*</span>
                </label>
                <textarea class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('content') border-red-500 @enderror" 
                          id="content" 
                          name="content" 
                          rows="5" 
                          placeholder="Enter full description"
                          required>{{ old('content', $announcement->description) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Photo Upload -->
            <div class="px-6 mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="bi bi-image me-1 text-green-600"></i>
                    {{ $announcement->photo_path ? 'Replace Photo (Optional)' : 'Photo (Optional)' }}
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-400 transition">
                    <input type="file" 
                           class="hidden" 
                           id="photo" 
                           name="photo" 
                           accept="image/*"
                           onchange="previewImage(event)">
                    <label for="photo" class="cursor-pointer">
                        <i class="bi bi-cloud-upload text-4xl text-gray-400 mb-2 block"></i>
                        <p class="text-sm text-gray-600">Click to upload or drag and drop</p>
                        <p class="text-xs text-gray-400 mt-1">PNG, JPG up to 2MB</p>
                    </label>
                </div>
                @error('photo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                
                <!-- Current Photo Preview -->
                @if($announcement->photo_path)
                    <div class="mt-4" id="currentPhoto">
                        <div class="flex items-center gap-4">
                            @if(Storage::disk('public')->exists($announcement->photo_path))
                                <img src="{{ Storage::url($announcement->photo_path) }}" 
                                     alt="Current photo" 
                                     class="rounded-lg object-cover"
                                     style="max-height: 100px;">
                            @else
                                <img src="{{ asset('storage/' . $announcement->photo_path) }}" 
                                     alt="Current photo" 
                                     class="rounded-lg object-cover"
                                     style="max-height: 100px;">
                            @endif
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" 
                                       id="remove_photo" 
                                       name="remove_photo" 
                                       value="1"
                                       class="w-4 h-4 text-red-600 rounded border-gray-300 focus:ring-red-500">
                                <span class="text-sm text-red-600">Remove current photo</span>
                            </label>
                        </div>
                    </div>
                @endif
                
                <!-- New Image Preview -->
                <div class="mt-4 hidden" id="imagePreview">
                    <div class="relative inline-block">
                        <img id="previewImg" src="" alt="Preview" 
                             class="rounded-lg object-cover"
                             style="max-height: 200px; max-width: 100%;">
                        <button type="button" class="absolute top-2 right-2 p-1 bg-red-600 text-white rounded-full hover:bg-red-700 transition"
                                onclick="removeImage()" title="Remove image">
                            <i class="bi bi-x-lg text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>

            <hr class="my-6 mx-6 border-gray-200">

            <!-- Event Details Section -->
            <div class="px-6">
                <h6 class="font-semibold text-gray-800 mb-4">
                    <i class="bi bi-calendar-event me-2 text-green-600"></i>Event Details (Optional)
                </h6>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Event Date -->
                    <div>
                        <label for="event_date" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="bi bi-calendar3 me-1"></i>Event Date
                        </label>
                        <input type="date" 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('event_date') border-red-500 @enderror" 
                               id="event_date" 
                               name="event_date" 
                               value="{{ old('event_date', $announcement->event_date ? \Carbon\Carbon::parse($announcement->event_date)->format('Y-m-d') : '') }}">
                        @error('event_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Event Time -->
                    <div>
                        <label for="event_time" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="bi bi-clock me-1"></i>Event Time
                        </label>
                        <input type="time" 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('event_time') border-red-500 @enderror" 
                               id="event_time" 
                               name="event_time" 
                               value="{{ old('event_time', $announcement->event_time) }}">
                        @error('event_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="bi bi-geo-alt me-1"></i>Location
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <i class="bi bi-geo-alt"></i>
                            </span>
                            <input type="text" 
                                   class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('location') border-red-500 @enderror" 
                                   id="location" 
                                   name="location" 
                                   value="{{ old('location', $announcement->location) }}" 
                                   placeholder="Enter event location">
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Organized By -->
                    <div>
                        <label for="organized_by" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="bi bi-person-badge me-1"></i>Organized By
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" 
                                   class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('organized_by') border-red-500 @enderror" 
                                   id="organized_by" 
                                   name="organized_by" 
                                   value="{{ old('organized_by', $announcement->organized_by) }}" 
                                   placeholder="Enter organizer name">
                            @error('organized_by')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Contact Number -->
                    <div>
                        <label for="contact_number" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="bi bi-telephone me-1"></i>Contact Number
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <i class="bi bi-phone"></i>
                            </span>
                            <input type="text" 
                                   class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('contact_number') border-red-500 @enderror" 
                                   id="contact_number" 
                                   name="contact_number" 
                                   value="{{ old('contact_number', $announcement->contact_number) }}" 
                                   placeholder="Enter contact number">
                            @error('contact_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="px-6 py-6 mt-6 border-t border-gray-100 flex flex-col sm:flex-row sm:justify-end gap-3">
                <a href="{{ route($rolePrefix . '.announcements.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-center">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition shadow-sm">
                    <i class="bi bi-check-circle me-2"></i>Update Announcement
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const currentPhoto = document.getElementById('currentPhoto');
        
        if (input.files && input.files[0]) {
            // Hide current photo if exists
            if (currentPhoto) {
                currentPhoto.style.display = 'none';
            }
            
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.classList.remove('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function removeImage() {
        const input = document.getElementById('photo');
        const preview = document.getElementById('imagePreview');
        
        input.value = '';
        preview.classList.add('hidden');
        
        // Show current photo again if it was hidden
        const currentPhoto = document.getElementById('currentPhoto');
        if (currentPhoto) {
            currentPhoto.style.display = 'block';
        }
    }
</script>
@endpush
@endsection
