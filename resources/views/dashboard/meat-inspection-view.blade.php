@extends('layouts.admin')

@section('title', 'Meat Inspection Report Details')

@section('header', 'Meat Inspection Report Details')
@section('subheader', 'Meat inspection compliance information')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.meat-inspection-reports.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Meat Inspection Reports</span>
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 bg-yellow-50 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Meat Inspection Report</h2>
                    <p class="text-sm text-gray-600">Inspected on {{ $report->created_at->format('M d, Y H:i') }}</p>
                </div>
                <span class="px-3 py-1 text-sm font-medium rounded-full 
                    @if($report->compliance_status === 'compliant') bg-green-100 text-green-700
                    @elseif($report->compliance_status === 'non_compliant') bg-red-100 text-red-700
                    @else bg-yellow-100 text-yellow-700 @endif">
                    {{ ucfirst(str_replace('_', ' ', $report->compliance_status)) }}
                </span>
            </div>
        </div>

        <!-- Establishment Information -->
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Establishment Information</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-xs text-gray-500">Establishment Name</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->establishment_name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Type</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->establishment_type }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-xs text-gray-500">Address</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->establishment_address }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Owner Name</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->owner_name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Contact</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->owner_contact ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Inspection Details -->
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Inspection Details</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-xs text-gray-500">Inspection Date</p>
                    <p class="text-sm font-medium text-gray-800">{{ \Carbon\Carbon::parse($report->inspection_date)->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Inspection Time</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->inspection_time }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Inspection Type</p>
                    <p class="text-sm font-medium text-gray-800">{{ ucfirst($report->inspection_type) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Inspector Name</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->inspector_name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Inspected By</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->user->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Overall Rating</p>
                    <p class="text-sm font-medium text-gray-800">{{ $report->overall_rating ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Findings -->
        @if($report->findings)
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Findings</h3>
            <p class="text-sm text-gray-700">{{ $report->findings }}</p>
        </div>
        @endif

        <!-- Observations -->
        @if($report->observations)
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Observations</h3>
            <p class="text-sm text-gray-700">{{ $report->observations }}</p>
        </div>
        @endif

        <!-- Recommendations -->
        @if($report->recommendations)
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Recommendations</h3>
            <p class="text-sm text-gray-700">{{ $report->recommendations }}</p>
        </div>
        @endif

        <!-- Penalty -->
        @if($report->penalty_imposed)
        <div class="px-6 py-4 border-b border-gray-100 bg-red-50">
            <h3 class="text-sm font-semibold text-red-500 uppercase tracking-wide mb-3">Penalty Imposed</h3>
            <p class="text-sm text-gray-800">{{ $report->penalty_imposed }}</p>
        </div>
        @endif

        <!-- Next Inspection -->
        @if($report->next_inspection_date)
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Next Inspection</h3>
            <p class="text-sm font-medium text-gray-800">{{ \Carbon\Carbon::parse($report->next_inspection_date)->format('M d, Y') }}</p>
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
                <a href="{{ route('admin.meat-inspection-reports.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition">
                    Close
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
