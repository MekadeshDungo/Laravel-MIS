@extends('layouts.admin')

@section('title', $owner->name)
@section('header', $owner->name)
@section('subheader', 'Owner Profile')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin-staff.owners.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Owners</span>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Owner Info -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="font-semibold text-gray-800">Owner Information</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="bi bi-person-fill text-2xl text-blue-600"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">{{ $owner->name }}</h2>
                            <p class="text-sm text-gray-500">{{ $owner->email }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        @if($owner->contact_number)
                        <div>
                            <p class="text-sm text-gray-500">Contact Number</p>
                            <p class="font-medium">{{ $owner->contact_number }}</p>
                        </div>
                        @endif
                        @if($owner->address)
                        <div>
                            <p class="text-sm text-gray-500">Address</p>
                            <p class="font-medium">{{ $owner->address }}</p>
                        </div>
                        @endif
                        <div>
                            <p class="text-sm text-gray-500">Registered Date</p>
                            <p class="font-medium">{{ $owner->created_at->format('F d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Pets</p>
                            <p class="font-medium">{{ $owner->pets->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pets List -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-800">Registered Pets</h3>
                    <a href="{{ route('admin-staff.pets.create') }}?owner_id={{ $owner->id }}" class="text-emerald-600 hover:text-emerald-700 text-sm">
                        <i class="bi bi-plus"></i> Add Pet
                    </a>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($owner->pets as $pet)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                                <i class="bi bi-heart-fill text-emerald-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $pet->name }}</p>
                                <p class="text-sm text-gray-500">{{ ucfirst($pet->species) }} • {{ $pet->breed ?? 'Unknown breed' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $pet->vaccination_status === 'vaccinated' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($pet->vaccination_status) }}
                            </span>
                            <a href="{{ route('admin-staff.pets.show', $pet) }}" class="block mt-1 text-sm text-emerald-600 hover:text-emerald-700">View Details</a>
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-12 text-center text-gray-500">
                        <i class="bi bi-inbox text-4xl mb-2"></i>
                        <p>No pets registered yet</p>
                        <a href="{{ route('admin-staff.pets.create') }}?owner_id={{ $owner->id }}" class="text-emerald-600 hover:text-emerald-700 mt-2 inline-block">
                            Register a pet for this owner
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
