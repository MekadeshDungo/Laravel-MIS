@extends('layouts.admin')

@section('title', 'Case Details')

@section('header', 'Exposure Case Details')
@section('subheader', $exposureCase->case_number)

@php
$rolePrefix = str_replace('_', '-', auth()->user()->role ?? 'city-vet');
@endphp

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Back & Actions -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <a href="{{ route($rolePrefix . '.exposure-cases.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-800 transition">
            <i class="bi bi-arrow-left mr-2"></i>Back to Cases
        </a>
        <div class="flex items-center gap-3">
            @if($exposureCase->status === 'pending')
                <form method="POST" action="{{ route($rolePrefix . '.exposure-cases.approve', $exposureCase) }}">
                    @csrf
                    <input type="hidden" name="action" value="approve">
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        <i class="bi bi-check-circle mr-1"></i>Approve
                    </button>
                </form>
                <form method="POST" action="{{ route($rolePrefix . '.exposure-cases.approve', $exposureCase) }}">
                    @csrf
                    <input type="hidden" name="action" value="reject">
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        <i class="bi bi-x-circle mr-1"></i>Reject
                    </button>
                </form>
            @endif
            @if($exposureCase->status !== 'closed')
                <form method="POST" action="{{ route($rolePrefix . '.exposure-cases.close', $exposureCase) }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                        <i class="bi bi-archive mr-1"></i>Close Case
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Status & Type Badge -->
    <div class="flex items-center gap-3 mb-6">
        @php
            $typeColors = [
                'bite' => 'bg-yellow-100 text-yellow-800',
                'suspected_rabies' => 'bg-orange-100 text-orange-800',
                'confirmed_rabies' => 'bg-red-100 text-red-800',
            ];
            $statusColors = [
                'pending' => 'bg-yellow-100 text-yellow-800',
                'approved' => 'bg-blue-100 text-blue-800',
                'closed' => 'bg-green-100 text-green-800',
            ];
        @endphp
        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $typeColors[$exposureCase->report_type] ?? 'bg-gray-100' }}">
            {{ $exposureCase->getReportTypeLabel() }}
        </span>
        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$exposureCase->status] ?? 'bg-gray-100' }}">
            {{ $exposureCase->getStatusLabel() }}
        </span>
    </div>

    <!-- Update Report Type -->
    @if($exposureCase->status !== 'closed')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <h3 class="text-sm font-semibold text-gray-700 mb-3">Update Report Type</h3>
        <form method="POST" action="{{ route($rolePrefix . '.exposure-cases.update-report-type', $exposureCase) }}" class="flex items-center gap-3">
            @csrf
            @method('PUT')
            <select name="report_type" class="px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500">
                <option value="bite" {{ $exposureCase->report_type === 'bite' ? 'selected' : '' }}>Bite</option>
                <option value="suspected_rabies" {{ $exposureCase->report_type === 'suspected_rabies' ? 'selected' : '' }}>Suspected Rabies</option>
                <option value="confirmed_rabies" {{ $exposureCase->report_type === 'confirmed_rabies' ? 'selected' : '' }}>Confirmed Rabies</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Update
            </button>
        </form>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Patient Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="bi bi-person mr-2 text-green-600"></i>Patient Information
            </h3>
            <dl class="space-y-3">
                <div class="flex justify-between">
                    <dt class="text-gray-500">Name</dt>
                    <dd class="font-medium text-gray-900">{{ $exposureCase->patient_name ?? 'N/A' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Age</dt>
                    <dd class="font-medium text-gray-900">{{ $exposureCase->age ?? 'N/A' }} years old</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Gender</dt>
                    <dd class="font-medium text-gray-900">{{ $exposureCase->gender ?? 'N/A' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Contact</dt>
                    <dd class="font-medium text-gray-900">{{ $exposureCase->patient_contact ?? 'N/A' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Barangay</dt>
                    <dd class="font-medium text-gray-900">{{ $exposureCase->barangay->barangay_name ?? ($exposureCase->patient_barangay ?? 'N/A') }}</dd>
                </div>
            </dl>
        </div>

        <!-- Incident Details -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="bi bi-exclamation-triangle mr-2 text-red-600"></i>Incident Details
            </h3>
            <dl class="space-y-3">
                <div class="flex justify-between">
                    <dt class="text-gray-500">Date of Incident</dt>
                    <dd class="font-medium text-gray-900">{{ $exposureCase->incident_date?->format('M d, Y') ?? 'N/A' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Nature of Incident</dt>
                    <dd class="font-medium text-gray-900">{{ ucfirst($exposureCase->exposure_type) ?? 'N/A' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Bite Site</dt>
                    <dd class="font-medium text-gray-900">{{ $exposureCase->bite_site ?? 'N/A' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Exposure Category</dt>
                    <dd class="font-medium text-gray-900">{{ $exposureCase->category ? 'Category ' . $exposureCase->category : 'N/A' }}</dd>
                </div>
            </dl>
        </div>

        <!-- Animal Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="bi bi-paw mr-2 text-blue-600"></i>Animal Information
            </h3>
            <dl class="space-y-3">
                <div class="flex justify-between">
                    <dt class="text-gray-500">Species</dt>
                    <dd class="font-medium text-gray-900">{{ ucfirst($exposureCase->animal_type) ?? 'N/A' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Status</dt>
                    <dd class="font-medium text-gray-900">{{ ucfirst($exposureCase->animal_status) ?? 'N/A' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Vaccination Status</dt>
                    <dd class="font-medium text-gray-900">{{ ucfirst($exposureCase->vaccination_status) ?? 'N/A' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Owner Name</dt>
                    <dd class="font-medium text-gray-900">{{ $exposureCase->animal_owner_name ?? 'N/A' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Vaccination Status</dt>
                    <dd class="font-medium text-gray-900">{{ $exposureCase->animal_vaccination_status ?? 'N/A' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Current Condition</dt>
                    <dd class="font-medium text-gray-900">{{ $exposureCase->animal_current_condition ?? 'N/A' }}</dd>
                </div>
            </dl>
        </div>

        <!-- Medical Treatment -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="bi bi-clipboard-pulse mr-2 text-purple-600"></i>Medical Treatment
            </h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-gray-500 mb-1">Wound Management</dt>
                    <dd class="font-medium text-gray-900">
                        @if($exposureCase->wound_management)
                            {{ implode(', ', $exposureCase->wound_management) }}
                        @else
                            N/A
                        @endif
                    </dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Post-Exposure Prophylaxis</dt>
                    <dd class="font-medium text-gray-900">{{ $exposureCase->post_exposure_prophylaxis ?? 'N/A' }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Report Details -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class="bi bi-info-circle mr-2 text-gray-600"></i>Report Information
        </h3>
        <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <dt class="text-gray-500 text-sm">Case Number</dt>
                <dd class="font-medium text-gray-900">{{ $exposureCase->case_number }}</dd>
            </div>
            <div>
                <dt class="text-gray-500 text-sm">Report Source</dt>
                <dd class="font-medium text-gray-900">{{ $exposureCase->report_source ?? 'N/A' }}</dd>
            </div>
            <div>
                <dt class="text-gray-500 text-sm">Reporting Facility</dt>
                <dd class="font-medium text-gray-900">{{ $exposureCase->facility_name ?? $exposureCase->reporting_facility ?? 'N/A' }}</dd>
            </div>
            <div>
                <dt class="text-gray-500 text-sm">Date Reported</dt>
                <dd class="font-medium text-gray-900">{{ $exposureCase->date_reported?->format('M d, Y') ?? 'N/A' }}</dd>
            </div>
            <div>
                <dt class="text-gray-500 text-sm">Recorded By</dt>
                <dd class="font-medium text-gray-900">{{ $exposureCase->user?->name ?? 'System' }}</dd>
            </div>
            <div>
                <dt class="text-gray-500 text-sm">Created At</dt>
                <dd class="font-medium text-gray-900">{{ $exposureCase->created_at?->format('M d, Y H:i') ?? 'N/A' }}</dd>
            </div>
        </dl>
    </div>

    <!-- Notes -->
    @if($exposureCase->notes)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-3">Notes</h3>
        <p class="text-gray-700">{{ $exposureCase->notes }}</p>
    </div>
    @endif

    <!-- Original Report Link -->
    @if($exposureCase->originalReport)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-3">Original Report</h3>
        <a href="{{ route($rolePrefix . '.bite-reports.show', $exposureCase->original_report_id) }}" class="text-green-600 hover:text-green-800 font-medium">
            View Original Bite Report <i class="bi bi-arrow-right ml-1"></i>
        </a>
    </div>
    @endif
</div>
@endsection