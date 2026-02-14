@extends('layouts.admin')

@section('title', 'Global Records Search')

@section('header', 'Global Records Search')

@section('content')
<div class="p-4 md:p-6">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('records-staff.dashboard') }}" class="p-2 hover:bg-gray-100 rounded-lg transition">
            <i class="bi bi-house text-gray-600"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Global Records Search</h1>
            <p class="text-gray-500 mt-1">Search pets, owners, and vaccinations</p>
        </div>
    </div>

    <!-- Search Form -->
    <div class="bg-white rounded-xl shadow-sm mb-6">
        <div class="p-6">
            <form method="GET" action="{{ route('records-staff.search') }}" class="flex gap-4">
                <div class="flex-1">
                    <input type="text" name="q" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Search pets, owners, or vaccinations..." value="{{ $search }}" autofocus>
                </div>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="bi bi-search mr-2"></i> Search
                </button>
            </form>
        </div>
    </div>

    @if($search)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Pets Results -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Pets ({{ $pets->count() }})</h3>
            </div>
            <div class="p-4">
                @if($pets->count() > 0)
                    <ul class="space-y-2">
                        @foreach($pets as $pet)
                            <li>
                                <a href="{{ route('records-staff.pets.show', $pet) }}" class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="bi bi-heart-fill text-blue-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-800">{{ $pet->name }}</p>
                                        <p class="text-sm text-gray-500">{{ ucfirst($pet->species) }} | {{ $pet->owner->name ?? 'No owner' }}</p>
                                    </div>
                                    <i class="bi bi-chevron-right text-gray-400"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-center py-8">
                        <i class="bi bi-heart-pulse text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">No pets found.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Owners Results -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Owners ({{ $owners->count() }})</h3>
            </div>
            <div class="p-4">
                @if($owners->count() > 0)
                    <ul class="space-y-2">
                        @foreach($owners as $owner)
                            <li>
                                <a href="{{ route('records-staff.owners.show', $owner) }}" class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition">
                                    <div class="w-10 h-10 bg-info bg-opacity-20 rounded-full flex items-center justify-center">
                                        <i class="bi bi-person text-info"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-800">{{ $owner->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $owner->email }} | {{ $owner->pets_count }} pets</p>
                                    </div>
                                    <i class="bi bi-chevron-right text-gray-400"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-center py-8">
                        <i class="bi bi-people text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">No owners found.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Vaccinations Results -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Vaccinations ({{ $vaccinations->count() }})</h3>
            </div>
            <div class="p-4">
                @if($vaccinations->count() > 0)
                    <ul class="space-y-2">
                        @foreach($vaccinations as $vaccination)
                            <li>
                                <a href="{{ route('records-staff.vaccinations.show', $vaccination) }}" class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition">
                                    <div class="w-10 h-10 bg-success bg-opacity-20 rounded-full flex items-center justify-center">
                                        <i class="bi bi-shield-check text-success"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-800">{{ $vaccination->patient_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $vaccination->pet_name }} | {{ $vaccination->vaccine_brand }}</p>
                                    </div>
                                    <i class="bi bi-chevron-right text-gray-400"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-center py-8">
                        <i class="bi bi-shield-check text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">No vaccinations found.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @else
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-12 text-center">
            <i class="bi bi-search text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Enter a search term to find records</h3>
            <p class="text-gray-500">Search by pet name, owner name, license number, microchip number, or vaccination details.</p>
        </div>
    </div>
    @endif
</div>
@endsection
