@extends('layouts.admin')

@section('title', 'Submit Bite Report')

@section('header', 'Submit Bite Incident Report')
@section('subheader', 'Report animal bite cases for disease surveillance')

@php
$rolePrefix = 'clinic';
@endphp

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Link -->
    <div class="mb-6">
        <a href="{{ route('clinic.bite-reports.index') }}" class="text-green-600 hover:text-green-800 inline-flex items-center">
            <i class="bi bi-arrow-left mr-2"></i>Back to Bite Reports
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('clinic.bite-reports.store') }}" class="space-y-6">
            @csrf

            <!-- Patient Information -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Patient Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Patient Name *</label>
                        <input type="text" name="patient_name" value="{{ old('patient_name') }}" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Age *</label>
                        <input type="number" name="patient_age" value="{{ old('patient_age') }}" required min="0" max="150"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gender *</label>
                        <select name="patient_gender" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('patient_gender') === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('patient_gender') === 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('patient_gender') === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number *</label>
                        <input type="text" name="patient_contact" value="{{ old('patient_contact') }}" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Address</label>
                        <input type="text" name="patient_full_address" value="{{ old('patient_full_address') }}"
                            placeholder="House No., Street, City, Province"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Barangay (for heatmap) *</label>
                        <select name="patient_barangay_id" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Select Barangay</option>
                            @foreach($barangays as $brgy)
                                <option value="{{ $brgy->barangay_id }}" {{ old('patient_barangay_id') == $brgy->barangay_id ? 'selected' : '' }}>
                                    {{ $brgy->barangay_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Incident Details -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Incident Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date of Incident *</label>
                        <input type="date" name="incident_date" value="{{ old('incident_date') }}" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nature of Incident *</label>
                        <select name="nature_of_incident" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Select Nature</option>
                            <option value="Bitten" {{ old('nature_of_incident') === 'Bitten' ? 'selected' : '' }}>Bitten</option>
                            <option value="Scratched" {{ old('nature_of_incident') === 'Scratched' ? 'selected' : '' }}>Scratched</option>
                            <option value="Licked (Open Wound)" {{ old('nature_of_incident') === 'Licked (Open Wound)' ? 'selected' : '' }}>Licked (Open Wound)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bite Site *</label>
                        <select name="bite_site" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Select Bite Site</option>
                            <option value="Head/Neck" {{ old('bite_site') === 'Head/Neck' ? 'selected' : '' }}>Head/Neck</option>
                            <option value="Upper Extremities" {{ old('bite_site') === 'Upper Extremities' ? 'selected' : '' }}>Upper Extremities</option>
                            <option value="Trunk" {{ old('bite_site') === 'Trunk' ? 'selected' : '' }}>Trunk</option>
                            <option value="Lower Extremities" {{ old('bite_site') === 'Lower Extremities' ? 'selected' : '' }}>Lower Extremities</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Exposure Category *</label>
                        <select name="exposure_category" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Select Category</option>
                            <option value="Category I (Lick)" {{ old('exposure_category') === 'Category I (Lick)' ? 'selected' : '' }}>Category I - Touch/feed animal</option>
                            <option value="Category II (Scratch)" {{ old('exposure_category') === 'Category II (Scratch)' ? 'selected' : '' }}>Category II - Nibble, minor scratch</option>
                            <option value="Category III (Bite / Deep)" {{ old('exposure_category') === 'Category III (Bite / Deep)' ? 'selected' : '' }}>Category III - Break in skin, licks on mucous membrane</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Animal Information -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Animal Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Animal Species *</label>
                        <select name="animal_species" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Select Species</option>
                            <option value="Dog" {{ old('animal_species') === 'Dog' ? 'selected' : '' }}>Dog</option>
                            <option value="Cat" {{ old('animal_species') === 'Cat' ? 'selected' : '' }}>Cat</option>
                            <option value="Other" {{ old('animal_species') === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Animal Status *</label>
                        <select name="animal_status" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Select Status</option>
                            <option value="Owned" {{ old('animal_status') === 'Owned' ? 'selected' : '' }}>Owned</option>
                            <option value="Stray" {{ old('animal_status') === 'Stray' ? 'selected' : '' }}>Stray</option>
                            <option value="Wild" {{ old('animal_status') === 'Wild' ? 'selected' : '' }}>Wild</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Animal Owner Name</label>
                        <input type="text" name="animal_owner_name" value="{{ old('animal_owner_name') }}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Vaccination Status</label>
                        <select name="animal_vaccination_status"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Select Status</option>
                            <option value="Vaccinated" {{ old('animal_vaccination_status') === 'Vaccinated' ? 'selected' : '' }}>Vaccinated</option>
                            <option value="Unvaccinated" {{ old('animal_vaccination_status') === 'Unvaccinated' ? 'selected' : '' }}>Unvaccinated</option>
                            <option value="Unknown" {{ old('animal_vaccination_status') === 'Unknown' ? 'selected' : '' }}>Unknown</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Current Condition</label>
                        <select name="animal_current_condition"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Select Condition</option>
                            <option value="Healthy / Alive" {{ old('animal_current_condition') === 'Healthy / Alive' ? 'selected' : '' }}>Healthy / Alive</option>
                            <option value="Dead" {{ old('animal_current_condition') === 'Dead' ? 'selected' : '' }}>Dead</option>
                            <option value="Missing / Escaped" {{ old('animal_current_condition') === 'Missing / Escaped' ? 'selected' : '' }}>Missing / Escaped</option>
                            <option value="Euthanized" {{ old('animal_current_condition') === 'Euthanized' ? 'selected' : '' }}>Euthanized</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Medical Treatment -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Wound Management</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Wound Management</label>
                        <div class="space-y-2">
                            @php
                                $woundOptions = ['Washing with soap and water', 'Povidone iodine application', 'Antibiotic ointment', 'Dressing', 'Suturing', 'Tetanus toxoid'];
                            @endphp
                            @foreach($woundOptions as $option)
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="wound_management[]" value="{{ $option }}" 
                                        {{ is_array(old('wound_management')) && in_array($option, old('wound_management')) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                                    <span class="ml-2 text-sm text-gray-700">{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Post-Exposure Prophylaxis (PEP)</label>
                        <select name="post_exposure_prophylaxis"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Select PEP</option>
                            <option value="Yes" {{ old('post_exposure_prophylaxis') === 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No" {{ old('post_exposure_prophylaxis') === 'No' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Additional Notes -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Additional Notes</label>
                <textarea name="notes" rows="3"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500"
                    placeholder="Any additional information...">{{ old('notes') }}</textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">
                    <i class="bi bi-check-circle mr-2"></i>Submit Report
                </button>
            </div>
        </form>
    </div>
</div>
@endsection