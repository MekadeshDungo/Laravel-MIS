@extends('layouts.admin')

@section('title', 'Animal Bite Report')

@section('header', 'Animal Bite Incident Report')
@section('subheader', 'Record and track animal bite incidents')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.bite-reports.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Bite Reports</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-yellow-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-yellow-600 rounded-lg flex items-center justify-center">
                    <i class="bi bi-exclamation-triangle text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Animal Bite Incident Report</h3>
                    <p class="text-sm text-gray-500">Fill in all required information to record an animal bite incident</p>
                </div>
            </div>
        </div>

        <form action="{{ route('barangay.reports.store') }}" method="POST" class="p-6">
            @csrf

            <!-- Case Info -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-file-text text-yellow-600"></i> Case Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Case Number -->
                    <div>
                        <label for="case_number" class="block text-sm font-medium text-gray-700 mb-2">Case Number <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="text" name="case_number" id="case_number" 
                                value="{{ old('case_number', 'BITE-' . date('Y') . '-' . str_pad(\App\Models\AnimalBiteReport::count() + 1, 5, '0', STR_PAD_LEFT)) }}" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition bg-gray-50 @error('case_number') border-red-500 @enderror"
                                required readonly>
                            <button type="button" onclick="generateCaseNumber()" class="absolute right-2 top-1/2 transform -translate-y-1/2 px-3 py-1 text-xs bg-blue-100 text-blue-600 rounded hover:bg-blue-200 transition">
                                Regenerate
                            </button>
                        </div>
                        @error('case_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Incident Date -->
                    <div>
                        <label for="incident_date" class="block text-sm font-medium text-gray-700 mb-2">Incident Date <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="incident_date" id="incident_date" value="{{ old('incident_date') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition @error('incident_date') border-red-500 @enderror" required>
                        @error('incident_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Victim Information -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-person text-blue-600"></i> Victim Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Victim Name -->
                    <div>
                        <label for="victim_name" class="block text-sm font-medium text-gray-700 mb-2">Victim Name <span class="text-red-500">*</span></label>
                        <input type="text" name="victim_name" id="victim_name" value="{{ old('victim_name') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition @error('victim_name') border-red-500 @enderror"
                            placeholder="Full name of victim" required>
                        @error('victim_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Age -->
                    <div>
                        <label for="victim_age" class="block text-sm font-medium text-gray-700 mb-2">Age <span class="text-red-500">*</span></label>
                        <input type="number" name="victim_age" id="victim_age" value="{{ old('victim_age') }}" min="0"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition @error('victim_age') border-red-500 @enderror"
                            required>
                        @error('victim_age')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sex -->
                    <div>
                        <label for="victim_sex" class="block text-sm font-medium text-gray-700 mb-2">Sex <span class="text-red-500">*</span></label>
                        <select name="victim_sex" id="victim_sex" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition @error('victim_sex') border-red-500 @enderror" required>
                            <option value="">Select sex</option>
                            <option value="male" {{ old('victim_sex') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('victim_sex') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('victim_sex')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contact Number -->
                    <div>
                        <label for="victim_contact" class="block text-sm font-medium text-gray-700 mb-2">Contact Number</label>
                        <input type="text" name="victim_contact" id="victim_contact" value="{{ old('victim_contact') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                            placeholder="Contact number">
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label for="victim_address" class="block text-sm font-medium text-gray-700 mb-2">Address <span class="text-red-500">*</span></label>
                        <textarea name="victim_address" id="victim_address" rows="2"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition @error('victim_address') border-red-500 @enderror"
                            placeholder="Complete address" required>{{ old('victim_address') }}</textarea>
                        @error('victim_address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Animal Information -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-bug text-yellow-600"></i> Animal Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Animal Type -->
                    <div>
                        <label for="animal_type" class="block text-sm font-medium text-gray-700 mb-2">Animal Type <span class="text-red-500">*</span></label>
                        <select name="animal_type" id="animal_type" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition @error('animal_type') border-red-500 @enderror" required>
                            <option value="">Select animal</option>
                            <option value="dog" {{ old('animal_type') == 'dog' ? 'selected' : '' }}>Dog</option>
                            <option value="cat" {{ old('animal_type') == 'cat' ? 'selected' : '' }}>Cat</option>
                            <option value="monkey" {{ old('animal_type') == 'monkey' ? 'selected' : '' }}>Monkey</option>
                            <option value="bat" {{ old('animal_type') == 'bat' ? 'selected' : '' }}>Bat</option>
                            <option value="rat" {{ old('animal_type') == 'rat' ? 'selected' : '' }}>Rat</option>
                            <option value="other" {{ old('animal_type') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('animal_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Animal Status -->
                    <div>
                        <label for="animal_status" class="block text-sm font-medium text-gray-700 mb-2">Animal Status <span class="text-red-500">*</span></label>
                        <select name="animal_status" id="animal_status" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition @error('animal_status') border-red-500 @enderror" required>
                            <option value="">Select status</option>
                            <option value="healthy" {{ old('animal_status') == 'healthy' ? 'selected' : '' }}>Healthy</option>
                            <option value="suspect" {{ old('animal_status') == 'suspect' ? 'selected' : '' }}>Suspect</option>
                            <option value="rabid" {{ old('animal_status') == 'rabid' ? 'selected' : '' }}>Rabid</option>
                            <option value="dead" {{ old('animal_status') == 'dead' ? 'selected' : '' }}>Dead</option>
                            <option value="unknown" {{ old('animal_status') == 'unknown' ? 'selected' : '' }}>Unknown</option>
                        </select>
                        @error('animal_status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ownership -->
                    <div>
                        <label for="ownership_status" class="block text-sm font-medium text-gray-700 mb-2">Ownership <span class="text-red-500">*</span></label>
                        <select name="ownership_status" id="ownership_status" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition @error('ownership_status') border-red-500 @enderror" required>
                            <option value="">Select ownership</option>
                            <option value="owned" {{ old('ownership_status') == 'owned' ? 'selected' : '' }}>Owned</option>
                            <option value="stray" {{ old('ownership_status') == 'stray' ? 'selected' : '' }}>Stray</option>
                            <option value="wild" {{ old('ownership_status') == 'wild' ? 'selected' : '' }}>Wild</option>
                            <option value="unknown" {{ old('ownership_status') == 'unknown' ? 'selected' : '' }}>Unknown</option>
                        </select>
                        @error('ownership_status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Vaccination Status -->
                    <div>
                        <label for="vaccination_status" class="block text-sm font-medium text-gray-700 mb-2">Vaccination Status</label>
                        <select name="vaccination_status" id="vaccination_status" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition">
                            <option value="">Select status</option>
                            <option value="vaccinated" {{ old('vaccination_status') == 'vaccinated' ? 'selected' : '' }}>Vaccinated</option>
                            <option value="unvaccinated" {{ old('vaccination_status') == 'unvaccinated' ? 'selected' : '' }}>Unvaccinated</option>
                            <option value="unknown" {{ old('vaccination_status') == 'unknown' ? 'selected' : 'unknown' }}>Unknown</option>
                        </select>
                    </div>

                    <!-- Bite Category -->
                    <div>
                        <label for="bite_category" class="block text-sm font-medium text-gray-700 mb-2">Bite Category <span class="text-red-500">*</span></label>
                        <select name="bite_category" id="bite_category" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition @error('bite_category') border-red-500 @enderror" required>
                            <option value="">Select category</option>
                            <option value="category_i" {{ old('bite_category') == 'category_i' ? 'selected' : '' }}>Category I (Touch/Feed)</option>
                            <option value="category_ii" {{ old('bite_category') == 'category_ii' ? 'selected' : '' }}>Category II (Minor Scratch)</option>
                            <option value="category_iii" {{ old('bite_category') == 'category_iii' ? 'selected' : '' }}>Category III (Severe)</option>
                        </select>
                        @error('bite_category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Body Part -->
                    <div>
                        <label for="body_part" class="block text-sm font-medium text-gray-700 mb-2">Body Part Bitten <span class="text-red-500">*</span></label>
                        <input type="text" name="body_part" id="body_part" value="{{ old('body_part') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition @error('body_part') border-red-500 @enderror"
                            placeholder="e.g., Left arm, Right leg" required>
                        @error('body_part')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Incident Location -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-geo-alt text-blue-600"></i> Incident Location
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Barangay -->
                    <div>
                        <label for="barangay" class="block text-sm font-medium text-gray-700 mb-2">Barangay <span class="text-red-500">*</span></label>
                        <input type="text" name="barangay" id="barangay" value="{{ old('barangay') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition @error('barangay') border-red-500 @enderror"
                            placeholder="Barangay where incident occurred" required>
                        @error('barangay')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- District/Municipality -->
                    <div>
                        <label for="district" class="block text-sm font-medium text-gray-700 mb-2">District/Municipality</label>
                        <input type="text" name="district" id="district" value="{{ old('district') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                            placeholder="District or municipality">
                    </div>

                    <!-- Specific Location -->
                    <div class="md:col-span-2">
                        <label for="location_description" class="block text-sm font-medium text-gray-700 mb-2">Specific Location</label>
                        <textarea name="location_description" id="location_description" rows="2"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                            placeholder="Describe the exact location where the incident occurred">{{ old('location_description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Treatment Information -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-hospital text-green-600"></i> Treatment Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Wound Care -->
                    <div>
                        <label class="flex items-center gap-3 cursor-pointer p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <input type="checkbox" name="wound_care" value="1" {{ old('wound_care') ? 'checked' : '' }}
                                class="w-5 h-5 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500">
                            <span class="text-sm text-gray-700">Wound care provided</span>
                        </label>
                    </div>

                    <!-- RIG Given -->
                    <div>
                        <label class="flex items-center gap-3 cursor-pointer p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <input type="checkbox" name="rig_given" value="1" {{ old('rig_given') ? 'checked' : '' }}
                                class="w-5 h-5 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500">
                            <span class="text-sm text-gray-700">RIG (Rabies Immunoglobulin) given</span>
                        </label>
                    </div>

                    <!-- Vaccine Given -->
                    <div>
                        <label class="flex items-center gap-3 cursor-pointer p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <input type="checkbox" name="vaccine_given" value="1" {{ old('vaccine_given') ? 'checked' : '' }}
                                class="w-5 h-5 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500">
                            <span class="text-sm text-gray-700">Anti-rabies vaccine started</span>
                        </label>
                    </div>

                    <!-- Hospital Referred -->
                    <div>
                        <label for="hospital_referred" class="block text-sm font-medium text-gray-700 mb-2">Hospital Referred</label>
                        <input type="text" name="hospital_referred" id="hospital_referred" value="{{ old('hospital_referred') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                            placeholder="Hospital or clinic name">
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-toggle-on text-blue-600"></i> Case Status
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <label class="flex items-center gap-3 cursor-pointer p-4 border border-gray-200 rounded-lg hover:bg-yellow-50 transition bg-yellow-50 border-yellow-200">
                        <input type="radio" name="status" value="pending" {{ old('status', 'pending') == 'pending' ? 'checked' : '' }}
                            class="w-4 h-4 text-yellow-600 border-gray-300 focus:ring-yellow-500">
                        <div>
                            <span class="text-sm font-medium text-gray-700">Pending</span>
                            <p class="text-xs text-gray-500">Case awaiting follow-up</p>
                        </div>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer p-4 border border-gray-200 rounded-lg hover:bg-blue-50 transition">
                        <input type="radio" name="status" value="ongoing" {{ old('status') == 'ongoing' ? 'checked' : '' }}
                            class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                        <div>
                            <span class="text-sm font-medium text-gray-700">Ongoing</span>
                            <p class="text-xs text-gray-500">Case under investigation</p>
                        </div>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer p-4 border border-gray-200 rounded-lg hover:bg-green-50 transition">
                        <input type="radio" name="status" value="completed" {{ old('status') == 'completed' ? 'checked' : '' }}
                            class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500">
                        <div>
                            <span class="text-sm font-medium text-gray-700">Completed</span>
                            <p class="text-xs text-gray-500">Case closed</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Remarks -->
            <div class="mb-8">
                <label for="remarks" class="block text-sm font-medium text-gray-700 mb-2">Remarks</label>
                <textarea name="remarks" id="remarks" rows="3"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                    placeholder="Additional notes or observations">{{ old('remarks') }}</textarea>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.bite-reports.index') }}" class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-lg transition shadow-sm">
                    <i class="bi bi-check-lg mr-2"></i>Submit Report
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function generateCaseNumber() {
    const year = new Date().getFullYear();
    const random = Math.floor(Math.random() * 99999).toString().padStart(5, '0');
    document.getElementById('case_number').value = 'BITE-' + year + '-' + random;
}
</script>
@endpush
@endsection
