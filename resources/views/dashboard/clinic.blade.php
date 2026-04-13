@extends('layouts.admin')

@section('title', 'Clinic Dashboard')

@section('header', 'Clinic Portal')
@section('subheader', 'Veterinary clinic management')

@php
$user = Auth::user();
@endphp

@section('content')
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-green-600 to-teal-700 rounded-xl p-6 mb-8 text-white">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold mb-2">Clinic Portal</h2>
            <p class="text-green-100">Welcome, {{ $user->name }}</p>
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
                <p class="text-xs text-gray-500">My Bite Reports</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total_bite'] ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-exclamation-triangle text-red-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">My Vaccination Reports</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total_rabies'] ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-eyedropper text-green-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('clinic.bite-reports.create') }}" class="flex flex-col items-center p-4 bg-red-50 hover:bg-red-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-exclamation-triangle text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Submit Bite Report</span>
        </a>

        <a href="{{ route('clinic.vaccination-reports.create') }}" class="flex flex-col items-center p-4 bg-green-50 hover:bg-green-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-eyedropper text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">New Vaccination</span>
        </a>

        <a href="{{ route('clinic.bite-reports.index') }}" class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-file-text text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">My Bite Reports</span>
        </a>

        <a href="{{ route('clinic.vaccination-reports.index') }}" class="flex flex-col items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-clipboard-pulse text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">My Vaccinations</span>
        </a>
    </div>
</div>

<!-- Recent Reports -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Recent Bite Reports -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Recent Bite Reports</h3>
            <a href="{{ route('clinic.bite-reports.index') }}" class="text-sm text-green-600 hover:text-green-800">View All</a>
        </div>
        @if($biteReports->count() > 0)
            <div class="space-y-3">
                @foreach($biteReports as $report)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-800">{{ $report->patient_name }}</p>
                            <p class="text-sm text-gray-500">{{ $report->incident_date?->format('M d, Y') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No bite reports yet.</p>
            <a href="{{ route('clinic.bite-reports.create') }}" class="block text-center text-green-600 hover:text-green-800 text-sm">Submit your first bite report</a>
        @endif
    </div>

    <!-- Recent Vaccination Reports -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Recent Vaccination Reports</h3>
            <a href="{{ route('clinic.vaccination-reports.index') }}" class="text-sm text-green-600 hover:text-green-800">View All</a>
        </div>
        @if($rabiesReports->count() > 0)
            <div class="space-y-3">
                @foreach($rabiesReports as $report)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-800">{{ $report->patient_name }}</p>
                            <p class="text-sm text-gray-500">{{ $report->vaccination_date?->format('M d, Y') }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                            {{ $report->vaccine_brand }}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No vaccination reports yet.</p>
            <a href="{{ route('clinic.vaccination-reports.create') }}" class="block text-center text-green-600 hover:text-green-800 text-sm">Submit your first vaccination</a>
        @endif
    </div>
</div>
@endsection