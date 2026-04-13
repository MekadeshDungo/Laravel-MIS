@extends('layouts.admin')

@section('title', 'Search Records')
@section('header', 'Search Records')
@section('subheader', 'Find pets, owners, and vaccination records')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Search Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
        <form method="GET" action="{{ route('admin-staff.search') }}">
            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search Query</label>
                    <input type="text" name="q" value="{{ $search }}" placeholder="Search by pet name, owner name, license number, microchip, vaccine..." 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-lg"
                        autofocus>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-lg transition font-medium">
                        <i class="bi bi-search mr-2"></i>Search
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if($search)
    <!-- Search Results -->
    <div class="space-y-8">
        <!-- Pets Results -->
        @if($pets->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                <i class="bi bi-heart-fill text-emerald-600"></i>
                <h3 class="font-semibold text-gray-800">Pets ({{ $pets->count() }})</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($pets as $pet)
                <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                            <i class="bi bi-heart-fill text-emerald-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">{{ $pet->name }}</p>
                            <p class="text-sm text-gray-500">{{ ucfirst($pet->species) }} • {{ $pet->owner->name ?? 'No Owner' }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin-staff.pets.show', $pet) }}" class="text-emerald-600 hover:text-emerald-700">View Details</a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Owners Results -->
        @if($owners->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                <i class="bi bi-person-fill text-blue-600"></i>
                <h3 class="font-semibold text-gray-800">Owners ({{ $owners->count() }})</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($owners as $owner)
                <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="bi bi-person-fill text-blue-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">{{ $owner->name }}</p>
                            <p class="text-sm text-gray-500">{{ $owner->pets_count }} pets • {{ $owner->email }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin-staff.owners.show', $owner) }}" class="text-blue-600 hover:text-blue-700">View Profile</a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Vaccinations Results -->
        @if($vaccinations->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                <i class="bi bi-shield-fill text-green-600"></i>
                <h3 class="font-semibold text-gray-800">Vaccinations ({{ $vaccinations->count() }})</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($vaccinations as $vaccination)
                <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="bi bi-shield-fill text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">{{ $vaccination->pet_name }}</p>
                            <p class="text-sm text-gray-500">{{ $vaccination->patient_name }} • {{ $vaccination->vaccine_brand }}</p>
                        </div>
                    </div>
                    <span class="text-sm text-gray-500">{{ $vaccination->vaccination_date->format('M d, Y') }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- No Results -->
        @if($pets->count() == 0 && $owners->count() == 0 && $vaccinations->count() == 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <i class="bi bi-search text-4xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg">No records found for "{{ $search }}"</p>
            <p class="text-sm text-gray-400 mt-2">Try searching with different keywords</p>
        </div>
        @endif
    </div>
    @else
    <!-- Empty State -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
        <i class="bi bi-search text-4xl text-gray-300 mb-4"></i>
        <p class="text-gray-500 text-lg">Search for pets, owners, and vaccination records</p>
        <p class="text-sm text-gray-400 mt-2">Enter a name, license number, microchip number, or other details</p>
    </div>
    @endif
</div>
@endsection
