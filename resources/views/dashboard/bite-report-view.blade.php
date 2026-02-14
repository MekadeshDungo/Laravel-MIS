@extends('layouts.admin')

@section('title', 'Bite Report Details')

@section('header', 'Bite Report Details')
@section('subheader', 'Animal bite incident information')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.bite-reports.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Bite Reports</span>
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 bg-red-50 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Case #{{ $report->case_number }}</h2>
                    <p class="text-sm text-gray-600">Reported on {{ $report->created_at->format('M d, Y H:i') }}</p>
                </div>
                <span class="px-3 py-1 text-sm font-medium rounded-full 
                    @if($report->status === 'pending') bg-yellow-100 text-yellow-700
                    @elseif($report->status === 'investigating') bg-blue-100 text-blue-700
                    @else bg-green-100 text-green-700 @endif">
                    {{ ucfirst($report->status) }}
                </span>
            </div>
        </div>

        <!-- Victim Information -->
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Victim Information</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-xs text-gray-500">Full Name</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->victim_name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Age</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->victim_age ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Gender</p>
                    <p class="text-sm font-medium text-gray-800">{{ ucfirst($report->victim_gender) ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Contact Number</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->victim_contact ?? 'N/A' }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-xs text-gray-500">Address</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->victim_address }}</p>
                </div>
            </div>
        </div>

        <!-- Animal Information -->
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Animal Information</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-xs text-gray-500">Species</p>
                    <p class="text-sm font-medium text-gray-800">{{ ucfirst($report->animal_species) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Breed</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->animal_breed ?? 'Unknown' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Color/Markings</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->animal_color ?? 'Unknown' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Vaccination Status</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->vaccination_status ?? 'Unknown' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Current Status</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->animal_current_status ?? 'Unknown' }}</p>
                </div>
            </div>
        </div>

        <!-- Incident Details -->
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Incident Details</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-xs text-gray-500">Date of Bite</p>
                    <p class="text-sm font-medium text-gray-800">{{ \Carbon\Carbon::parse($report->bite_date)->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Time of Bite</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->bite_time ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Location</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->incident_location }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Body Part Bitten</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->body_part_bitten ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Severity</p>
                    <p class="text-sm font-medium text-gray-800">{{ ucfirst($report->severity) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Provoked/Unprovoked</p>
                    <p class="text-sm font-medium text-gray-800">{{ ucfirst($report->provoked_unprovoked) }}</p>
                </div>
            </div>
            @if($report->incident_description)
            <div class="mt-4">
                <p class="text-xs text-gray-500">Description</p>
                <p class="text-sm text-gray-700 mt-1">{{ $report->incident_description }}</p>
            </div>
            @endif
        </div>

        <!-- Medical Treatment -->
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Medical Treatment</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-xs text-gray-500">Wound Care Provided</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->wound_care ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Antibiotics</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->antibiotics ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Anti-rabies Vaccine</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->anti_rabies_vaccine ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">ERIG/HRIG</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->erig_hrig ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Tetanus Toxoid</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->tetanus_toxoid ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Owner Information -->
        @if($report->owner_name)
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Animal Owner Information</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-xs text-gray-500">Owner Name</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->owner_name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Contact Number</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->owner_contact ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Address</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->owner_address ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            <div class="flex items-center justify-end gap-3">
                @if($report->status === 'pending')
                <form action="{{ route('admin.bite-reports.update', $report) }}" method="POST" class="inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="investigating">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                        Start Investigation
                    </button>
                </form>
                @elseif($report->status === 'investigating')
                <form action="{{ route('admin.bite-reports.update', $report) }}" method="POST" class="inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="resolved">
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
                        Mark as Resolved
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
