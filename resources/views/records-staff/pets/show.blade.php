@extends('layouts.admin')

@section('title', 'Pet Details - ' . $pet->name)

@section('header', 'Pet Details')

@section('content')
<div class="p-4 md:p-6">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin-staff.pets.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition">
            <i class="bi bi-arrow-left text-gray-600"></i>
        </a>
        <div class="flex-1">
            <h1 class="text-2xl font-bold text-gray-800">{{ $pet->name }}</h1>
            <p class="text-gray-500 mt-1">{{ ucfirst($pet->species) }} | {{ $pet->breed ?? 'Unknown Breed' }}</p>
        </div>
        <a href="{{ route('admin-staff.pets.edit', $pet) }}" class="px-4 py-2 bg-warning text-white rounded-lg hover:bg-warning hover:bg-opacity-90 transition">
            <i class="bi bi-pencil mr-2"></i> Edit
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Pet Information</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Name</p>
                            <p class="font-medium text-gray-800">{{ $pet->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Species</p>
                            <p class="font-medium text-gray-800">{{ ucfirst($pet->species) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Breed</p>
                            <p class="font-medium text-gray-800">{{ $pet->breed ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Age</p>
                            <p class="font-medium text-gray-800">{{ $pet->age ? $pet->age . ' years' : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Gender</p>
                            <p class="font-medium text-gray-800">{{ ucfirst($pet->gender) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Weight</p>
                            <p class="font-medium text-gray-800">{{ $pet->weight ? $pet->weight . ' kg' : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Color</p>
                            <p class="font-medium text-gray-800">{{ $pet->color ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Registered</p>
                            <p class="font-medium text-gray-800">{{ $pet->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Identification</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">License Number</p>
                            <p class="font-medium text-gray-800">{{ $pet->license_number ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">License Expiry</p>
                            <p class="font-medium text-gray-800">{{ $pet->license_expiry ? $pet->license_expiry->format('M d, Y') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Microchip Number</p>
                            <p class="font-medium text-gray-800">{{ $pet->microchip_number ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Vaccination Status</p>
                            <p class="font-medium">
                                @switch($pet->vaccination_status)
                                    @case('vaccinated')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Vaccinated</span>
                                        @break
                                    @case('unvaccinated')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Unvaccinated</span>
                                        @break
                                    @case('pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                        @break
                                @endswitch
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Last Vaccination</p>
                            <p class="font-medium text-gray-800">{{ $pet->vaccination_date ? $pet->vaccination_date->format('M d, Y') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Next Vaccination</p>
                            <p class="font-medium text-gray-800">{{ $pet->next_vaccination_date ? $pet->next_vaccination_date->format('M d, Y') : '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($pet->medical_history || $pet->notes)
            <div class="bg-white rounded-xl shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Medical History & Notes</h3>
                </div>
                <div class="p-6">
                    @if($pet->medical_history)
                        <div class="mb-4">
                            <p class="text-sm text-gray-500 mb-1">Medical History</p>
                            <p class="text-gray-700">{{ $pet->medical_history }}</p>
                        </div>
                    @endif
                    @if($pet->notes)
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Notes</p>
                            <p class="text-gray-700">{{ $pet->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Owner Information</h3>
                </div>
                <div class="p-6">
                    @if($pet->owner)
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Name</p>
                                <p class="font-medium text-gray-800">{{ $pet->owner->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Email</p>
                                <p class="font-medium text-gray-800">{{ $pet->owner->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Contact</p>
                                <p class="font-medium text-gray-800">{{ $pet->owner->contact_number ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Address</p>
                                <p class="font-medium text-gray-800">{{ $pet->owner->address ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin-staff.owners.show', $pet->owner) }}" class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                <i class="bi bi-eye mr-2"></i> View Owner Profile
                            </a>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No owner assigned.</p>
                    @endif
                </div>
            </div>

            @if($pet->photo_url)
            <div class="bg-white rounded-xl shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Photo</h3>
                </div>
                <div class="p-6">
                    <img src="{{ asset('storage/' . $pet->photo_url) }}" alt="{{ $pet->name }}" class="w-full rounded-lg">
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
