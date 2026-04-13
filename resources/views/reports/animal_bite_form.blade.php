@extends('layouts.admin')

@section('title', 'Animal Bite Report')

@section('header', 'Animal Bite Incident Report')
@section('subheader', 'Record and track animal bite incidents')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('clinic.bite-reports.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition">
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

        <form action="{{ route('clinic.bite-reports.store') }}" method="POST" class="p-6">
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
                                value="{{ old('case_number', $caseNumber ?? 'BITE-' . date('Y') . '-' . str_pad(App\Models\BiteRabiesReport::count() + 1, 5, '0', STR_PAD_LEFT)) }}" 
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
                    <i class="bi bi-person text-blue-600"></i> II. Patient (Human) Info
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Last Name -->
                    <div>
                        <label for="victim_last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name <span class="text-red-500">*</span></label>
                        <input type="text" name="victim_last_name" id="victim_last_name" value="{{ old('victim_last_name') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition @error('victim_last_name') border-red-500 @enderror"
                            placeholder="Last name" required>
                        @error('victim_last_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- First Name -->
                    <div>
                        <label for="victim_first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name <span class="text-red-500">*</span></label>
                        <input type="text" name="victim_first_name" id="victim_first_name" value="{{ old('victim_first_name') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition @error('victim_first_name') border-red-500 @enderror"
                            placeholder="First name" required>
                        @error('victim_first_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Middle Name -->
                    <div>
                        <label for="victim_middle_name" class="block text-sm font-medium text-gray-700 mb-2">Middle Name</label>
                        <input type="text" name="victim_middle_name" id="victim_middle_name" value="{{ old('victim_middle_name') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                            placeholder="Middle name">
                    </div>

                    <!-- Case ID -->
                    <div>
                        <label for="victim_case_id" class="block text-sm font-medium text-gray-700 mb-2">Case ID</label>
                        <input type="text" name="victim_case_id" id="victim_case_id" value="{{ old('victim_case_id', $caseNumber ?? '') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50"
                            placeholder="For internal tracking" readonly>
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

                    <!-- Gender -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gender <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="flex items-center gap-3 cursor-pointer p-4 border border-gray-200 rounded-lg hover:bg-blue-50 transition">
                                <input type="radio" name="victim_sex" value="male" {{ old('victim_sex') == 'male' ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" required>
                                <span class="text-sm font-medium text-gray-700">Male</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer p-4 border border-gray-200 rounded-lg hover:bg-pink-50 transition">
                                <input type="radio" name="victim_sex" value="female" {{ old('victim_sex') == 'female' ? 'checked' : '' }}
                                    class="w-4 h-4 text-pink-600 border-gray-300 focus:ring-pink-500" required>
                                <span class="text-sm font-medium text-gray-700">Female</span>
                            </label>
                        </div>
                    </div>

                    <!-- Contact Number -->
                    <div>
                        <label for="victim_contact" class="block text-sm font-medium text-gray-700 mb-2">Contact Number</label>
                        <input type="text" name="victim_contact" id="victim_contact" value="{{ old('victim_contact') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                            placeholder="11 digits" maxlength="11">
                    </div>

                    <!-- Victim Barangay -->
                    <div>
                        <label for="victim_barangay" class="block text-sm font-medium text-gray-700 mb-2">Barangay</label>
                        <select name="victim_barangay" id="victim_barangay" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition">
                            <option value="">Select barangay</option>
                            @foreach($barangays ?? [] as $brgy)
                                <option value="{{ $brgy->barangay_name }}" {{ old('victim_barangay') == $brgy->barangay_name ? 'selected' : '' }}>{{ $brgy->barangay_name }}</option>
                            @endforeach
                        </select>
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

            <!-- Incident Location -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-geo-alt text-blue-600"></i> III. Incident Location
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Incident Barangay -->
                    <div>
                        <label for="incident_barangay" class="block text-sm font-medium text-gray-700 mb-2">Barangay <span class="text-red-500">*</span></label>
                        <select name="incident_barangay" id="incident_barangay" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition @error('incident_barangay') border-red-500 @enderror" required>
                            <option value="">Select barangay</option>
                            @foreach($barangays ?? [] as $brgy)
                                <option value="{{ $brgy->barangay_name }}" {{ old('incident_barangay') == $brgy->barangay_name ? 'selected' : '' }}>{{ $brgy->barangay_name }}</option>
                            @endforeach
                        </select>
                        @error('incident_barangay')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Exact Location -->
                    <div>
                        <label for="exact_location" class="block text-sm font-medium text-gray-700 mb-2">Exact Location</label>
                        <input type="text" name="exact_location" id="exact_location" value="{{ old('exact_location') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                            placeholder="Specific location description">
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
                            <option value="others" {{ old('animal_type') == 'others' ? 'selected' : '' }}>Others</option>
                        </select>
                        @error('animal_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ownership Status -->
                    <div>
                        <label for="ownership_status" class="block text-sm font-medium text-gray-700 mb-2">Ownership Status <span class="text-red-500">*</span></label>
                        <select name="ownership_status" id="ownership_status" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition @error('ownership_status') border-red-500 @enderror" required>
                            <option value="">Select ownership</option>
                            <option value="owned" {{ old('ownership_status') == 'owned' ? 'selected' : '' }}>Owned</option>
                            <option value="stray" {{ old('ownership_status') == 'stray' ? 'selected' : '' }}>Stray</option>
                            <option value="wild" {{ old('ownership_status') == 'wild' ? 'selected' : '' }}>Wild</option>
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

            <!-- Post-Exposure Prophylaxis (PEP) -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-shield-plus text-green-600"></i> Post-Exposure Prophylaxis (PEP)
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="flex items-center gap-3 cursor-pointer p-4 border border-gray-200 rounded-lg hover:bg-green-50 transition bg-green-50 border-green-200">
                        <input type="radio" name="pep" value="yes" {{ old('pep') == 'yes' ? 'checked' : '' }}
                            class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500">
                        <div>
                            <span class="text-sm font-medium text-gray-700">Yes</span>
                        </div>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <input type="radio" name="pep" value="no" {{ old('pep', 'no') == 'no' ? 'checked' : '' }}
                            class="w-4 h-4 text-gray-600 border-gray-300 focus:ring-gray-500">
                        <div>
                            <span class="text-sm font-medium text-gray-700">No</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Wound Management -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-bandage text-red-600"></i> Wound Management
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <label class="flex items-center gap-3 cursor-pointer p-4 border border-gray-200 rounded-lg hover:bg-blue-50 transition">
                        <input type="checkbox" name="wound_management[]" value="washed_with_soap" {{ is_array(old('wound_management')) && in_array('washed_with_soap', old('wound_management')) ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="text-sm text-gray-700">Washed with Soap</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer p-4 border border-gray-200 rounded-lg hover:bg-blue-50 transition">
                        <input type="checkbox" name="wound_management[]" value="antiseptic_applied" {{ is_array(old('wound_management')) && in_array('antiseptic_applied', old('wound_management')) ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="text-sm text-gray-700">Antiseptic Applied</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <input type="checkbox" name="wound_management[]" value="none" {{ is_array(old('wound_management')) && in_array('none', old('wound_management')) ? 'checked' : '' }}
                            class="w-5 h-5 text-gray-600 border-gray-300 rounded focus:ring-gray-500">
                        <span class="text-sm text-gray-700">None</span>
                    </label>
                </div>
            </div>

            <!-- Hospital Referred -->
            <div class="mb-8">
                <label for="hospital_referred" class="block text-sm font-medium text-gray-700 mb-2">Reporting Facility</label>
                <input type="text" name="hospital_referred" id="hospital_referred" value="{{ Auth::user()->name ?? '' }}" 
                    class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50" readonly
                    placeholder="Reporting facility">
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
                <a href="{{ route('clinic.bite-reports.index') }}" class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium transition">
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
