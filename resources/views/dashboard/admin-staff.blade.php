@extends('layouts.admin')

@section('title', 'Admin Staff Dashboard')
@section('header', 'Admin Staff Dashboard')
@section('subheader', 'Administrative support operations')

@section('content')
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl p-6 mb-8 text-white">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold mb-2">Admin Staff Portal</h2>
            <p class="text-green-100">Supporting administrative and records management.</p>
        </div>
        <div class="hidden md:block">
            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center">
                <i class="bi bi-person-badge text-4xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards (admin-staff specific) -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Registered Pets</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Pet::count() }}</p>
            </div>
            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-paw text-emerald-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Pet Owners</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\PetOwner::count() }}</p>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-people text-blue-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Vaccinations</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\RabiesVaccinationReport::count() }}</p>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-shield-check text-green-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Missing Pets</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\MissingPet::count() }}</p>
            </div>
            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-exclamation-triangle text-red-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions (admin-staff specific) -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('admin-staff.pets.create') }}"
           class="flex flex-col items-center p-4 bg-emerald-50 hover:bg-emerald-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-plus-circle text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Register Pet</span>
        </a>

        <a href="{{ route('admin-staff.vaccinations.create') }}"
           class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-eyedropper text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Encode Vaccination</span>
        </a>

        <a href="{{ route('admin-staff.owners.index') }}"
           class="flex flex-col items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-person-badge text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Owner Records</span>
        </a>

        <a href="{{ route('admin-staff.missing-pets.index') }}"
           class="flex flex-col items-center p-4 bg-red-50 hover:bg-red-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-exclamation-triangle text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Missing Pets</span>
        </a>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Pets -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Recent Pets</h3>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse(\App\Models\Pet::with('owner')->latest()->take(4)->get() as $pet)
                <a href="{{ route('admin-staff.pets.show', $pet->pet_id) }}" class="block p-4 hover:bg-gray-50 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                            <i class="bi bi-paw text-emerald-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $pet->pet_name }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst($pet->species) }} - {{ $pet->owner->first_name ?? 'No owner' }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <i class="bi bi-inbox text-3xl mb-2 block"></i>
                    <p class="text-sm">No pets yet</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Vaccinations -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Recent Vaccinations</h3>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse(\App\Models\RabiesVaccinationReport::latest()->take(4)->get() as $vaccination)
                <a href="{{ route('admin-staff.vaccinations.show', $vaccination->id) }}" class="block p-4 hover:bg-gray-50 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="bi bi-shield-check text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $vaccination->pet_name }}</p>
                            <p class="text-xs text-gray-500">{{ $vaccination->vaccine_brand }} - {{ $vaccination->vaccination_date->format('M d, Y') }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <i class="bi bi-inbox text-3xl mb-2 block"></i>
                    <p class="text-sm">No vaccinations yet</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
