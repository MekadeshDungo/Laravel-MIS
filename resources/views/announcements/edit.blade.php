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

            <!-- Type Row -->
            <div class="px-6 mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-tag me-1 text-green-600"></i>Category <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('category') border-red-500 @enderror" 
                            id="category" name="category" required>
                        <option value="">Select category</option>
                        <option value="campaign" {{ old('category', $announcement->category) == 'campaign' ? 'selected' : '' }}>Campaign</option>
                        <option value="event" {{ old('category', $announcement->category) == 'event' ? 'selected' : '' }}>Event</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Event Details -->
            <div class="px-6 mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Event Date -->
                <div>
                    <label for="event_date" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-calendar-event me-1 text-green-600"></i>Event Date
                    </label>
                    <input type="date" 
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('event_date') border-red-500 @enderror" 
                           id="event_date" 
                           name="event_date" 
                           value="{{ old('event_date', $announcement->event_date) }}">
                    @error('event_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Event Time -->
                <div>
                    <label for="event_time" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-clock me-1 text-green-600"></i>Event Time
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
                        <i class="bi bi-geo-alt me-1 text-green-600"></i>Location
                    </label>
                    <input type="text" 
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('location') border-red-500 @enderror" 
                           id="location" 
                           name="location" 
                           value="{{ old('location', $announcement->location) }}"
                           placeholder="Enter event location">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Organized By and Contact -->
            <div class="px-6 mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Organized By -->
                <div>
                    <label for="organized_by" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-person-badge me-1 text-green-600"></i>Organized By
                    </label>
                    <input type="text" 
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('organized_by') border-red-500 @enderror" 
                           id="organized_by" 
                           name="organized_by" 
                           value="{{ old('organized_by', $announcement->organized_by) }}"
                           placeholder="Enter organizer name">
                    @error('organized_by')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Number -->
                <div>
                    <label for="contact_number" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-telephone me-1 text-green-600"></i>Contact Number
                    </label>
                    <input type="text" 
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('contact_number') border-red-500 @enderror" 
                           id="contact_number" 
                           name="contact_number" 
                           value="{{ old('contact_number', $announcement->contact_number) }}"
                           placeholder="Enter contact number">
                    @error('contact_number')
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
                          required>{{ old('content', $announcement->body) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Photo Upload -->
            <div class="px-6 mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="bi bi-image me-1 text-green-600"></i>
                    {{ $announcement->image_path ? 'Replace Photo (Optional)' : 'Photo (Optional)' }}
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-green-400 transition">
                    <input type="file" 
                           class="hidden" 
                           id="photo" 
                           name="photo_path" 
                           accept="image/jpeg,image/png,image/jpg,image/gif"
                           onchange="previewImage(event)">
                    <label for="photo" class="cursor-pointer">
                        <i class="bi bi-cloud-upload text-3xl text-gray-400 mb-2 block"></i>
                        <p class="text-sm text-gray-600">Click to upload photo</p>
                        <p class="text-xs text-gray-400 mt-1">PNG, JPG up to 2MB</p>
                    </label>
                </div>
                @error('photo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                
                <!-- Current Photo Preview -->
                @if($announcement->image_path)
                    <div class="mt-4" id="currentPhoto">
                        <div class="flex items-center gap-4">
                            <img src="{{ $announcement->image_url }}" 
                                 alt="Current photo" 
                                 class="rounded-lg object-cover"
                                 style="max-height: 100px;">
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

            <!-- Attachment Upload -->
            <div class="px-6 mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="bi bi-paperclip me-1 text-green-600"></i>
                    {{ $announcement->attachment_path ? 'Replace Attachment (Optional)' : 'Attachment (Optional - PDF only)' }}
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-green-400 transition">
                    <input type="file" 
                           class="hidden" 
                           id="attachment" 
                           name="attachment_path" 
                           accept="application/pdf"
                           onchange="previewAttachment(event)">
                    <label for="attachment" class="cursor-pointer">
                        <i class="bi bi-file-earmark-text text-3xl text-gray-400 mb-2 block"></i>
                        <p class="text-sm text-gray-600">Click to upload PDF</p>
                        <p class="text-xs text-gray-400 mt-1">PDF up to 5MB</p>
                    </label>
                </div>
                @error('attachment')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                
                <!-- Current Attachment -->
                @if($announcement->attachment_path)
                    <div class="mt-4" id="currentAttachment">
                        <div class="flex items-center gap-4">
                            <a href="{{ $announcement->attachment_url }}" target="_blank" class="flex items-center gap-2 text-blue-600 hover:text-blue-800">
                                <i class="bi bi-file-earmark-pdf"></i>
                                <span>View Current Attachment</span>
                            </a>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" 
                                       id="remove_attachment" 
                                       name="remove_attachment" 
                                       value="1"
                                       class="w-4 h-4 text-red-600 rounded border-gray-300 focus:ring-red-500">
                                <span class="text-sm text-red-600">Remove</span>
                            </label>
                        </div>
                    </div>
                @endif
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
        
        const currentPhoto = document.getElementById('currentPhoto');
        if (currentPhoto) {
            currentPhoto.style.display = 'block';
        }
    }

    function previewAttachment(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            alert('File selected: ' + input.files[0].name);
        }
    }
</script>
@endpush
@endsection
