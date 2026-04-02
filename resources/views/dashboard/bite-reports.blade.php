@extends('layouts.admin')

@section('title', 'Bite & Rabies Reports')

@section('header', 'Bite & Rabies Reports Management')
@section('subheader', 'Track and manage all animal bite and rabies incident reports')

@php
$rolePrefix = str_replace('_', '-', auth()->user()->role ?? 'disease-control');
$currentType = $type ?? 'all';
@endphp

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-6">
        <nav class="text-sm text-gray-500 mb-2">
            <ol class="list-none p-0 flex items-center space-x-2">
                <li><a href="{{ route($rolePrefix . '.dashboard') }}" class="hover:text-green-600 transition">Dashboard</a></li>
                <li><i class="bi bi-chevron-right text-xs"></i></li>
                <li class="text-gray-800">Bite & Rabies Reports</li>
            </ol>
        </nav>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Bite & Rabies Reports</h1>
                <p class="text-gray-500 mt-1">Manage all animal bite incident reports (Animal Bite & Rabies)</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route($rolePrefix . '.dashboard') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition">
                    <i class="bi bi-arrow-left mr-1"></i>Back
                </a>
            </div>
        </div>
    </div>

    <!-- Type Filter Tabs -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-2 mb-6">
        <div class="flex gap-2">
            <a href="{{ route($rolePrefix . '.animal-bite-reports.index') }}?{{ http_build_query(array_merge(request()->except('type'), ['type' => 'all'])) }}"
               class="flex-1 px-4 py-2 text-center rounded-lg font-medium transition {{ $currentType === 'all' ? 'bg-green-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <i class="bi bi-list-ul mr-2"></i>All Reports ({{ ($stats['bite']['total'] ?? 0) + ($stats['rabies']['total'] ?? 0) }})
            </a>
            <a href="{{ route($rolePrefix . '.animal-bite-reports.index') }}?{{ http_build_query(array_merge(request()->except('type'), ['type' => 'bite'])) }}"
               class="flex-1 px-4 py-2 text-center rounded-lg font-medium transition {{ $currentType === 'bite' ? 'bg-green-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <i class="bi bi-exclamation-triangle mr-2"></i>Animal Bite ({{ $stats['bite']['total'] ?? 0 }})
            </a>
            <a href="{{ route($rolePrefix . '.animal-bite-reports.index') }}?{{ http_build_query(array_merge(request()->except('type'), ['type' => 'rabies'])) }}"
               class="flex-1 px-4 py-2 text-center rounded-lg font-medium transition {{ $currentType === 'rabies' ? 'bg-green-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <i class="bi bi-virus mr-2"></i>Rabies Reports ({{ $stats['rabies']['total'] ?? 0 }})
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <!-- Total -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500">Total Reports</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $stats['total'] ?? 0 }}</p>
                </div>
                <div class="w-10 md:w-12 h-10 md:h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-file-text text-red-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
        <!-- Pending -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition border-l-4 border-l-yellow-400">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500">Pending</p>
                    <p class="text-xl md:text-2xl font-bold text-yellow-600">{{ ($stats['bite']['pending'] ?? 0) + ($stats['rabies']['pending'] ?? 0) }}</p>
                </div>
                <div class="w-10 md:w-12 h-10 md:h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-clock text-yellow-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
        <!-- Checked -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition border-l-4 border-l-blue-400">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500">Checked</p>
                    <p class="text-xl md:text-2xl font-bold text-blue-600">{{ ($stats['bite']['in_progress'] ?? 0) + ($stats['rabies']['under_review'] ?? 0) }}</p>
                </div>
                <div class="w-10 md:w-12 h-10 md:h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-check2-square text-blue-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Simple Charts Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Status Distribution -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Distribution</h3>
            <div class="space-y-3">
                @php
                    $total = max(1, $stats['total'] ?? 1);
                    $pending = ($stats['bite']['pending'] ?? 0) + ($stats['rabies']['pending'] ?? 0);
                    $inProgress = ($stats['bite']['in_progress'] ?? 0) + ($stats['rabies']['under_review'] ?? 0);
                @endphp
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Pending</span>
                        <span class="font-medium">{{ $pending }} ({{ round($pending / $total * 100) }}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $pending / $total * 100 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Checked/Acknowledged</span>
                        <span class="font-medium">{{ $inProgress }} ({{ round($inProgress / $total * 100) }}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $inProgress / $total * 100 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Types -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Report Types</h3>
            <div class="space-y-3">
                @php
                    $biteTotal = $stats['bite']['total'] ?? 0;
                    $rabiesTotal = $stats['rabies']['total'] ?? 0;
                @endphp
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Animal Bite Reports</span>
                        <span class="font-medium">{{ $biteTotal }} ({{ round($biteTotal / max($total, 1) * 100) }}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-red-500 h-2 rounded-full" style="width: {{ $biteTotal / max($total, 1) * 100 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Rabies Reports</span>
                        <span class="font-medium">{{ $rabiesTotal }} ({{ round($rabiesTotal / max($total, 1) * 100) }}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-purple-500 h-2 rounded-full" style="width: {{ $rabiesTotal / max($total, 1) * 100 }}%"></div>
                    </div>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-gray-100">
                <div class="flex items-center justify-center gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-red-600">{{ $biteTotal }}</div>
                        <div class="text-xs text-gray-500">Animal Bite</div>
                    </div>
                    <div class="text-gray-300">+</div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ $rabiesTotal }}</div>
                        <div class="text-xs text-gray-500">Rabies</div>
                    </div>
                    <div class="text-gray-300">=</div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-800">{{ $total }}</div>
                        <div class="text-xs text-gray-500">Total</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 mb-6">
        <form method="GET" action="{{ route($rolePrefix . '.animal-bite-reports.index') }}" class="space-y-4">
            <input type="hidden" name="type" value="{{ $currentType }}">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
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
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress/Under Review</option>
                        <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <!-- Quick Filters -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quick Filter</label>
                    <select name="quick_filter" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" onchange="this.form.submit()">
                        <option value="">All Time</option>
                        <option value="today" {{ request('quick_filter') === 'today' ? 'selected' : '' }}>Today</option>
                        <option value="week" {{ request('quick_filter') === 'week' ? 'selected' : '' }}>This Week</option>
                        <option value="month" {{ request('quick_filter') === 'month' ? 'selected' : '' }}>This Month</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route($rolePrefix . '.animal-bite-reports.index') }}"
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
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Case ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Patient Name</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Barangay</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($reports as $report)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                @if($report->report_type === 'rabies')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
                                        <i class="bi bi-virus"></i>Rabies
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                        <i class="bi bi-exclamation-triangle"></i>Bite
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($report->report_type === 'rabies')
                                    <span class="font-medium text-purple-600">RB-{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}</span>
                                @else
                                    <span class="font-medium text-gray-800">AB-{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-person text-red-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">
                                            @if($report->report_type === 'rabies')
                                                {{ $report->patient_name ?? 'Unknown' }}
                                            @else
                                                {{ $report->victim_name ?? 'Unknown' }}
                                            @endif
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            @if($report->report_type === 'rabies')
                                                {{ $report->patient_age ?? 'N/A' }} yrs old
                                            @else
                                                {{ $report->victim_age ?? 'N/A' }} yrs old
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-800">
                                    @if($report->report_type === 'rabies')
                                        {{ $report->patientBarangay->barangay_name ?? $report->barangay->barangay_name ?? 'N/A' }}
                                    @else
                                        {{ $report->barangay->barangay_name ?? $report->bite_location ?? 'N/A' }}
                                    @endif
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-600">
                                    @if($report->report_type === 'rabies')
                                        {{ $report->created_at->format('M d, Y') }}
                                    @else
                                        {{ $report->bite_date ? \Carbon\Carbon::parse($report->bite_date)->format('M d, Y') : 'N/A' }}
                                    @endif
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $status = $report->status;
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                        'Pending Review' => 'bg-yellow-100 text-yellow-700',
                                        'in_progress' => 'bg-blue-100 text-blue-700',
                                        'Under Review' => 'bg-blue-100 text-blue-700',
                                        'resolved' => 'bg-green-100 text-green-700',
                                        'Resolved' => 'bg-green-100 text-green-700',
                                        'closed' => 'bg-gray-100 text-gray-700',
                                        'Closed' => 'bg-gray-100 text-gray-700',
                                    ];
                                @endphp
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ str_replace('_', ' ', ucfirst($status ?? 'Unknown')) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    @if($report->report_type === 'rabies')
                                        <a href="{{ route($rolePrefix . '.rabies-bite-reports.show', $report->id) }}"
                                           class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition">
                                            <i class="bi bi-eye"></i>View
                                        </a>
                                        @if($report->status === 'Pending Review')
                                        <form method="POST" action="{{ route($rolePrefix . '.rabies-bite-reports.check', $report->id) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-green-600 hover:text-green-800 hover:bg-green-50 rounded-lg transition">
                                                <i class="bi bi-check2-square"></i>Check
                                            </button>
                                        </form>
                                        @endif
                                    @else
                                        <a href="{{ route($rolePrefix . '.animal-bite-reports.show', $report->id) }}"
                                           class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition">
                                            <i class="bi bi-eye"></i>View
                                        </a>
                                        @if($report->status === 'pending')
                                        <form method="POST" action="{{ route($rolePrefix . '.animal-bite-reports.check', $report->id) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-green-600 hover:text-green-800 hover:bg-green-50 rounded-lg transition">
                                                <i class="bi bi-check2-square"></i>Check
                                            </button>
                                        </form>
                                        @endif
                                    @endif
                                </div>
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
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-inbox text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-800 mb-2">No Reports Found</h3>
                <p class="text-gray-500">No bite or rabies reports match your current filters.</p>
            </div>
        @endif
    </div>
</div>
@endsection
