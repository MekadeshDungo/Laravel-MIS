@extends('layouts.admin')

@section('title', 'Vaccination Report Details')

@section('header', 'Vaccination Report Details')
@section('subheader', 'Rabies vaccination record information')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.vaccination-reports.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Vaccination Reports</span>
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 bg-green-50 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Vaccination Record</h2>
                    <p class="text-sm text-gray-600">Recorded on {{ $report->created_at->format('M d, Y H:i') }}</p>
                </div>
                <span class="px-3 py-1 text-sm font-medium rounded-full 
                    @if($report->status === 'pending') bg-yellow-100 text-yellow-700
                    @elseif($report->status === 'adverse_reaction') bg-red-100 text-red-700
                    @else bg-green-100 text-green-700 @endif">
                    {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                </span>
            </div>
        </div>

        <!-- Clinic Information -->
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Clinic Information</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-xs text-gray-500">Clinic Name</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->clinic_name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Vaccinated By</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->user->name ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Patient Information -->
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Patient (Owner) Information</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-xs text-gray-500">Full Name</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->patient_name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Contact Number</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->patient_contact ?? 'N/A' }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-xs text-gray-500">Address</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->patient_address ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Pet Information -->
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Pet Information</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-xs text-gray-500">Pet Name</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->pet_name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Species</p>
                    <p class="text-sm font-medium text-gray-800">{{ ucfirst($report->pet_species) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Breed</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->pet_breed ?? 'Unknown' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Age</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->pet_age ?? 'N/A' }} years</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Gender</p>
                    <p class="text-sm font-medium text-gray-800">{{ ucfirst($report->pet_gender) ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Color</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->pet_color ?? 'Unknown' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Weight</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->weight ? $report->weight . ' kg' : 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Vaccination Details -->
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Vaccination Details</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-xs text-gray-500">Vaccination Date</p>
                    <p class="text-sm font-medium text-gray-800">{{ \Carbon\Carbon::parse($report->vaccination_date)->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Vaccination Time</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->vaccination_time }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Vaccination Type</p>
                    <p class="text-sm font-medium text-gray-800">{{ ucfirst($report->vaccination_type) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Vaccine Brand</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->vaccine_brand }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Batch Number</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->vaccine_batch_number ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Next Vaccination</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->next_vaccination_date ? \Carbon\Carbon::parse($report->next_vaccination_date)->format('M d, Y') : 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Observations -->
        @if($report->observations)
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Observations</h3>
            <p class="text-sm text-gray-700">{{ $report->observations }}</p>
        </div>
        @endif

        <!-- Notes -->
        @if($report->notes)
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Notes</h3>
            <p class="text-sm text-gray-700">{{ $report->notes }}</p>
        </div>
        @endif

        <!-- Actions -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.vaccination-reports.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition">
                    Close
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
