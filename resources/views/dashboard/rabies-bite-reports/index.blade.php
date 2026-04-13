@extends('layouts.admin')

@section('title', 'Animal Bite Incident Reports')

@section('header', 'Animal Bite Incident Reports')
@section('subheader', 'Manage submitted animal bite incident reports')

@php
$rolePrefix = str_replace('_', '-', auth()->user()->getRoleAttribute() ?? 'assistant-vet');

// Get available route for rabies-bite-reports
$rabiesReportsRoute = 'city-vet.rabies-bite-reports.index';
@endphp

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header with Breadcrumb -->
    <div class="mb-6">
        <nav class="text-sm text-gray-500 mb-2">
            <ol class="list-none p-0 flex items-center space-x-2">
                <li><a href="{{ route($rolePrefix . '.dashboard') }}" class="hover:text-green-600 transition">Dashboard</a></li>
                <li><i class="bi bi-chevron-right text-xs"></i></li>
                <li class="text-gray-800">Animal Bite Reports</li>
            </ol>
        </nav>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Animal Bite Incident Reports</h1>
                <p class="text-gray-500 mt-1">View and manage all animal bite incident reports submitted by citizens and facilities</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route($rolePrefix . '.dashboard') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition">
                    <i class="bi bi-arrow-left mr-1"></i>Back
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards - Interactive -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <a href="{{ route($rabiesReportsRoute) }}"
           class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md hover:scale-[1.03] transition-all duration-200 cursor-pointer group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500">Total Reports</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                </div>
                <div class="w-10 md:w-12 h-10 md:h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                    <i class="bi bi-file-text text-blue-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </a>
        <a href="{{ route($rabiesReportsRoute) }}?status=Pending Review"
           class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md hover:scale-[1.03] transition-all duration-200 cursor-pointer group border-l-4 border-l-yellow-400">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500">Pending Review</p>
                    <p class="text-xl md:text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                </div>
                <div class="w-10 md:w-12 h-10 md:h-12 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                    <i class="bi bi-clock text-yellow-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </a>
        <a href="{{ route($rabiesReportsRoute) }}?status=Under Review"
           class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md hover:scale-[1.03] transition-all duration-200 cursor-pointer group border-l-4 border-l-blue-400">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500">Under Review</p>
                    <p class="text-xl md:text-2xl font-bold text-blue-600">{{ $stats['under_review'] }}</p>
                </div>
                <div class="w-10 md:w-12 h-10 md:h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                    <i class="bi bi-search text-blue-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </a>
        <a href="{{ route($rabiesReportsRoute) }}?status=Resolved"
           class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md hover:scale-[1.03] transition-all duration-200 cursor-pointer group border-l-4 border-l-green-400">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500">Resolved</p>
                    <p class="text-xl md:text-2xl font-bold text-green-600">{{ $stats['resolved'] }}</p>
                </div>
                <div class="w-10 md:w-12 h-10 md:h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                    <i class="bi bi-check-circle text-green-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </a>
        <a href="{{ route($rabiesReportsRoute) }}?status=Closed"
           class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md hover:scale-[1.03] transition-all duration-200 cursor-pointer group border-l-4 border-l-gray-400">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500">Closed</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-600">{{ $stats['closed'] }}</p>
                </div>
                <div class="w-10 md:w-12 h-10 md:h-12 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                    <i class="bi bi-x-circle text-gray-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Enhanced Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 mb-6">
        <form method="GET" action="{{ route($rabiesReportsRoute) }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Search Bar -->
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <div class="relative">
                        <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search by Name or Case ID"
                               class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                    </div>
                </div>

                <!-- Date From -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <!-- Date To -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        <option value="">All Status</option>
                        <option value="Pending Review" {{ request('status') === 'Pending Review' ? 'selected' : '' }}>Pending Review</option>
                        <option value="Under Review" {{ request('status') === 'Under Review' ? 'selected' : '' }}>Under Review</option>
                        <option value="Resolved" {{ request('status') === 'Resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="Closed" {{ request('status') === 'Closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route($rabiesReportsRoute) }}"
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition">
                    <i class="bi bi-x-circle mr-1"></i>Clear
                </a>
                <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                    <i class="bi bi-funnel mr-1"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Reports Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($reports->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Report No.</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Patient Name</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Barangay</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Incident Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Animal</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($reports as $report)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <span class="font-medium text-gray-800">{{ $report->report_number }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                                            <i class="bi bi-person text-red-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $report->patient_name }}</p>
                                            <p class="text-sm text-gray-500">Age: {{ $report->age ?? 'N/A' }}, {{ $report->gender ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-gray-800">{{ $report->barangay->barangay_name ?? ($report->patient_barangay ?? 'N/A') }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-gray-600">{{ \Carbon\Carbon::parse($report->incident_date)->format('M d, Y') }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="text-gray-800">{{ ucfirst($report->animal_type) }}</p>
                                        <p class="text-sm text-gray-500">{{ ucfirst($report->animal_status) }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'Pending Review' => 'bg-yellow-100 text-yellow-700',
                                            'Under Review' => 'bg-blue-100 text-blue-700',
                                            'Resolved' => 'bg-green-100 text-green-700',
                                            'Closed' => 'bg-gray-100 text-gray-700',
                                        ];
                                        $statusIcons = [
                                            'Pending Review' => 'bi-clock',
                                            'Under Review' => 'bi-search',
                                            'Resolved' => 'bi-check-circle',
                                            'Closed' => 'bi-x-circle',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$report->status] ?? 'bg-gray-100 text-gray-700' }}">
                                        <i class="{{ $statusIcons[$report->status] ?? 'bi-circle' }}"></i>
                                        {{ $report->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route($rolePrefix . '.rabies-bite-reports.show', $report->id) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition">
                                        <i class="bi bi-eye"></i>
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $reports->links() }}
            </div>
        @else
            <!-- Enhanced Empty State -->
            <div class="p-12 text-center">
                <div class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="bi bi-virus text-green-400 text-4xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">No Rabies Bite Reports Found</h3>
                <p class="text-gray-500 mb-6 max-w-md mx-auto">Start by creating a new rabies bite report to begin tracking incidents.</p>
                <a href="{{ route('rabies-bite-report.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                    <i class="bi bi-plus-lg"></i>
                    Create New Report
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
