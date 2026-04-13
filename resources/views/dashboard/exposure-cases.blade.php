@extends('layouts.admin')

@section('title', 'Exposure Cases')

@section('header', 'Exposure Case Management')
@section('subheader', 'Unified Bite & Rabies Case Management')

@php
$rolePrefix = str_replace('_', '-', auth()->user()->role ?? 'city-vet');
@endphp

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-6">
        <nav class="text-sm text-gray-500 mb-2">
            <ol class="list-none p-0 flex items-center space-x-2">
                <li><a href="{{ route($rolePrefix . '.dashboard') }}" class="hover:text-green-600 transition">Dashboard</a></li>
                <li><i class="bi bi-chevron-right text-xs"></i></li>
                <li class="text-gray-800">Exposure Cases</li>
            </ol>
        </nav>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Exposure Cases</h1>
                <p class="text-gray-500 mt-1">Manage all animal bite and rabies exposure cases</p>
            </div>
            <div class="flex items-center gap-3">
                <form method="POST" action="{{ route($rolePrefix . '.exposure-cases.migrate') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                        <i class="bi bi-arrow-repeat mr-1"></i>Migrate from Bite Reports
                    </button>
                </form>
                <a href="{{ route($rolePrefix . '.exposure-cases-geomap.data') }}" target="_blank" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm">
                    <i class="bi bi-map mr-1"></i>View Map
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500">Total Cases</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $stats['total'] ?? 0 }}</p>
                </div>
                <div class="w-10 md:w-12 h-10 md:h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-file-text text-gray-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition border-l-4 border-l-yellow-400">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500">Pending</p>
                    <p class="text-xl md:text-2xl font-bold text-yellow-600">{{ $stats['pending'] ?? 0 }}</p>
                </div>
                <div class="w-10 md:w-12 h-10 md:h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-clock text-yellow-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition border-l-4 border-l-blue-400">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500">Approved</p>
                    <p class="text-xl md:text-2xl font-bold text-blue-600">{{ $stats['approved'] ?? 0 }}</p>
                </div>
                <div class="w-10 md:w-12 h-10 md:h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-check-circle text-blue-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition border-l-4 border-l-green-400">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500">Closed</p>
                    <p class="text-xl md:text-2xl font-bold text-green-600">{{ $stats['closed'] ?? 0 }}</p>
                </div>
                <div class="w-10 md:w-12 h-10 md:h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-archive text-green-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 mb-6">
        <form method="GET" action="{{ route($rolePrefix . '.exposure-cases.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Case #, Patient, Owner..."
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        <option value="all">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Report Type</label>
                    <select name="report_type" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        <option value="">All Types</option>
                        <option value="bite" {{ request('report_type') === 'bite' ? 'selected' : '' }}>Bite</option>
                        <option value="suspected_rabies" {{ request('report_type') === 'suspected_rabies' ? 'selected' : '' }}>Suspected Rabies</option>
                        <option value="confirmed_rabies" {{ request('report_type') === 'confirmed_rabies' ? 'selected' : '' }}>Confirmed Rabies</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Barangay</label>
                    <select name="barangay_id" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        <option value="">All Barangays</option>
                        @foreach($barangays as $brgy)
                            <option value="{{ $brgy->barangay_id }}" {{ request('barangay_id') == $brgy->barangay_id ? 'selected' : '' }}>{{ $brgy->barangay_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        <i class="bi bi-funnel mr-1"></i>Filter
                    </button>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>
            </div>
        </form>
    </div>

    <!-- Cases Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-700 font-medium">
                    <tr>
                        <th class="px-4 py-3">Case #</th>
                        <th class="px-4 py-3">Patient</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Barangay</th>
                        <th class="px-4 py-3">Date Reported</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($cases as $case)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $case->case_number }}</td>
                            <td class="px-4 py-3">{{ $case->patient_name ?? 'N/A' }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $typeColors = [
                                        'bite' => 'bg-yellow-100 text-yellow-800',
                                        'suspected_rabies' => 'bg-orange-100 text-orange-800',
                                        'confirmed_rabies' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $typeColors[$case->report_type] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $case->getReportTypeLabel() }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'approved' => 'bg-blue-100 text-blue-800',
                                        'closed' => 'bg-green-100 text-green-800',
                                    ];
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$case->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $case->getStatusLabel() }}
                                </span>
                            </td>
                            <td class="px-4 py-3">{{ $case->barangay?->barangay_name ?? 'N/A' }}</td>
                            <td class="px-4 py-3">{{ $case->date_reported?->format('M d, Y') ?? 'N/A' }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route($rolePrefix . '.exposure-cases.show', $case) }}" class="text-green-600 hover:text-green-800 font-medium">
                                    <i class="bi bi-eye mr-1"></i>View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                <i class="bi bi-inbox text-4xl mb-2 block"></i>
                                No exposure cases found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($cases->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">
                {{ $cases->links() }}
            </div>
        @endif
    </div>
</div>
@endsection