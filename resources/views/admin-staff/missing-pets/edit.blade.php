@extends('layouts.admin')

@section('title', 'Edit Missing Pet')

@section('header', 'Edit Missing Pet')
@section('subheader', 'Update missing pet details')

@section('content')
<div class="p-4 md:p-6">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin-staff.missing-pets.show', $animal->animal_id) }}" class="p-2 hover:bg-gray-100 rounded-lg transition">
            <i class="bi bi-arrow-left text-gray-600"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Missing Pet: {{ $animal->name }}</h1>
            <p class="text-gray-500 mt-1">Update the missing pet information below</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm">
        <form method="POST" action="{{ route('admin-staff.missing-pets.update', $animal->animal_id) }}" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Pet Owner -->
                <div>
                    <label for="client_id" class="block text-sm font-medium text-gray-700 mb-1">Pet Owner <span class="text-red-500">*</span></label>
                    <select name="client_id" id="client_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Owner</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->client_id }}" {{ old('client_id', $animal->client_id) == $client->client_id ? 'selected' : '' }}>
                                {{ $client->first_name }} {{ $client->last_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('client_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pet Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Pet Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $animal->name) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Animal Type -->
                <div>
                    <label for="animal_type" class="block text-sm font-medium text-gray-700 mb-1">Animal Type <span class="text-red-500">*</span></label>
                    <select name="animal_type" id="animal_type" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Type</option>
                        <option value="dog" {{ old('animal_type', $animal->animal_type) == 'dog' ? 'selected' : '' }}>Dog</option>
                        <option value="cat" {{ old('animal_type', $animal->animal_type) == 'cat' ? 'selected' : '' }}>Cat</option>
                        <option value="other" {{ old('animal_type', $animal->animal_type) == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('animal_type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Breed -->
                <div>
                    <label for="breed" class="block text-sm font-medium text-gray-700 mb-1">Breed</label>
                    <input type="text" name="breed" id="breed" value="{{ old('breed', $animal->breed) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Color -->
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color/Markings</label>
                    <input type="text" name="color" id="color" value="{{ old('color', $animal->color) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Sex -->
                <div>
                    <label for="sex" class="block text-sm font-medium text-gray-700 mb-1">Sex</label>
                    <select name="sex" id="sex"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Unknown</option>
                        <option value="male" {{ old('sex', $animal->sex) == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('sex', $animal->sex) == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <!-- Missing Since -->
                <div>
                    <label for="missing_since" class="block text-sm font-medium text-gray-700 mb-1">Missing Since <span class="text-red-500">*</span></label>
                    <input type="date" name="missing_since" id="missing_since" value="{{ old('missing_since', $animal->missing_since?->format('Y-m-d')) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('missing_since')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Last Seen Location -->
                <div>
                    <label for="last_seen_location" class="block text-sm font-medium text-gray-700 mb-1">Last Seen Location <span class="text-red-500">*</span></label>
                    <input type="text" name="last_seen_location" id="last_seen_location" value="{{ old('last_seen_location', $animal->last_seen_location) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('last_seen_location')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Info -->
                <div>
                    <label for="contact_info" class="block text-sm font-medium text-gray-700 mb-1">Contact Info <span class="text-red-500">*</span></label>
                    <input type="text" name="contact_info" id="contact_info" value="{{ old('contact_info', $animal->contact_info) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('contact_info')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Photo -->
                <div>
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Photo</label>
                    <input type="file" name="photo" id="photo" accept="image/*"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-gray-500 text-xs mt-1">Max 2MB. JPG, PNG, GIF</p>
                    @if($animal->photo_url)
                        <p class="text-gray-500 text-xs mt-1">Current: {{ $animal->photo_url }}</p>
                    @endif
                    @error('photo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-4 mt-6 pt-4 border-t border-gray-100">
                <a href="{{ route('admin-staff.missing-pets.show', $animal->animal_id) }}" class="px-4 py-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="bi bi-check-lg mr-2"></i>Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection