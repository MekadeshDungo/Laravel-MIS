@extends('layouts.admin')

@section('title', 'Bite Report Details')

@section('header', 'Bite Report Details')
@section('subheader', 'View bite incident report')

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

    <!-- Report Details -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-6">Report #{{ $report->report_number }}</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Status -->
            <div>
                <p class="text-sm text-gray-500">Status</p>
                <p class="font-medium">{{ $report->status }}</p>
            </div>

            <!-- Date Reported -->
            <div>
                <p class="text-sm text-gray-500">Date Reported</p>
                <p class="font-medium text-gray-800">{{ $report->date_reported ? (is_string($report->date_reported) ? \Carbon\Carbon::parse($report->date_reported)->format('M d, Y') : $report->date_reported->format('M d, Y')) : 'N/A' }}</p>
            </div>

            <!-- Patient Name -->
            <div>
                <p class="text-sm text-gray-500">Patient Name</p>
                <p class="font-medium text-gray-800">{{ $report->patient_name }}</p>
            </div>

            <!-- Patient Age -->
            <div>
                <p class="text-sm text-gray-500">Patient Age</p>
                <p class="font-medium text-gray-800">{{ $report->age ?? 'N/A' }}</p>
            </div>

            <!-- Patient Gender -->
            <div>
                <p class="text-sm text-gray-500">Gender</p>
                <p class="font-medium text-gray-800">{{ ucfirst($report->gender) ?? 'N/A' }}</p>
            </div>

            <!-- Patient Contact -->
            <div>
                <p class="text-sm text-gray-500">Contact</p>
                <p class="font-medium text-gray-800">{{ $report->patient_contact ?? 'N/A' }}</p>
            </div>

            <!-- Patient Barangay -->
            <div>
                <p class="text-sm text-gray-500">Address (Barangay)</p>
                <p class="font-medium text-gray-800">{{ $report->barangay->barangay_name ?? ($report->patient_barangay ?? 'N/A') }}</p>
            </div>
        </div>

        <div class="border-t border-gray-200 mt-6 pt-6">
            <h3 class="text-base font-semibold text-gray-800 mb-4">Incident Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Incident Date -->
                <div>
                    <p class="text-sm text-gray-500">Incident Date</p>
                    <p class="font-medium text-gray-800">{{ $report->incident_date ? (is_string($report->incident_date) ? \Carbon\Carbon::parse($report->incident_date)->format('M d, Y') : $report->incident_date->format('M d, Y')) : 'N/A' }}</p>
                </div>

                <!-- Nature of Incident -->
                <div>
                    <p class="text-sm text-gray-500">Nature of Incident</p>
                    <p class="font-medium text-gray-800">{{ ucfirst($report->exposure_type) ?? 'N/A' }}</p>
                </div>

                <!-- Bite Site -->
                <div>
                    <p class="text-sm text-gray-500">Bite Site</p>
                    <p class="font-medium text-gray-800">{{ $report->bite_site ?? 'N/A' }}</p>
                </div>

                <!-- Exposure Category -->
                <div>
                    <p class="text-sm text-gray-500">Exposure Category</p>
                    <p class="font-medium text-gray-800">{{ $report->category ? 'Category ' . $report->category : 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200 mt-6 pt-6">
            <h3 class="text-base font-semibold text-gray-800 mb-4">Animal Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Animal Species -->
                <div>
                    <p class="text-sm text-gray-500">Animal Species</p>
                    <p class="font-medium text-gray-800">{{ ucfirst($report->animal_type) ?? 'N/A' }}</p>
                </div>

                <!-- Animal Status -->
                <div>
                    <p class="text-sm text-gray-500">Animal Status</p>
                    <p class="font-medium text-gray-800">{{ ucfirst($report->animal_status) ?? 'N/A' }}</p>
                </div>

                <!-- Animal Owner Name -->
                <div>
                    <p class="text-sm text-gray-500">Owner Name</p>
                    <p class="font-medium text-gray-800">{{ $report->animal_owner_name ?? 'N/A' }}</p>
                </div>

                <!-- Animal Vaccination Status -->
                <div>
                    <p class="text-sm text-gray-500">Vaccination Status</p>
                    <p class="font-medium text-gray-800">{{ ucfirst($report->vaccination_status) ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        @if($report->wound_management || $report->post_exposure_prophylaxis || $report->notes)
        <div class="border-t border-gray-200 mt-6 pt-6">
            <h3 class="text-base font-semibold text-gray-800 mb-4">Treatment Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Wound Management -->
                <div>
                    <p class="text-sm text-gray-500">Wound Management</p>
                    @php
                        $woundMgmt = is_array($report->wound_management) ? $report->wound_management : (is_string($report->wound_management) ? json_decode($report->wound_management, true) : []);
                    @endphp
                    <p class="font-medium text-gray-800">
                        @if(is_array($woundMgmt) && count($woundMgmt) > 0)
                            {{ implode(', ', $woundMgmt) }}
                        @elseif(is_string($report->wound_management))
                            {{ $report->wound_management }}
                        @else
                            N/A
                        @endif
                    </p>
                </div>

                <!-- Post Exposure Prophylaxis -->
                <div>
                    <p class="text-sm text-gray-500">Post Exposure Prophylaxis</p>
                    <p class="font-medium text-gray-800">{{ $report->post_exposure_prophylaxis ?? 'N/A' }}</p>
                </div>
            </div>

            @if($report->notes)
            <div class="mt-4">
                <p class="text-sm text-gray-500">Notes</p>
                <p class="font-medium text-gray-800">{{ $report->notes }}</p>
            </div>
            @endif
        </div>
        @endif

        <!-- Reporting Facility -->
        <div class="border-t border-gray-200 mt-6 pt-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Reporting Facility</p>
                    <p class="font-medium text-gray-800">{{ $report->reporting_facility ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Facility Name</p>
                    <p class="font-medium text-gray-800">{{ $report->facility_name ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection