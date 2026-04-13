@extends('layouts.admin')

@section('title', 'Bite Report Details')

@section('header', 'Bite Report Details')
@section('subheader', 'Animal bite incident information')

@php
$rolePrefix = str_replace('_', '-', auth()->user()->getRoleAttribute() ?? 'clinic');
$backRoute = $rolePrefix . '.bite-reports.index';
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
                    <h2 class="text-lg font-semibold text-gray-800">Report #{{ $report->report_number }}</h2>
                    <p class="text-sm text-gray-600">Date Reported: {{ $report->created_at->format('M d, Y') }}</p>
                </div>
                <span class="px-3 py-1 text-sm font-medium rounded-full
                    @if($report->status === 'Pending Review') bg-yellow-100 text-yellow-700
                    @elseif($report->status === 'Under Investigation') bg-blue-100 text-blue-700
                    @else bg-green-100 text-green-700 @endif">
                    {{ $report->status }}
                </span>
            </div>
        </div>

        <!-- Patient (Human) Information -->
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">II. Patient (Human) Info</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-xs text-gray-500">Last Name</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->patient_name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">First Name</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->patient_first_name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Middle Name</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->patient_middle_name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Suffix</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->patient_suffix ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Age</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->age ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Gender</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->gender ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Contact Number</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->patient_contact ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Barangay</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->patient_barangay ?? 'N/A' }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-xs text-gray-500">Address</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->patient_address ?? 'N/A' }}</p>
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
                    <p class="text-xs text-gray-500">Ownership Status</p>
                    <p class="text-sm font-medium text-gray-800">{{ ucfirst($report->animal_status) ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Vaccination Status</p>
                    <p class="text-sm font-medium text-gray-800">{{ ucfirst($report->vaccination_status) ?? 'Unknown' }}</p>
                </div>
            </div>
        </div>

        <!-- Incident Details -->
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Incident Details</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-xs text-gray-500">Incident Date</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->incident_date ? \Carbon\Carbon::parse($report->incident_date)->format('M d, Y') : 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Exposure Type</p>
                    <p class="text-sm font-medium text-gray-800">{{ ucfirst($report->exposure_type) ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Category</p>
                    <p class="text-sm font-medium text-gray-800">Category {{ $report->category ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Body Part Bitten</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->bite_site ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Barangay</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->incident_barangay ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Exact Location</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->exact_location ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Treatment Information -->
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Treatment Information</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-xs text-gray-500">Post-Exposure Prophylaxis (PEP)</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->post_exposure_prophylaxis ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Wound Management</p>
                    <p class="text-sm font-medium text-gray-800">
                        @if(is_array($report->wound_management))
                            {{ implode(', ', $report->wound_management) }}
                        @else
                            {{ $report->wound_management ?? 'N/A' }}
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Reporting Facility -->
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Reporting Facility</h3>
            <p class="text-sm font-medium text-gray-800">{{ $report->reporting_facility ?? 'N/A' }}</p>
        </div>

        <!-- Notes -->
        @if($report->notes)
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Notes</h3>
            <p class="text-sm text-gray-800">{{ $report->notes }}</p>
        </div>
        @endif
    </div>
</div>
@endsection
