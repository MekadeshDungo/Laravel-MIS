@extends('layouts.admin')

@section('title', 'Edit Pet - ' . $pet->name)

@section('header', 'Edit Pet')

@section('content')
<div class="p-4 md:p-6">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('records-staff.pets.show', $pet) }}" class="p-2 hover:bg-gray-100 rounded-lg transition">
            <i class="bi bi-arrow-left text-gray-600"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Pet: {{ $pet->name }}</h1>
            <p class="text-gray-500 mt-1">Update the pet information below</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm">
        <form method="POST" action="{{ route('records-staff.pets.update', $pet) }}">
            @csrf
            @method('PUT')

            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Pet Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Pet Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $pet->name) }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="species" class="block text-sm font-medium text-gray-700 mb-1">Species *</label>
                        <select id="species" name="species" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="dog" {{ $pet->species === 'dog' ? 'selected' : '' }}>Dog</option>
                            <option value="cat" {{ $pet->species === 'cat' ? 'selected' : '' }}>Cat</option>
                            <option value="other" {{ $pet->species === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div>
                        <label for="breed" class="block text-sm font-medium text-gray-700 mb-1">Breed</label>
                        <input type="text" id="breed" name="breed" value="{{ old('breed', $pet->breed) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-700 mb-1">Age (years)</label>
                        <input type="number" id="age" name="age" value="{{ old('age', $pet->age) }}" min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                        <select id="gender" name="gender"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="unknown" {{ $pet->gender === 'unknown' ? 'selected' : '' }}>Unknown</option>
                            <option value="male" {{ $pet->gender === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ $pet->gender === 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700 mb-1">Weight (kg)</label>
                        <input type="number" step="0.01" id="weight" name="weight" value="{{ old('weight', $pet->weight) }}" min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Owner</h3>
                <div>
                    <label for="owner_id" class="block text-sm font-medium text-gray-700 mb-1">Select Owner</label>
                    <select id="owner_id" name="owner_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Select Owner --</option>
                        @foreach($owners as $owner)
                            <option value="{{ $owner->id }}" {{ $pet->owner_id == $owner->id ? 'selected' : '' }}>
                                {{ $owner->name }} ({{ $owner->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Identification & Vaccination</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="license_number" class="block text-sm font-medium text-gray-700 mb-1">License Number</label>
                        <input type="text" id="license_number" name="license_number" value="{{ old('license_number', $pet->license_number) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="license_expiry" class="block text-sm font-medium text-gray-700 mb-1">License Expiry</label>
                        <input type="date" id="license_expiry" name="license_expiry" value="{{ old('license_expiry', $pet->license_expiry ? $pet->license_expiry->format('Y-m-d') : '') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="microchip_number" class="block text-sm font-medium text-gray-700 mb-1">Microchip Number</label>
                        <input type="text" id="microchip_number" name="microchip_number" value="{{ old('microchip_number', $pet->microchip_number) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div>
                        <label for="vaccination_status" class="block text-sm font-medium text-gray-700 mb-1">Vaccination Status</label>
                        <select id="vaccination_status" name="vaccination_status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="unvaccinated" {{ $pet->vaccination_status === 'unvaccinated' ? 'selected' : '' }}>Unvaccinated</option>
                            <option value="vaccinated" {{ $pet->vaccination_status === 'vaccinated' ? 'selected' : '' }}>Vaccinated</option>
                            <option value="pending" {{ $pet->vaccination_status === 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>
                    <div>
                        <label for="vaccination_date" class="block text-sm font-medium text-gray-700 mb-1">Last Vaccination Date</label>
                        <input type="date" id="vaccination_date" name="vaccination_date" value="{{ old('vaccination_date', $pet->vaccination_date ? $pet->vaccination_date->format('Y-m-d') : '') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="next_vaccination_date" class="block text-sm font-medium text-gray-700 mb-1">Next Vaccination Date</label>
                        <input type="date" id="next_vaccination_date" name="next_vaccination_date" value="{{ old('next_vaccination_date', $pet->next_vaccination_date ? $pet->next_vaccination_date->format('Y-m-d') : '') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="mt-4">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                    <textarea id="notes" name="notes" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('notes', $pet->notes) }}</textarea>
                </div>
            </div>

            <div class="p-6 flex items-center gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="bi bi-check-lg mr-2"></i> Update Pet
                </button>
                <a href="{{ route('records-staff.pets.show', $pet) }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
