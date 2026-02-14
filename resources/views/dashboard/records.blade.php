@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Records Staff Dashboard')
@section('subheader', 'Pet Registration & Records Management')

@section('content')
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-emerald-600 to-teal-800 rounded-xl shadow-lg p-6 mb-8 text-white">
    <h2 class="text-2xl font-bold mb-2">Welcome back, {{ auth()->user()->name ?? 'Records Staff' }}!</h2>
    <p class="text-emerald-100">Manage pet registrations, owner records, and vaccination encoding.</p>
</div>

<!-- Quick Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Pets -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Pets</p>
                <p class="text-3xl font-bold text-emerald-600 mt-1">{{ $stats['total_pets'] }}</p>
            </div>
            <div class="w-14 h-14 bg-emerald-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-hearts text-emerald-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Owners -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Pet Owners</p>
                <p class="text-3xl font-bold text-blue-600 mt-1">{{ $stats['total_owners'] }}</p>
            </div>
            <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-people text-blue-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Vaccinated Pets -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Vaccinated</p>
                <p class="text-3xl font-bold text-green-600 mt-1">{{ $stats['vaccinated_pets'] }}</p>
            </div>
            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-shield-check text-green-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Pending Vaccinations -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Pending Records</p>
                <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $stats['pending_vaccinations'] }}</p>
            </div>
            <div class="w-14 h-14 bg-yellow-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-clock-history text-yellow-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <a href="{{ route('records-staff.pets.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl p-6 transition shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
            <i class="bi bi-plus-circle text-2xl"></i>
        </div>
        <div>
            <p class="font-semibold">New Pet Registration</p>
            <p class="text-sm text-emerald-100">Register a new pet</p>
        </div>
    </a>

    <a href="{{ route('records-staff.vaccinations.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl p-6 transition shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
            <i class="bi bi-eyedropper text-2xl"></i>
        </div>
        <div>
            <p class="font-semibold">Encode Vaccination</p>
            <p class="text-sm text-blue-100">Record vaccination data</p>
        </div>
    </a>

    <a href="{{ route('records-staff.owners.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white rounded-xl p-6 transition shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
            <i class="bi bi-person-badge text-2xl"></i>
        </div>
        <div>
            <p class="font-semibold">Owner Records</p>
            <p class="text-sm text-purple-100">Manage pet owners</p>
        </div>
    </a>

    <a href="{{ route('records-staff.search') }}" class="bg-gray-600 hover:bg-gray-700 text-white rounded-xl p-6 transition shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
            <i class="bi bi-search text-2xl"></i>
        </div>
        <div>
            <p class="font-semibold">Search Records</p>
            <p class="text-sm text-gray-100">Find pets, owners, records</p>
        </div>
    </a>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Pet Registrations -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-semibold text-gray-800">Recent Pet Registrations</h3>
            <a href="{{ route('records-staff.pets.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700">View All</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($recentPets as $pet)
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
                <div class="text-right">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $pet->vaccination_status === 'vaccinated' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($pet->vaccination_status) }}
                    </span>
                    <p class="text-xs text-gray-400 mt-1">{{ $pet->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-gray-500">
                <i class="bi bi-inbox text-4xl mb-2"></i>
                <p>No pet registrations yet</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Vaccinations -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-semibold text-gray-800">Recent Vaccinations</h3>
            <a href="{{ route('records-staff.vaccinations.index') }}" class="text-sm text-blue-600 hover:text-blue-700">View All</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($recentVaccinations as $vaccination)
            <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="bi bi-shield-fill text-blue-600"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">{{ $vaccination->pet_name }}</p>
                        <p class="text-sm text-gray-500">{{ $vaccination->patient_name }} • {{ $vaccination->vaccine_brand }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $vaccination->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($vaccination->status) }}
                    </span>
                    <p class="text-xs text-gray-400 mt-1">{{ $vaccination->vaccination_date->format('M d, Y') }}</p>
                </div>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-gray-500">
                <i class="bi bi-inbox text-4xl mb-2"></i>
                <p>No vaccination records yet</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
