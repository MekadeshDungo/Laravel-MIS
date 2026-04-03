@extends('layouts.admin')

@section('title', 'Missing Pet Details - ' . $animal->name)

@section('header', 'Missing Pet Details')

@section('content')
<div class="p-4 md:p-6">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin-staff.missing-pets.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition">
            <i class="bi bi-arrow-left text-gray-600"></i>
        </a>
        <div class="flex-1">
            <h1 class="text-2xl font-bold text-gray-800">{{ $animal->name }}</h1>
            <p class="text-gray-500 mt-1">{{ ucfirst($animal->animal_type) }} - {{ $animal->breed ?? 'Unknown Breed' }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin-staff.missing-pets.edit', $animal->animal_id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="bi bi-pencil mr-1"></i> Edit
            </a>
            <form action="{{ route('admin-staff.missing-pets.mark-found', $animal->animal_id) }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    <i class="bi bi-check-circle mr-1"></i> Mark Found
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Photo -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pet Photo</h3>
            <div class="relative h-80 bg-gray-200 rounded-lg overflow-hidden">
                @if($animal->photo_url)
                    <img src="{{ asset('storage/' . $animal->photo_url) }}" alt="{{ $animal->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <i class="bi bi-image text-gray-400 text-6xl"></i>
                    </div>
                @endif
            </div>
        </div>

        <!-- Details -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pet Information</h3>
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-500">Type</span>
                    <span class="font-medium text-gray-800">{{ ucfirst($animal->animal_type) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Breed</span>
                    <span class="font-medium text-gray-800">{{ $animal->breed ?? 'Unknown' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Color</span>
                    <span class="font-medium text-gray-800">{{ $animal->color ?? 'Unknown' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Sex</span>
                    <span class="font-medium text-gray-800">{{ ucfirst($animal->sex ?? 'Unknown') }}</span>
                </div>
            </div>
        </div>

        <!-- Missing Details -->
        <div class="bg-white rounded-xl shadow-sm p-6 lg:col-span-2">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Missing Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-500 text-sm">Missing Since</p>
                    <p class="font-medium text-gray-800">{{ $animal->missing_since->format('F d, Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Last Seen Location</p>
                    <p class="font-medium text-gray-800">{{ $animal->last_seen_location }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Contact Info</p>
                    <p class="font-medium text-gray-800">{{ $animal->contact_info }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Owner</p>
                    <p class="font-medium text-gray-800">{{ $animal->owner->first_name ?? '' }} {{ $animal->owner->last_name ?? 'Unknown' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection