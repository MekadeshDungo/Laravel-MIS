@extends('layouts.admin')

@section('title', 'Viewer Dashboard')

@section('header', 'Viewer Dashboard')
@section('subheader', 'Read-only access to reports and data')

@section('content')
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-gray-600 to-gray-800 rounded-xl p-6 mb-8 text-white">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold mb-2">Welcome, {{ auth()->user()->name }}</h2>
            <p class="text-gray-200">View-only access to system reports and data.</p>
        </div>
        <div class="hidden md:block">
            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center">
                <i class="bi bi-eye text-4xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Stats Overview -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Bite Reports</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\BiteRabiesReport::count() }}</p>
            </div>
            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-exclamation-triangle text-red-600"></i>
            </div>
        </div>
    </div>

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
                <p class="text-xs text-gray-500">Meat Inspections</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\MeatInspectionReport::count() }}</p>
            </div>
            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-clipboard-check text-yellow-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Announcements</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Announcement::count() }}</p>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-megaphone text-blue-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Access -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Access</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.all-reports') }}" class="flex flex-col items-center p-4 bg-red-50 hover:bg-red-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-exclamation-triangle text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Bite Reports</span>
        </a>

        <a href="{{ route('admin.vaccination-reports.index') }}" class="flex flex-col items-center p-4 bg-green-50 hover:bg-green-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-eyedropper text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Anti-Rabies Vaccination</span>
        </a>

        <a href="{{ route('admin.meat-inspection-reports.index') }}" class="flex flex-col items-center p-4 bg-yellow-50 hover:bg-yellow-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-yellow-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-clipboard-check text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Meat Inspection</span>
        </a>

        <a href="{{ route('announcements.public.index') }}" class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-megaphone text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Announcements</span>
        </a>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h4 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="bi bi-exclamation-triangle text-red-600"></i> Bite Reports Summary
        </h4>
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Total Reports</span>
                <span class="text-sm font-medium text-gray-800">{{ \App\Models\BiteRabiesReport::count() }}</span>
            </div>
        </div>
        <div class="mt-4 text-center">
            <a href="{{ route('admin.all-reports') }}" class="text-sm text-blue-600 hover:text-blue-800">View All Reports →</a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h4 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="bi bi-eyedropper text-green-600"></i> Vaccination Summary
        </h4>
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Total Anti-Rabies Vaccination</span>
                <span class="text-sm font-medium text-gray-800">{{ \App\Models\RabiesVaccinationReport::count() }}</span>
            </div>
        </div>
        <div class="mt-4 text-center">
            <a href="{{ route('admin.vaccination-reports.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All Reports →</a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h4 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="bi bi-clipboard-check text-yellow-600"></i> Meat Inspection
        </h4>
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Total Inspections</span>
                <span class="text-sm font-medium text-gray-800">{{ \App\Models\MeatInspectionReport::count() }}</span>
            </div>
        </div>
        <div class="mt-4 text-center">
            <a href="{{ route('admin.meat-inspection-reports.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All Reports →</a>
        </div>
    </div>
</div>
@endsection
