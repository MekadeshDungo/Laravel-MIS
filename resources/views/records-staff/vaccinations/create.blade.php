@extends('layouts.admin')

@section('title', 'Encode Vaccination Record')

@section('header', 'Encode Vaccination Record')

@section('content')
<div class="p-4 md:p-6">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('records-staff.vaccinations.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition">
            <i class="bi bi-arrow-left text-gray-600"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Encode Vaccination Record</h1>
            <p class="text-gray-500 mt-1">Fill in the vaccination details below</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm">
        <form method="POST" action="{{ route('records-staff.vaccinations.store') }}">
            @csrf

            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Patient Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="patient_name" class="block text-sm font-medium text-gray-700 mb-1">Owner/Patient Name *</label>
                        <input type="text" id="patient_name" name="patient_name" value="{{ old('patient_name') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('patient_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="patient_contact" class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                        <input type="text" id="patient_contact" name="patient_contact" value="{{ old('patient_contact') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="md:col-span-2">
                        <label for="patient_address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <textarea id="patient_address" name="patient_address" rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('patient_address') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Pet Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="pet_name" class="block text-sm font-medium text-gray-700 mb-1">Pet Name *</label>
                        <input type="text" id="pet_name" name="pet_name" value="{{ old('pet_name') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="pet_species" class="block text-sm font-medium text-gray-700 mb-1">Species *</label>
                        <select id="pet_species" name="pet_species" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Species</option>
                            <option value="dog" {{ old('pet_species') === 'dog' ? 'selected' : '' }}>Dog</option>
                            <option value="cat" {{ old('pet_species') === 'cat' ? 'selected' : '' }}>Cat</option>
                            <option value="other" {{ old('pet_species') === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div>
                        <label for="pet_breed" class="block text-sm font-medium text-gray-700 mb-1">Breed</label>
                        <input type="text" id="pet_breed" name="pet_breed" value="{{ old('pet_breed') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="pet_age" class="block text-sm font-medium text-gray-700 mb-1">Age (years)</label>
                        <input type="number" id="pet_age" name="pet_age" value="{{ old('pet_age') }}" min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div>
                        <label for="pet_gender" class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                        <select id="pet_gender" name="pet_gender"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="unknown" {{ old('pet_gender') === 'unknown' ? 'selected' : '' }}>Unknown</option>
                            <option value="male" {{ old('pet_gender') === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('pet_gender') === 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    <div>
                        <label for="pet_color" class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                        <input type="text" id="pet_color" name="pet_color" value="{{ old('pet_color') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700 mb-1">Weight (kg)</label>
                        <input type="number" step="0.01" id="weight" name="weight" value="{{ old('weight') }}" min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Vaccination Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="vaccine_brand" class="block text-sm font-medium text-gray-700 mb-1">Vaccine Brand *</label>
                        <input type="text" id="vaccine_brand" name="vaccine_brand" value="{{ old('vaccine_brand') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="vaccine_batch_number" class="block text-sm font-medium text-gray-700 mb-1">Batch Number</label>
                        <input type="text" id="vaccine_batch_number" name="vaccine_batch_number" value="{{ old('vaccine_batch_number') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="vaccination_type" class="block text-sm font-medium text-gray-700 mb-1">Vaccination Type</label>
                        <input type="text" id="vaccination_type" name="vaccination_type" value="{{ old('vaccination_type') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div>
                        <label for="vaccination_date" class="block text-sm font-medium text-gray-700 mb-1">Vaccination Date *</label>
                        <input type="date" id="vaccination_date" name="vaccination_date" value="{{ old('vaccination_date', date('Y-m-d')) }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="vaccination_time" class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                        <input type="time" id="vaccination_time" name="vaccination_time" value="{{ old('vaccination_time') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="next_vaccination_date" class="block text-sm font-medium text-gray-700 mb-1">Next Vaccination Date</label>
                        <input type="date" id="next_vaccination_date" name="next_vaccination_date" value="{{ old('next_vaccination_date') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label for="observations" class="block text-sm font-medium text-gray-700 mb-1">Observations</label>
                        <textarea id="observations" name="observations" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('observations') }}</textarea>
                    </div>
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                        <textarea id="notes" name="notes" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('notes') }}</textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status" name="status"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
            </div>

            <div class="p-6 flex items-center gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="bi bi-check-lg mr-2"></i> Save Vaccination Record
                </button>
                <a href="{{ route('records-staff.vaccinations.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
