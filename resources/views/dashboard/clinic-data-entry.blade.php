@extends('layouts.admin')

@section('title', 'Clinic Data Entry Dashboard')

@section('header', 'Clinic Data Entry')
@section('subheader', 'Clinic data management')

@section('content')
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-green-600 to-teal-700 rounded-xl p-6 mb-8 text-white">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold mb-2">Clinic Data Entry</h2>
            <p class="text-green-100">Manage clinic and veterinary data.</p>
        </div>
        <div class="hidden md:block">
            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center">
                <i class="bi bi-hospital text-4xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Anti-Rabies Vaccination</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\RabiesVaccinationReport::count() }}</p>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-eyedropper text-green-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Clinics</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Establishment::where('type', 'vet_clinic')->count() }}</p>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-hospital text-blue-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Pet Shops</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Establishment::where('type', 'pet_shop')->count() }}</p>
            </div>
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-shop text-purple-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Livestock</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\LivestockCensus::count() }}</p>
            </div>
            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-cow text-yellow-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('clinic.vaccination-reports.create') }}" class="flex flex-col items-center p-4 bg-green-50 hover:bg-green-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-eyedropper text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">New Vaccination</span>
        </a>

        <a href="#" class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-hospital text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Clinics</span>
        </a>

        <a href="#" class="flex flex-col items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-shop text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Pet Shops</span>
        </a>

        <a href="#" class="flex flex-col items-center p-4 bg-yellow-50 hover:bg-yellow-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-yellow-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-cow text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Livestock</span>
        </a>
    </div>
</div>
@endsection
