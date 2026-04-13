@extends('layouts.admin')

@section('title', 'Pet Registrations')
@section('header', 'Pet Registration Records')
@section('subheader', 'Manage registered pets')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Pet Registrations</h2>
            <p class="text-sm text-gray-500">View and manage all registered pets</p>
        </div>
        <a href="{{ route('admin-staff.pets.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
            <i class="bi bi-plus-lg"></i>
            Register New Pet
        </a>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-64">
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" name="search" value="{{ $search }}" placeholder="Pet name, license number..." 
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div class="w-40">
                <label class="block text-sm font-medium text-gray-700 mb-1">Species</label>
                <select name="species" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">All Species</option>
                    <option value="dog" {{ $species == 'dog' ? 'selected' : '' }}>Dog</option>
                    <option value="cat" {{ $species == 'cat' ? 'selected' : '' }}>Cat</option>
                    <option value="other" {{ $species == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">Vaccination Status</label>
                <select name="vaccination_status" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">All Status</option>
                    <option value="vaccinated" {{ $vaccinationStatus == 'vaccinated' ? 'selected' : '' }}>Vaccinated</option>
                    <option value="unvaccinated" {{ $vaccinationStatus == 'unvaccinated' ? 'selected' : '' }}>Unvaccinated</option>
                    <option value="pending" {{ $vaccinationStatus == 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg transition">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>

    <!-- Pets Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pet</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Species</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">License #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registered</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pets as $pet)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center mr-3">
                                <i class="bi bi-heart-fill text-emerald-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $pet->name }}</p>
                                <p class="text-sm text-gray-500">{{ $pet->breed ?? 'Unknown breed' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ ucfirst($pet->species) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <p class="text-sm text-gray-800">{{ $pet->owner->name ?? 'No Owner' }}</p>
                        <p class="text-xs text-gray-500">{{ $pet->owner->email ?? '' }}</p>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $pet->license_number ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $pet->vaccination_status === 'vaccinated' ? 'bg-green-100 text-green-800' : ($pet->vaccination_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ ucfirst($pet->vaccination_status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $pet->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin-staff.pets.show', $pet) }}" class="text-emerald-600 hover:text-emerald-700 mr-3">View</a>
                        <a href="{{ route('admin-staff.pets.edit', $pet) }}" class="text-blue-600 hover:text-blue-700">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                        <i class="bi bi-inbox text-4xl mb-2 block"></i>
                        <p>No pets found</p>
                        @if($search || $species || $vaccinationStatus)
                        <p class="text-sm">Try adjusting your filters</p>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $pets->appends(request()->query())->links() }}
    </div>
</div>
@endsection
