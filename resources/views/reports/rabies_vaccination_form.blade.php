@extends('layouts.admin')

@section('title', 'Rabies Vaccination Certificate')

@section('header', 'Rabies Vaccination Certificate')
@section('subheader', 'Issue vaccination certificate for animal')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.vaccination-reports.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Vaccination Records</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-red-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center">
                    <i class="bi bi-eyedropper text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Rabies Vaccination Certificate</h3>
                    <p class="text-sm text-gray-500">Fill in all required information to issue a vaccination certificate</p>
                </div>
            </div>
        </div>

        <form action="{{ route('clinic.vaccination-reports.store') }}" method="POST" class="p-6">
            @csrf

            <!-- Certificate Info -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-award text-red-600"></i> Certificate Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Certificate Number -->
                    <div>
                        <label for="certificate_number" class="block text-sm font-medium text-gray-700 mb-2">Certificate Number <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="text" name="certificate_number" id="certificate_number" 
                                value="{{ old('certificate_number', 'RAB-' . date('Y') . '-' . str_pad(\App\Models\RabiesVaccinationReport::count() + 1, 6, '0', STR_PAD_LEFT)) }}" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-gray-50 @error('certificate_number') border-red-500 @enderror"
                                required readonly>
                            <button type="button" onclick="generateCertNumber()" class="absolute right-2 top-1/2 transform -translate-y-1/2 px-3 py-1 text-xs bg-blue-100 text-blue-600 rounded hover:bg-blue-200 transition">
                                Regenerate
                            </button>
                        </div>
                        @error('certificate_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Vaccination Date -->
                    <div>
                        <label for="vaccination_date" class="block text-sm font-medium text-gray-700 mb-2">Vaccination Date <span class="text-red-500">*</span></label>
                        <input type="date" name="vaccination_date" id="vaccination_date" value="{{ old('vaccination_date', date('Y-m-d')) }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('vaccination_date') border-red-500 @enderror" required>
                        @error('vaccination_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Owner Information -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-person text-blue-600"></i> Owner Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Owner Name -->
                    <div>
                        <label for="owner_name" class="block text-sm font-medium text-gray-700 mb-2">Owner Name <span class="text-red-500">*</span></label>
                        <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('owner_name') border-red-500 @enderror"
                            placeholder="Full name of owner" required>
                        @error('owner_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contact Number -->
                    <div>
                        <label for="contact_number" class="block text-sm font-medium text-gray-700 mb-2">Contact Number <span class="text-red-500">*</span></label>
                        <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('contact_number') border-red-500 @enderror"
                            placeholder="Contact number" required>
                        @error('contact_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label for="owner_address" class="block text-sm font-medium text-gray-700 mb-2">Address <span class="text-red-500">*</span></label>
                        <textarea name="owner_address" id="owner_address" rows="2"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('owner_address') border-red-500 @enderror"
                            placeholder="Complete address" required>{{ old('owner_address') }}</textarea>
                        @error('owner_address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Animal Information -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-hearts text-red-600"></i> Animal Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Animal Type -->
                    <div>
                        <label for="animal_type" class="block text-sm font-medium text-gray-700 mb-2">Animal Type <span class="text-red-500">*</span></label>
                        <select name="animal_type" id="animal_type" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('animal_type') border-red-500 @enderror" required>
                            <option value="">Select animal type</option>
                            <option value="dog" {{ old('animal_type') == 'dog' ? 'selected' : '' }}>Dog</option>
                            <option value="cat" {{ old('animal_type') == 'cat' ? 'selected' : '' }}>Cat</option>
                            <option value="other" {{ old('animal_type') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('animal_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Breed -->
                    <div>
                        <label for="animal_breed" class="block text-sm font-medium text-gray-700 mb-2">Breed</label>
                        <input type="text" name="animal_breed" id="animal_breed" value="{{ old('animal_breed') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                            placeholder="e.g., Labrador, Persian">
                    </div>

                    <!-- Color/Markings -->
                    <div>
                        <label for="animal_color" class="block text-sm font-medium text-gray-700 mb-2">Color/Markings</label>
                        <input type="text" name="animal_color" id="animal_color" value="{{ old('animal_color') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                            placeholder="e.g., Brown with white spots">
                    </div>

                    <!-- Sex -->
                    <div>
                        <label for="animal_sex" class="block text-sm font-medium text-gray-700 mb-2">Sex</label>
                        <select name="animal_sex" id="animal_sex" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                            <option value="">Select sex</option>
                            <option value="male" {{ old('animal_sex') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('animal_sex') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <!-- Age -->
                    <div>
                        <label for="animal_age" class="block text-sm font-medium text-gray-700 mb-2">Age (years)</label>
                        <input type="number" name="animal_age" id="animal_age" value="{{ old('animal_age') }}" min="0" step="0.5"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                            placeholder="Age in years">
                    </div>

                    <!-- Weight -->
                    <div>
                        <label for="animal_weight" class="block text-sm font-medium text-gray-700 mb-2">Weight (kg)</label>
                        <input type="number" name="animal_weight" id="animal_weight" value="{{ old('animal_weight') }}" min="0" step="0.1"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                            placeholder="Weight in kg">
                    </div>
                </div>
            </div>

            <!-- Vaccination Details -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-eyedropper text-red-600"></i> Vaccination Details
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Vaccine Brand -->
                    <div>
                        <label for="vaccine_brand" class="block text-sm font-medium text-gray-700 mb-2">Vaccine Brand <span class="text-red-500">*</span></label>
                        <input type="text" name="vaccine_brand" id="vaccine_brand" value="{{ old('vaccine_brand') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('vaccine_brand') border-red-500 @enderror"
                            placeholder="e.g., Rabisin, Nobivac" required>
                        @error('vaccine_brand')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Batch Number -->
                    <div>
                        <label for="vaccine_batch" class="block text-sm font-medium text-gray-700 mb-2">Batch Number</label>
                        <input type="text" name="vaccine_batch" id="vaccine_batch" value="{{ old('vaccine_batch') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                            placeholder="Vaccine batch number">
                    </div>

                    <!-- Serial Number -->
                    <div>
                        <label for="vaccine_serial" class="block text-sm font-medium text-gray-700 mb-2">Serial Number</label>
                        <input type="text" name="vaccine_serial" id="vaccine_serial" value="{{ old('vaccine_serial') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                            placeholder="Vaccine serial number">
                    </div>

                    <!-- Expiration Date -->
                    <div>
                        <label for="vaccine_expiration" class="block text-sm font-medium text-gray-700 mb-2">Expiration Date</label>
                        <input type="date" name="vaccine_expiration" id="vaccine_expiration" value="{{ old('vaccine_expiration') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                    </div>
                </div>
            </div>

            <!-- Veterinarian Information -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-person-badge text-blue-600"></i> Veterinarian Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Veterinarian Name -->
                    <div>
                        <label for="veterinarian_name" class="block text-sm font-medium text-gray-700 mb-2">Veterinarian Name <span class="text-red-500">*</span></label>
                        <input type="text" name="veterinarian_name" id="veterinarian_name" value="{{ old('veterinarian_name', auth()->user()->name) }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('veterinarian_name') border-red-500 @enderror"
                            placeholder="Name of attending veterinarian" required>
                        @error('veterinarian_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- License Number -->
                    <div>
                        <label for="veterinarian_license" class="block text-sm font-medium text-gray-700 mb-2">License Number</label>
                        <input type="text" name="veterinarian_license" id="veterinarian_license" value="{{ old('veterinarian_license') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                            placeholder="Veterinarian license number">
                    </div>
                </div>
            </div>

            <!-- Next Vaccination Due -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-calendar-check text-green-600"></i> Next Vaccination
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Next Due Date -->
                    <div>
                        <label for="next_vaccination_date" class="block text-sm font-medium text-gray-700 mb-2">Next Due Date</label>
                        <input type="date" name="next_vaccination_date" id="next_vaccination_date" value="{{ old('next_vaccination_date') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                    </div>
                </div>
            </div>

            <!-- Remarks -->
            <div class="mb-8">
                <label for="remarks" class="block text-sm font-medium text-gray-700 mb-2">Remarks</label>
                <textarea name="remarks" id="remarks" rows="3"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                    placeholder="Additional notes or observations">{{ old('remarks') }}</textarea>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.vaccination-reports.index') }}" class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition shadow-sm">
                    <i class="bi bi-check-lg mr-2"></i>Issue Certificate
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function generateCertNumber() {
    const year = new Date().getFullYear();
    const random = Math.floor(Math.random() * 999999).toString().padStart(6, '0');
    document.getElementById('certificate_number').value = 'RAB-' + year + '-' + random;
}
</script>
@endpush
@endsection
