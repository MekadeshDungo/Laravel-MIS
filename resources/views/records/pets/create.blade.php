@extends('layouts.admin')

@section('title', 'Register Pet')
@section('header', 'New Pet Registration')
@section('subheader', 'Register a new pet in the system')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin-staff.pets.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Pets</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">Pet Information</h3>
            <p class="text-sm text-gray-500">Fill in the information below to register a new pet</p>
        </div>

        <form action="{{ route('admin-staff.pets.store') }}" method="POST" class="p-6">
            @csrf

            <!-- Pet Details -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-heart text-emerald-600"></i> Pet Details
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Pet Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition @error('name') border-red-500 @enderror"
                            placeholder="Enter pet name" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Species -->
                    <div>
                        <label for="species" class="block text-sm font-medium text-gray-700 mb-2">Species <span class="text-red-500">*</span></label>
                        <select name="species" id="species" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition @error('species') border-red-500 @enderror" required>
                            <option value="">Select species</option>
                            <option value="dog" {{ old('species') == 'dog' ? 'selected' : '' }}>Dog</option>
                            <option value="cat" {{ old('species') == 'cat' ? 'selected' : '' }}>Cat</option>
                            <option value="other" {{ old('species') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('species')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Breed -->
                    <div>
                        <label for="breed" class="block text-sm font-medium text-gray-700 mb-2">Breed</label>
                        <input type="text" name="breed" id="breed" value="{{ old('breed') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                            placeholder="Enter breed (e.g., Aspin, Siamese)">
                    </div>

                    <!-- Age -->
                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-700 mb-2">Age (years)</label>
                        <input type="number" name="age" id="age" value="{{ old('age') }}" min="0"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                            placeholder="Enter age">
                    </div>

                    <!-- Gender -->
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                        <select name="gender" id="gender" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                            <option value="">Select gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="unknown" {{ old('gender') == 'unknown' ? 'selected' : '' }}>Unknown</option>
                        </select>
                    </div>

                    <!-- Color -->
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Color/Marking</label>
                        <input type="text" name="color" id="color" value="{{ old('color') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                            placeholder="Enter color or markings">
                    </div>

                    <!-- Weight -->
                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">Weight (kg)</label>
                        <input type="number" name="weight" id="weight" value="{{ old('weight') }}" min="0" step="0.1"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                            placeholder="Enter weight">
                    </div>

                    <!-- Health Status -->
                    <div>
                        <label for="health_status" class="block text-sm font-medium text-gray-700 mb-2">Health Status</label>
                        <select name="health_status" id="health_status" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                            <option value="">Select status</option>
                            <option value="healthy" {{ old('health_status') == 'healthy' ? 'selected' : '' }}>Healthy</option>
                            <option value="sick" {{ old('health_status') == 'sick' ? 'selected' : '' }}>Sick</option>
                            <option value="injured" {{ old('health_status') == 'injured' ? 'selected' : '' }}>Injured</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Owner Information -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-person text-blue-600"></i> Owner Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Select Existing Owner -->
                    <div class="md:col-span-2">
                        <label for="owner_id" class="block text-sm font-medium text-gray-700 mb-2">Select Existing Owner</label>
                        <select name="owner_id" id="owner_id" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                            <option value="">-- Select from existing owners --</option>
                            @foreach($owners as $owner)
                                <option value="{{ $owner->id }}" {{ old('owner_id') == $owner->id ? 'selected' : '' }}>
                                    {{ $owner->name }} ({{ $owner->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2 text-center text-gray-500 text-sm">- OR -</div>

                    <!-- New Owner Name -->
                    <div>
                        <label for="owner_name" class="block text-sm font-medium text-gray-700 mb-2">New Owner Name</label>
                        <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                            placeholder="Enter owner's full name">
                    </div>

                    <!-- New Owner Contact -->
                    <div>
                        <label for="owner_contact" class="block text-sm font-medium text-gray-700 mb-2">New Owner Contact</label>
                        <input type="text" name="owner_contact" id="owner_contact" value="{{ old('owner_contact') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                            placeholder="Enter contact number">
                    </div>
                </div>
            </div>

            <!-- License & ID -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-credit-card text-purple-600"></i> License & Identification
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- License Number -->
                    <div>
                        <label for="license_number" class="block text-sm font-medium text-gray-700 mb-2">License Number</label>
                        <input type="text" name="license_number" id="license_number" value="{{ old('license_number') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition @error('license_number') border-red-500 @enderror"
                            placeholder="Enter license number">
                        @error('license_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Microchip Number -->
                    <div>
                        <label for="microchip_number" class="block text-sm font-medium text-gray-700 mb-2">Microchip Number</label>
                        <input type="text" name="microchip_number" id="microchip_number" value="{{ old('microchip_number') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                            placeholder="Enter microchip number">
                    </div>
                </div>
            </div>

            <!-- Vaccination Status -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-shield-check text-green-600"></i> Vaccination Status
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="vaccination_status" value="vaccinated" {{ old('vaccination_status', 'unvaccinated') == 'vaccinated' ? 'checked' : '' }}
                                class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500">
                            <span class="text-sm text-gray-700">Vaccinated</span>
                        </label>
                    </div>
                    <div>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="vaccination_status" value="unvaccinated" {{ old('vaccination_status') == 'unvaccinated' ? 'checked' : '' }}
                                class="w-4 h-4 text-yellow-600 border-gray-300 focus:ring-yellow-500">
                            <span class="text-sm text-gray-700">Unvaccinated</span>
                        </label>
                    </div>
                    <div>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="vaccination_status" value="pending" {{ old('vaccination_status') == 'pending' ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Pending</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="mb-8">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                <textarea name="notes" id="notes" rows="3" 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                    placeholder="Additional notes about the pet">{{ old('notes') }}</textarea>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                <a href="{{ route('admin-staff.pets.index') }}" class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition shadow-sm">
                    <i class="bi bi-check-lg mr-2"></i>Register Pet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
