@extends('layouts.admin')

@section('title', 'Vaccination Record')
@section('header', 'Vaccination Details')
@section('subheader', $report->pet_name)

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('records-staff.vaccinations.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Records</span>
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-gray-800">Vaccination Record</h3>
                <p class="text-sm text-gray-500">{{ $report->vaccination_date->format('F d, Y') }}</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $report->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                {{ ucfirst($report->status) }}
            </span>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Owner Info -->
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-3">Owner Information</h4>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="font-medium text-gray-800">{{ $report->patient_name }}</p>
                        @if($report->patient_contact)
                        <p class="text-sm text-gray-600">{{ $report->patient_contact }}</p>
                        @endif
                        @if($report->patient_address)
                        <p class="text-sm text-gray-500 mt-1">{{ $report->patient_address }}</p>
                        @endif
                    </div>
                </div>

                <!-- Pet Info -->
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-3">Pet Information</h4>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="font-medium text-gray-800">{{ $report->pet_name }}</p>
                        <p class="text-sm text-gray-600">{{ ucfirst($report->pet_species) }} {{ $report->pet_breed ? '• ' . $report->pet_breed : '' }}</p>
                        @if($report->pet_age)
                        <p class="text-sm text-gray-500">{{ $report->pet_age }} years old</p>
                        @endif
                        @if($report->pet_color)
                        <p class="text-sm text-gray-500">Color: {{ $report->pet_color }}</p>
                        @endif
                    </div>
                </div>

                <!-- Vaccination Details -->
                <div class="md:col-span-2">
                    <h4 class="text-sm font-medium text-gray-500 mb-3">Vaccination Details</h4>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <p class="text-xs text-gray-500">Vaccine Brand</p>
                                <p class="font-medium">{{ $report->vaccine_brand }}</p>
                            </div>
                            @if($report->vaccine_batch_number)
                            <div>
                                <p class="text-xs text-gray-500">Batch Number</p>
                                <p class="font-medium">{{ $report->vaccine_batch_number }}</p>
                            </div>
                            @endif
                            <div>
                                <p class="text-xs text-gray-500">Date</p>
                                <p class="font-medium">{{ $report->vaccination_date->format('M d, Y') }}</p>
                            </div>
                            @if($report->weight)
                            <div>
                                <p class="text-xs text-gray-500">Weight</p>
                                <p class="font-medium">{{ $report->weight }} kg</p>
                            </div>
                            @endif
                            @if($report->vaccination_type)
                            <div>
                                <p class="text-xs text-gray-500">Type</p>
                                <p class="font-medium">{{ ucfirst($report->vaccination_type) }}</p>
                            </div>
                            @endif
                            <div>
                                <p class="text-xs text-gray-500">Next Vaccination</p>
                                <p class="font-medium">{{ $report->next_vaccination_date ? $report->next_vaccination_date->format('M d, Y') : 'N/A' }}</p>
                            </div>
                        </div>
                        @if($report->observations)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-xs text-gray-500">Observations</p>
                            <p class="text-sm text-gray-700">{{ $report->observations }}</p>
                        </div>
                        @endif
                        @if($report->notes)
                        <div class="mt-2">
                            <p class="text-xs text-gray-500">Notes</p>
                            <p class="text-sm text-gray-700">{{ $report->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Encoded By -->
                <div class="md:col-span-2">
                    <p class="text-xs text-gray-500">Encoded by: {{ $report->user->name ?? 'Unknown' }} on {{ $report->created_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
