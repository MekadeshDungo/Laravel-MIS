@extends('layouts.admin')

@section('title', 'Encode Vaccination')
@section('header', 'Encode Vaccination Record')
@section('subheader', 'Record a new rabies vaccination')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('records-staff.dashboard') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Dashboard</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">Vaccination Information</h3>
            <p class="text-sm text-gray-500">Fill in the information below to record a vaccination</p>
        </div>

        <form action="{{ route('records-staff.vaccinations.store') }}" method="POST" class="p-6">
            @csrf

            <!-- Owner/Patient Info -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-person text-blue-600"></i> Owner / Patient Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="patient_name" class="block text-sm font-medium text-gray-700 mb-2">Owner Name <span class="text-red-500">*</span></label>
                        <input type="text" name="patient_name" id="patient_name" value="{{ old('patient_name') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('patient_name') border-red-500 @enderror"
                            placeholder="Enter owner's full name" required>
                        @error('patient_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="patient_contact" class="block text-sm font-medium text-gray-700 mb-2">Contact Number</label>
                        <input type="text" name="patient_contact" id="patient_contact" value="{{ old('patient_contact') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Enter contact number">
                    </div>

                    <div class="md:col-span-2">
                        <label for="patient_address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <textarea name="patient_address" id="patient_address" rows="2" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Enter address">{{ old('patient_address') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Pet Info -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-heart text-emerald-600"></i> Pet Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="pet_name" class="block text-sm font-medium text-gray-700 mb-2">Pet Name <span class="text-red-500">*</span></label>
                        <input type="text" name="pet_name" id="pet_name" value="{{ old('pet_name') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('pet_name') border-red-500 @enderror"
                            placeholder="Enter pet's name" required>
                        @error('pet_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="pet_species" class="block text-sm font-medium text-gray-700 mb-2">Species <span class="text-red-500">*</span></label>
                        <select name="pet_species" id="pet_species" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                            <option value="">Select species</option>
                            <option value="dog" {{ old('pet_species') == 'dog' ? 'selected' : '' }}>Dog</option>
                            <option value="cat" {{ old('pet_species') == 'cat' ? 'selected' : '' }}>Cat</option>
                            <option value="other" {{ old('pet_species') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div>
                        <label for="pet_breed" class="block text-sm font-medium text-gray-700 mb-2">Breed</label>
                        <input type="text" name="pet_breed" id="pet_breed" value="{{ old('pet_breed') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Enter breed">
                    </div>

                    <div>
                        <label for="pet_age" class="block text-sm font-medium text-gray-700 mb-2">Age (years)</label>
                        <input type="number" name="pet_age" id="pet_age" value="{{ old('pet_age') }}" min="0"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Enter age">
                    </div>

                    <div>
                        <label for="pet_gender" class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                        <select name="pet_gender" id="pet_gender" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="">Select gender</option>
                            <option value="male" {{ old('pet_gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('pet_gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="unknown" {{ old('pet_gender') == 'unknown' ? 'selected' : '' }}>Unknown</option>
                        </select>
                    </div>

                    <div>
                        <label for="pet_color" class="block text-sm font-medium text-gray-700 mb-2">Color</label>
                        <input type="text" name="pet_color" id="pet_color" value="{{ old('pet_color') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Enter color/markings">
                    </div>
                </div>
            </div>

            <!-- Vaccination Details -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-shield-check text-green-600"></i> Vaccination Details
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="vaccine_brand" class="block text-sm font-medium text-gray-700 mb-2">Vaccine Brand <span class="text-red-500">*</span></label>
                        <input type="text" name="vaccine_brand" id="vaccine_brand" value="{{ old('vaccine_brand') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('vaccine_brand') border-red-500 @enderror"
                            placeholder="e.g., Rabisin, Nobivac" required>
                        @error('vaccine_brand')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="vaccine_batch_number" class="block text-sm font-medium text-gray-700 mb-2">Batch Number</label>
                        <input type="text" name="vaccine_batch_number" id="vaccine_batch_number" value="{{ old('vaccine_batch_number') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Enter batch number">
                    </div>

                    <div>
                        <label for="vaccination_date" class="block text-sm font-medium text-gray-700 mb-2">Vaccination Date <span class="text-red-500">*</span></label>
                        <input type="date" name="vaccination_date" id="vaccination_date" value="{{ old('vaccination_date', date('Y-m-d')) }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                    </div>

                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">Pet Weight (kg)</label>
                        <input type="number" name="weight" id="weight" value="{{ old('weight') }}" min="0" step="0.1"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Enter weight">
                    </div>

                    <div>
                        <label for="vaccination_type" class="block text-sm font-medium text-gray-700 mb-2">Vaccination Type</label>
                        <select name="vaccination_type" id="vaccination_type" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="">Select type</option>
                            <option value="primary" {{ old('vaccination_type') == 'primary' ? 'selected' : '' }}>Primary</option>
                            <option value="booster" {{ old('vaccination_type') == 'booster' ? 'selected' : '' }}>Booster</option>
                        </select>
                    </div>

                    <div>
                        <label for="next_vaccination_date" class="block text-sm font-medium text-gray-700 mb-2">Next Vaccination Date</label>
                        <input type="date" name="next_vaccination_date" id="next_vaccination_date" value="{{ old('next_vaccination_date') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                </div>
            </div>

            <!-- Observations & Notes -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-journal-text text-purple-600"></i> Observations & Notes
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="observations" class="block text-sm font-medium text-gray-700 mb-2">Observations</label>
                        <textarea name="observations" id="observations" rows="3" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Any observations during vaccination">{{ old('observations') }}</textarea>
                    </div>
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Additional Notes</label>
                        <textarea name="notes" id="notes" rows="3" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Any additional notes">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-toggle-on text-gray-600"></i> Status
                </h4>
                <div class="flex items-center gap-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" name="status" value="completed" {{ old('status', 'completed') == 'completed' ? 'checked' : '' }}
                            class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500">
                        <span class="text-sm text-gray-700">Completed</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" name="status" value="pending" {{ old('status') == 'pending' ? 'checked' : '' }}
                            class="w-4 h-4 text-yellow-600 border-gray-300 focus:ring-yellow-500">
                        <span class="text-sm text-gray-700">Pending</span>
                    </label>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                <a href="{{ route('records-staff.dashboard') }}" class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition shadow-sm">
                    <i class="bi bi-check-lg mr-2"></i>Save Record
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
