@extends('layouts.admin')

@section('title', $pet->name)
@section('header', $pet->name)
@section('subheader', 'Pet Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin-staff.pets.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Pets</span>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Pet Info Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-800">Pet Information</h3>
                    <a href="{{ route('admin-staff.pets.edit', $pet) }}" class="text-emerald-600 hover:text-emerald-700">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                </div>
                <div class="p-6">
                    <div class="flex items-start gap-6">
                        <div class="w-24 h-24 bg-emerald-100 rounded-xl flex items-center justify-center">
                            <i class="bi bi-heart-fill text-4xl text-emerald-600"></i>
                        </div>
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-gray-800">{{ $pet->name }}</h2>
                            <p class="text-gray-500">{{ ucfirst($pet->species) }} • {{ $pet->breed ?? 'Unknown breed' }}</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mt-2 {{ $pet->vaccination_status === 'vaccinated' ? 'bg-green-100 text-green-800' : ($pet->vaccination_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($pet->vaccination_status) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mt-6">
                        <div>
                            <p class="text-sm text-gray-500">Age</p>
                            <p class="font-medium">{{ $pet->age ?? 'Unknown' }} years</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Gender</p>
                            <p class="font-medium">{{ ucfirst($pet->gender) ?? 'Unknown' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Color</p>
                            <p class="font-medium">{{ $pet->color ?? 'Unknown' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Weight</p>
                            <p class="font-medium">{{ $pet->weight ?? 'Unknown' }} kg</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">License Number</p>
                            <p class="font-medium">{{ $pet->license_number ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Microchip Number</p>
                            <p class="font-medium">{{ $pet->microchip_number ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Health Status</p>
                            <p class="font-medium">{{ ucfirst($pet->health_status) ?? 'Unknown' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Registered Date</p>
                            <p class="font-medium">{{ $pet->created_at->format('F d, Y') }}</p>
                        </div>
                    </div>

                    @if($pet->notes)
                    <div class="mt-6">
                        <p class="text-sm text-gray-500">Notes</p>
                        <p class="mt-1 text-gray-700">{{ $pet->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Owner Info Card -->
        <div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Owner Information</h3>
                </div>
                <div class="p-6">
                    @if($pet->owner)
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="bi bi-person-fill text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $pet->owner->name }}</p>
                                <p class="text-sm text-gray-500">{{ $pet->owner->email }}</p>
                            </div>
                        </div>
                        @if($pet->owner->contact_number)
                        <div class="mb-2">
                            <p class="text-sm text-gray-500">Contact</p>
                            <p class="font-medium">{{ $pet->owner->contact_number }}</p>
                        </div>
                        @endif
                        @if($pet->owner->address)
                        <div class="mb-2">
                            <p class="text-sm text-gray-500">Address</p>
                            <p class="font-medium">{{ $pet->owner->address }}</p>
                        </div>
                        @endif
                        <a href="{{ route('admin-staff.owners.show', $pet->owner) }}" class="mt-4 inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700">
                            <span>View Owner Profile</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    @else
                        <div class="text-center py-4 text-gray-500">
                            <i class="bi bi-person-x text-3xl mb-2"></i>
                            <p>No owner assigned</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
