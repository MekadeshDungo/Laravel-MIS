@extends('layouts.admin')

@section('title', 'Missing Pets')

@section('header', 'Missing Pets')
@section('subheader', 'Manage missing pet reports and help reunite them with owners')

@section('content')
<div class="p-4 md:p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Missing Pets</h1>
            <p class="text-gray-500 mt-1">Manage missing pet reports and help reunite them with owners</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin-staff.missing-pets.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i class="bi bi-plus-lg"></i>
                Report Missing Pet
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Missing</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalCount }}</h3>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="bi bi-exclamation-triangle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Pending Approval</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $pendingCount }}</h3>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="bi bi-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Approved</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $approvedCount }}</h3>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="bi bi-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm mb-6">
        <div class="p-4 border-b border-gray-100">
            <form method="GET" class="flex flex-wrap gap-4">
                <div class="w-48">
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    Filter
                </button>
                <a href="{{ route('admin-staff.missing-pets.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Clear
                </a>
            </form>
        </div>
    </div>

    @if($missingPets->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($missingPets as $pet)
                <div class="bg-white rounded-xl shadow-sm border-2 {{ $pet->status == 'approved' ? 'border-green-200' : 'border-red-100' }} overflow-hidden hover:shadow-lg transition">
                    <div class="relative h-48 bg-gray-200">
                        @if($pet->photo_url)
                            <img src="{{ asset('storage/' . $pet->photo_url) }}" alt="{{ $pet->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="bi bi-image text-gray-400 text-4xl"></i>
                            </div>
                        @endif
                        <div class="absolute top-2 right-2 flex gap-1">
                            @if($pet->status == 'active')
                                <span class="bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-medium">Pending</span>
                            @else
                                <span class="bg-green-600 text-white px-2 py-1 rounded-full text-xs font-medium">Approved</span>
                            @endif
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-800">{{ $pet->name }}</h3>
                        <p class="text-sm text-gray-500">{{ ucfirst($pet->animal_type) }} - {{ $pet->breed ?? 'Unknown Breed' }}</p>
                        <div class="mt-3 space-y-1 text-sm text-gray-600">
                            <p><i class="bi bi-calendar mr-1"></i> Missing since: {{ $pet->missing_since ? $pet->missing_since->format('M d, Y') : 'N/A' }}</p>
                            <p><i class="bi bi-geo-alt mr-1"></i> {{ $pet->last_seen_location }}</p>
                        </div>
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('admin-staff.missing-pets.show', $pet->animal_id) }}" class="flex-1 text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                                View
                            </a>
                            @if($pet->status == 'active')
                                <form action="{{ route('admin-staff.missing-pets.approve', $pet->animal_id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm" onclick="return confirm('Approve this missing pet report?')">
                                        Approve
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin-staff.missing-pets.mark-found', $pet->animal_id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-sm" onclick="return confirm('Mark this pet as found?')">
                                    Found
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $missingPets->withQueryString()->links() }}
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm p-12 text-center">
            <i class="bi bi-check-circle text-green-500 text-5xl mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">No Missing Pets</h3>
            <p class="text-gray-500">There are no missing pet reports at the moment.</p>
        </div>
    @endif
</div>
@endsection