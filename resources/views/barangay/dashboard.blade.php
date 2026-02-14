@extends('layouts.admin')

@section('title', 'Barangay Dashboard')

@section('header', 'Barangay Dashboard')
@section('subheader', 'Overview of your barangay operations')

@section('content')
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl p-6 mb-8 text-white">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h2>
            <p class="text-blue-100">Here's what's happening in your barangay today.</p>
        </div>
        <div class="hidden md:block">
            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center">
                <i class="bi bi-geo-alt text-4xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Reports</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\AnimalBiteReport::count() }}</p>
            </div>
            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-exclamation-triangle text-red-600"></i>
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
                <i class="bi bi-eyedropper text-green-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Strays</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\StrayReport::count() }}</p>
            </div>
            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="bi bi bi-currency-dollar text-yellow-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Impounds</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\ImpoundRecord::count() }}</p>
            </div>
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-box-seam text-purple-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('barangay.reports.create') }}" class="flex flex-col items-center p-4 bg-red-50 hover:bg-red-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-plus-circle text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">New Bite Report</span>
        </a>

        <a href="#" class="flex flex-col items-center p-4 bg-green-50 hover:bg-green-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-eyedropper text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Record Vaccination</span>
        </a>

        <a href="{{ route('barangay.reports.index') }}" class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-list text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">View Reports</span>
        </a>

        <a href="#" class="flex flex-col items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-printer text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Print Summary</span>
        </a>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Bite Reports -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-semibold text-gray-800">Recent Bite Reports</h3>
            <a href="{{ route('barangay.reports.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse(\App\Models\AnimalBiteReport::latest()->take(3)->get() as $report)
                <div class="p-4 hover:bg-gray-50 transition">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-blue-600">#{{ $report->id }}</span>
                        <span class="text-xs text-gray-500">{{ $report->created_at->format('M d') }}</span>
                    </div>
                    <p class="text-sm text-gray-700">{{ $report->victim_name }}</p>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-xs px-2 py-0.5 rounded-full capitalize
                            @switch($report->status)
                                @case('pending') bg-yellow-100 text-yellow-700 @break
                                @case('investigating') bg-blue-100 text-blue-700 @break
                                @case('resolved') bg-green-100 text-green-700 @break
                            @endswitch">
                            {{ $report->status }}
                        </span>
                        <span class="text-xs text-gray-400">{{ ucfirst($report->animal_type) }}</span>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <i class="bi bi-inbox text-3xl mb-2 block"></i>
                    <p class="text-sm">No bite reports yet</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Stray Reports -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-semibold text-gray-800">Recent Stray Reports</h3>
            <a href="#" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse(\App\Models\StrayReport::latest()->take(3)->get() as $report)
                <div class="p-4 hover:bg-gray-50 transition">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-gray-800">{{ $report->location_text ?? 'N/A' }}</span>
                        <span class="text-xs text-gray-500">{{ $report->reported_at->format('M d') }}</span>
                    </div>
                    <p class="text-sm text-gray-600">{{ ucfirst($report->species) }} - {{ Str::limit($report->description ?? 'No description', 30) }}</p>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-xs px-2 py-0.5 rounded-full capitalize
                            @switch($report->report_status)
                                @case('new') bg-yellow-100 text-yellow-700 @break
                                @case('validated') bg-blue-100 text-blue-700 @break
                                @case('responding') bg-orange-100 text-orange-700 @break
                                @case('closed') bg-green-100 text-green-700 @break
                            @endswitch">
                            {{ str_replace('_', ' ', $report->report_status) }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <i class="bi bi-inbox text-3xl mb-2 block"></i>
                    <p class="text-sm">No stray reports yet</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Monthly Stats Chart Placeholder -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mt-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Monthly Activity</h3>
    <div class="h-48 bg-gray-50 rounded-lg flex items-center justify-center">
        <div class="text-center text-gray-400">
            <i class="bi bi-bar-chart-line text-4xl mb-2"></i>
            <p>Chart placeholder - integrate with Chart.js for real data</p>
        </div>
    </div>
</div>
@endsection
