@extends('layouts.admin')

@section('title', 'Pet Registrations')

@section('header', 'Pet Registrations')

@section('content')
<div class="p-4 md:p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pet Registrations</h1>
            <p class="text-gray-500 mt-1">Manage all registered pets</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('records-staff.pets.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="bi bi-plus-lg"></i>
                Register New Pet
            </a>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-xl shadow-sm mb-6">
        <div class="p-6">
            <form method="GET" action="{{ route('records-staff.pets.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Pet name, license..." value="{{ $search }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Species</label>
                    <select name="species" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Species</option>
                        <option value="dog" {{ $species === 'dog' ? 'selected' : '' }}>Dog</option>
                        <option value="cat" {{ $species === 'cat' ? 'selected' : '' }}>Cat</option>
                        <option value="other" {{ $species === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Vaccination Status</label>
                    <select name="vaccination_status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="vaccinated" {{ $vaccinationStatus === 'vaccinated' ? 'selected' : '' }}>Vaccinated</option>
                        <option value="unvaccinated" {{ $vaccinationStatus === 'unvaccinated' ? 'selected' : '' }}>Unvaccinated</option>
                        <option value="pending" {{ $vaccinationStatus === 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Pet List -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="overflow-x-auto">
            @if($pets->count() > 0)
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Pet Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Species</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Breed</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Owner</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">License #</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Vaccination</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Registered</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($pets as $pet)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-800">{{ $pet->name }}</div>
                                    @if($pet->microchip_number)
                                        <div class="text-xs text-gray-500">Chip: {{ $pet->microchip_number }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ ucfirst($pet->species) }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $pet->breed ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $pet->owner->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $pet->license_number ?? '-' }}</td>
                                <td class="px-6 py-4">
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
                                </td>
                                <td class="px-6 py-4 text-gray-500 text-sm">{{ $pet->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('records-staff.pets.show', $pet) }}" class="p-2 text-info hover:bg-info hover:bg-opacity-10 rounded-lg transition" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('records-staff.pets.edit', $pet) }}" class="p-2 text-warning hover:bg-warning hover:bg-opacity-10 rounded-lg transition" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $pets->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="bi bi-heart-pulse text-5xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 mb-4">No pets found.</p>
                    <a href="{{ route('records-staff.pets.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <i class="bi bi-plus-lg"></i>
                        Register First Pet
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
