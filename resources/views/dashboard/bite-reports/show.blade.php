@extends('layouts.admin')

@section('title', 'Bite Report Details')

@section('header', 'Bite Report Details')
@section('subheader', 'Animal bite incident information')

@php
$rolePrefix = str_replace('_', '-', auth()->user()->role ?? 'assistant-vet');
$backRoute = $rolePrefix . '.rabies-bite-reports.index';
@endphp

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route($backRoute) }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Bite Reports</span>
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 bg-red-50 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Case #{{ $report->id }}</h2>
                    <p class="text-sm text-gray-600">Reported on {{ $report->created_at->format('M d, Y H:i') }}</p>
                </div>
                <span class="px-3 py-1 text-sm font-medium rounded-full
                    @if($report->status === 'pending') bg-yellow-100 text-yellow-700
                    @elseif($report->status === 'open' || $report->status === 'investigating') bg-blue-100 text-blue-700
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
                    <p class="text-sm font-medium text-gray-800">{{ $report->victim_name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Age</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->victim_age ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Gender</p>
                    <p class="text-sm font-medium text-gray-800">{{ ucfirst($report->victim_gender) ?? 'N/A' }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-xs text-gray-500">Address</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->victim_address ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Reporter Information -->
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Reporter Information</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500">Reporter Name</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->reporter_name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Contact Number</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->reporter_contact ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Animal Information -->
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Animal Information</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-xs text-gray-500">Animal Type</p>
                    <p class="text-sm font-medium text-gray-800">{{ ucfirst($report->animal_type) ?? 'Unknown' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Vaccination Status</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->animal_vaccination_status ?? 'Unknown' }}</p>
                </div>
            </div>

            @if($report->animal_owner_name)
            <div class="mt-4 pt-4 border-t border-gray-100">
                <h4 class="text-xs font-semibold text-gray-500 uppercase mb-2">Owner Information</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500">Owner Name</p>
                        <p class="text-sm font-medium text-gray-800">{{ $report->animal_owner_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Owner Address</p>
                        <p class="text-sm font-medium text-gray-800">{{ $report->animal_owner_address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Incident Details -->
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Incident Details</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-xs text-gray-500">Date of Bite</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->bite_date ? \Carbon\Carbon::parse($report->bite_date)->format('M d, Y') : 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Time of Bite</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->bite_time ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Bite Category</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->bite_category ?? 'N/A' }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-xs text-gray-500">Location</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->bite_location ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Severity</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->bite_severity ?? 'N/A' }}</p>
                </div>
            </div>

            @if($report->bite_description)
            <div class="mt-4">
                <p class="text-xs text-gray-500">Description</p>
                <p class="text-sm text-gray-800 mt-1">{{ $report->bite_description }}</p>
            </div>
            @endif
        </div>

        <!-- Action Taken -->
        @if($report->action_taken)
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Action Taken</h3>
            <p class="text-sm text-gray-800">{{ $report->action_taken }}</p>
        </div>
        @endif

        <!-- Notes -->
        @if($report->notes)
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Notes</h3>
            <p class="text-sm text-gray-800">{{ $report->notes }}</p>
        </div>
        @endif

        <!-- Location -->
        @if($report->barangay)
        <div class="px-6 py-4">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Location</h3>
            <p class="text-sm font-medium text-gray-800">Barangay: {{ $report->barangay->barangay_name }}</p>
        </div>
        @endif
    </div>
</div>
@endsection
