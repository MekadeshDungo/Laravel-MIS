@extends('layouts.admin')

@section('title', 'Vaccination Record Details')

@section('header', 'Vaccination Record Details')

@section('content')
<div class="p-4 md:p-6">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin-staff.vaccinations.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition">
            <i class="bi bi-arrow-left text-gray-600"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Vaccination Record Details</h1>
            <p class="text-gray-500 mt-1">{{ $report->patient_name }} | {{ $report->pet_name }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Vaccination Information</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Vaccine Brand</p>
                            <p class="font-medium text-gray-800">{{ $report->vaccine_brand }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Batch Number</p>
                            <p class="font-medium text-gray-800">{{ $report->vaccine_batch_number ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Vaccination Type</p>
                            <p class="font-medium text-gray-800">{{ $report->vaccination_type ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Vaccination Date</p>
                            <p class="font-medium text-gray-800">{{ $report->vaccination_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Time</p>
                            <p class="font-medium text-gray-800">{{ $report->vaccination_time ? date('h:i A', strtotime($report->vaccination_time)) : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Weight</p>
                            <p class="font-medium text-gray-800">{{ $report->weight ? $report->weight . ' kg' : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Next Vaccination</p>
                            <p class="font-medium text-gray-800">{{ $report->next_vaccination_date ? $report->next_vaccination_date->format('M d, Y') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Status</p>
                            <p class="font-medium">
                                @switch($report->status)
                                    @case('completed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Completed</span>
                                        @break
                                    @case('pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                        @break
                                @endswitch
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Encoded By</p>
                            <p class="font-medium text-gray-800">{{ $report->user->name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    @if($report->observations)
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-sm text-gray-500 mb-1">Observations</p>
                        <p class="text-gray-700">{{ $report->observations }}</p>
                    </div>
                    @endif

                    @if($report->notes)
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-sm text-gray-500 mb-1">Notes</p>
                        <p class="text-gray-700">{{ $report->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Patient Information</h3>
                </div>
                <div class="p-6 space-y-3">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Owner/Patient Name</p>
                        <p class="font-medium text-gray-800">{{ $report->patient_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Contact</p>
                        <p class="font-medium text-gray-800">{{ $report->patient_contact ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Address</p>
                        <p class="font-medium text-gray-800">{{ $report->patient_address ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Pet Information</h3>
                </div>
                <div class="p-6 space-y-3">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Pet Name</p>
                        <p class="font-medium text-gray-800">{{ $report->pet_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Species</p>
                        <p class="font-medium text-gray-800">{{ ucfirst($report->pet_species) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Breed</p>
                        <p class="font-medium text-gray-800">{{ $report->pet_breed ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Age</p>
                        <p class="font-medium text-gray-800">{{ $report->pet_age ? $report->pet_age . ' years' : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Gender</p>
                        <p class="font-medium text-gray-800">{{ ucfirst($report->pet_gender) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Color</p>
                        <p class="font-medium text-gray-800">{{ $report->pet_color ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
