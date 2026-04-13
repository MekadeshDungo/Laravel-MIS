@extends('layouts.admin')

@section('title', 'Livestock Inspector Dashboard')

@section('header', 'Livestock Inspector Dashboard')
@section('subheader', 'Welcome back! Here\'s an overview of your livestock management activities.')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-green-700">Livestock Inspector Dashboard</h1>
        <p class="text-gray-600">Welcome back! Here's an overview of your livestock management activities.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Livestock -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Livestock</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($totalLivestock) }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Records -->
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-sm font-medium">Livestock Records</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($totalRecords) }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Establishments -->
        <div class="bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-teal-100 text-sm font-medium">Establishments</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($totalEstablishments) }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Establishments -->
        <div class="bg-gradient-to-br from-green-400 to-green-500 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Active Establishments</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($activeEstablishments) }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <a href="{{ route('livestock.create') }}" class="flex items-center gap-3 p-4 bg-green-50 hover:bg-green-100 rounded-lg transition">
                <div class="bg-green-500 rounded-full p-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-gray-800">Add Livestock</p>
                    <p class="text-sm text-gray-500">Record new livestock</p>
                </div>
            </a>
            <a href="{{ route('establishments.create') }}" class="flex items-center gap-3 p-4 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition">
                <div class="bg-emerald-500 rounded-full p-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-gray-800">Add Establishment</p>
                    <p class="text-sm text-gray-500">Register new business</p>
                </div>
            </a>
            <a href="{{ route('livestock.census') }}" class="flex items-center gap-3 p-4 bg-teal-50 hover:bg-teal-100 rounded-lg transition">
                <div class="bg-teal-500 rounded-full p-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-gray-800">View Census</p>
                    <p class="text-sm text-gray-500">Summary reports</p>
                </div>
            </a>
            <a href="{{ route('livestock.index') }}" class="flex items-center gap-3 p-4 bg-green-50 hover:bg-green-100 rounded-lg transition">
                <div class="bg-green-500 rounded-full p-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-gray-800">All Records</p>
                    <p class="text-sm text-gray-500">Browse all livestock</p>
                </div>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Records -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-gray-800">Recent Livestock Records</h2>
                <a href="{{ route('livestock.index') }}" class="text-green-600 hover:text-green-800 text-sm font-medium">View All</a>
            </div>
            <div class="space-y-3">
                @forelse($recentRecords as $record)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="flex items-center gap-3">
                            <div class="bg-green-100 rounded-full p-2">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $record->owner_name }}</p>
                                <p class="text-sm text-gray-500">{{ ucfirst($record->species) }} - {{ $record->tag_number ?? 'No tag' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">{{ $record->barangay->barangay_name ?? '-' }}</p>
                            <p class="text-xs text-gray-400">{{ $record->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No records found</p>
                @endforelse
            </div>
        </div>

        <!-- Count by Species -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-gray-800">Livestock by Species</h2>
            </div>
            <div class="space-y-3">
                @forelse($bySpecies as $item)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            <span class="font-medium text-gray-700">{{ ucfirst($item->species) }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-24 bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $totalLivestock > 0 ? ($item->total / $totalLivestock * 100) : 0 }}%"></div>
                            </div>
                            <span class="font-bold text-green-700">{{ number_format($item->total) }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No data available</p>
                @endforelse
            </div>
        </div>

        <!-- Top Barangays -->
        <div class="bg-white rounded-xl shadow-lg p-6 lg:col-span-2">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-gray-800">Top Barangays by Livestock Count</h2>
                <a href="{{ route('livestock.census') }}" class="text-green-600 hover:text-green-800 text-sm font-medium">View Census</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                @forelse($topBarangays as $index => $item)
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-500 text-white font-bold mb-2">
                            {{ $index + 1 }}
                        </div>
                        <p class="font-medium text-gray-800 text-sm">{{ $item->barangay->barangay_name ?? 'Unknown' }}</p>
                        <p class="text-xl font-bold text-green-700">{{ number_format($item->total) }}</p>
                        <p class="text-xs text-gray-500">records</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4 col-span-5">No data available</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
