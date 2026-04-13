@extends('layouts.admin')

@section('title', 'Spay/Neuter Report Details')
@section('header', 'Spay/Neuter Report')
@section('subheader', $report->pet_name ?? 'Report Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('spay-neuter.reports.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Reports</span>
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-gray-800">Spay/Neuter Report Details</h3>
                <p class="text-sm text-gray-500">{{ $report->procedure_date->format('F d, Y') }}</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                {{ $report->status === 'completed' ? 'bg-green-100 text-green-800' : 
                   ($report->status === 'scheduled' ? 'bg-blue-100 text-blue-800' : 
                   ($report->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')) }}">
                {{ ucfirst($report->status) }}
            </span>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Pet Information -->
                <div class="md:col-span-2">
                    <h4 class="text-sm font-medium text-gray-500 mb-3">Pet Information</h4>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <p class="text-xs text-gray-500">Pet Name</p>
                                <p class="font-medium">{{ $report->pet_name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Type</p>
                                <p class="font-medium">{{ ucfirst($report->pet_type) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Breed</p>
                                <p class="font-medium">{{ $report->pet_breed ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Age</p>
                                <p class="font-medium">{{ $report->pet_age ?? 'N/A' }} years</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Sex</p>
                                <p class="font-medium">{{ ucfirst($report->pet_sex) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Color/Markings</p>
                                <p class="font-medium">{{ $report->color_markings ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Weight</p>
                                <p class="font-medium">{{ $report->weight ? $report->weight . ' kg' : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Procedure Information -->
                <div class="md:col-span-2">
                    <h4 class="text-sm font-medium text-gray-500 mb-3">Procedure Information</h4>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <p class="text-xs text-gray-500">Procedure Type</p>
                                <p class="font-medium">{{ ucfirst($report->procedure_type) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Procedure Date</p>
                                <p class="font-medium">{{ $report->procedure_date->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Veterinarian</p>
                                <p class="font-medium">{{ $report->veterinarian ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Clinic</p>
                                <p class="font-medium">{{ $report->clinic_name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        @if($report->remarks)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-xs text-gray-500">Remarks</p>
                            <p class="text-sm text-gray-700">{{ $report->remarks }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Owner Information -->
                <div class="md:col-span-2">
                    <h4 class="text-sm font-medium text-gray-500 mb-3">Owner Information</h4>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500">Owner Name</p>
                                <p class="font-medium">{{ $report->owner_name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Contact</p>
                                <p class="font-medium">{{ $report->owner_contact ?? 'N/A' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-xs text-gray-500">Address</p>
                                <p class="font-medium">{{ $report->owner_address ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="md:col-span-2">
                    <div class="flex items-center justify-between text-sm text-gray-500 pt-4 border-t border-gray-100">
                        <span>Barangay: {{ $report->barangay ?? 'N/A' }}</span>
                        <span>Report Date: {{ $report->report_date->format('M d, Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
