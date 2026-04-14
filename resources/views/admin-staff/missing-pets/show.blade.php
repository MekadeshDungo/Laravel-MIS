@extends('layouts.admin')

@section('title', 'Missing Pet Details')

@section('header', 'Missing Pet Details')

@section('content')
<div class="p-4 md:p-6">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin-staff.missing-pets.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition">
            <i class="bi bi-arrow-left text-gray-600"></i>
        </a>
        <div class="flex-1">
            <h1 class="text-2xl font-bold text-gray-800">{{ $animal->pet_name }}</h1>
            <p class="text-gray-500 mt-1">{{ ucfirst($animal->species) }} - {{ $animal->breed ?? 'Unknown Breed' }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin-staff.missing-pets.edit', $animal->missing_id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="bi bi-pencil mr-1"></i> Edit
            </a>
            <form action="{{ route('admin-staff.missing-pets.mark-found', $animal->missing_id) }}" method="POST">
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
                @if($animal->image)
                    <img src="{{ asset('storage/' . $animal->image) }}" alt="{{ $animal->pet_name }}" class="w-full h-full object-cover">
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
                <div>
                    <p class="text-sm text-gray-500">Species</p>
                    <p class="font-medium text-gray-800">{{ ucfirst($animal->species) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Breed</p>
                    <p class="font-medium text-gray-800">{{ $animal->breed ?? 'Unknown' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Gender</p>
                    <p class="font-medium text-gray-800">{{ ucfirst($animal->gender ?? 'Unknown') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Age</p>
                    <p class="font-medium text-gray-800">{{ $animal->age ?? 'Unknown' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Weight</p>
                    <p class="font-medium text-gray-800">{{ $animal->weight ?? 'Unknown' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Color/Markings</p>
                    <p class="font-medium text-gray-800">{{ $animal->color ?? 'Unknown' }}</p>
                </div>
            </div>
        </div>

        <!-- Missing Info -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Missing Information</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500">Missing Since</p>
                    <p class="font-medium text-gray-800">{{ $animal->missing_since ? $animal->missing_since->format('M d, Y') : 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Last Seen Location</p>
                    <p class="font-medium text-gray-800">{{ $animal->last_seen_location }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Contact Info</p>
                    <p class="font-medium text-gray-800">{{ $animal->contact_info }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $animal->status == 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($animal->status) }}
                    </span>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Reported On</p>
                    <p class="font-medium text-gray-800">{{ $animal->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection