@extends('layouts.admin')

@section('title', 'Rabies Cases')

@section('header', 'Rabies Cases Management')
@section('subheader', 'Track and manage rabies cases')

@php
$rolePrefix = str_replace('_', '-', auth()->user()->role ?? 'assistant-vet');
@endphp

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-6">
        <nav class="text-sm text-gray-500 mb-2">
            <ol class="list-none p-0 flex items-center space-x-2">
                <li><a href="{{ route($rolePrefix . '.dashboard') }}" class="hover:text-green-600 transition">Dashboard</a></li>
                <li><i class="bi bi-chevron-right text-xs"></i></li>
                <li class="text-gray-800">Rabies Cases</li>
            </ol>
        </nav>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Rabies Cases</h1>
                <p class="text-gray-500 mt-1">Manage and track all rabies cases in the system</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route($rolePrefix . '.dashboard') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition">
                    <i class="bi bi-arrow-left mr-1"></i>Back
                </a>
                <a href="{{ route($rolePrefix . '.rabies-bite-reports.index') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                    <i class="bi bi-plus-lg mr-1"></i>From Report
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <a href="{{ route(rabies-cases.index) }}"
           class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:scale-[1.02] transition-all duration-200 cursor-pointer group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500">Total Cases</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $cases->total() }}</p>
                </div>
                <div class="w-10 md:w-12 h-10 md:h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                    <i class="bi bi-bug text-red-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </a>
        <a href="{{ route(rabies-cases.index) }}?status=open"
           class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:scale-[1.02] transition-all duration-200 cursor-pointer group border-l-4 border-l-yellow-400">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500">Open Cases</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $cases->where('status', 'open')->count() }}</p>
                </div>
                <div class="w-10 md:w-12 h-10 md:h-12 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                    <i class="bi bi-exclamation-circle text-yellow-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </a>
        <a href="{{ route(rabies-cases.index) }}?status=under_investigation"
           class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:scale-[1.02] transition-all duration-200 cursor-pointer group border-l-4 border-l-blue-400">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500">Under Investigation</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $cases->where('status', 'under_investigation')->count() }}</p>
                </div>
                <div class="w-10 md:w-12 h-10 md:h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                    <i class="bi bi-search text-blue-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </a>
        <a href="{{ route(rabies-cases.index) }}?status=closed"
           class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:scale-[1.02] transition-all duration-200 cursor-pointer group border-l-4 border-l-green-400">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500">Closed Cases</p>
                    <p class="text-2xl font-bold text-green-600">{{ $cases->where('status', 'closed')->count() }}</p>
                </div>
                <div class="w-10 md:w-12 h-10 md:h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                    <i class="bi bi-check-circle text-green-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 mb-6">
        <form method="GET" action="{{ route(rabies-cases.index) }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <div class="relative">
                        <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search by Case No., Animal Name, or Owner"
                               class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                    </div>
                </div>

                <!-- Case Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Case Type</label>
                    <select name="case_type" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        <option value="">All Types</option>
                        <option value="positive" {{ request('case_type') === 'positive' ? 'selected' : '' }}>Positive</option>
                        <option value="probable" {{ request('case_type') === 'probable' ? 'selected' : '' }}>Probable</option>
                        <option value="suspect" {{ request('case_type') === 'suspect' ? 'selected' : '' }}>Suspect</option>
                        <option value="negative" {{ request('case_type') === 'negative' ? 'selected' : '' }}>Negative</option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        <option value="">All Status</option>
                        <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                        <option value="under_investigation" {{ request('status') === 'under_investigation' ? 'selected' : '' }}>Under Investigation</option>
                        <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route(rabies-cases.index) }}"
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition">
                    <i class="bi bi-x-circle mr-1"></i>Clear
                </a>
                <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                    <i class="bi bi-funnel mr-1"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Cases Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($cases->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Case No.</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Case Type</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Animal</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Owner</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Location</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Incident Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($cases as $case)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-800">{{ $case->case_number ?? 'RC-' . str_pad($case->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $typeColors = [
                                        'positive' => 'bg-red-100 text-red-700',
                                        'probable' => 'bg-yellow-100 text-yellow-700',
                                        'suspect' => 'bg-blue-100 text-blue-700',
                                        'negative' => 'bg-green-100 text-green-700',
                                    ];
                                    $typeIcons = [
                                        'positive' => 'bi bi-exclamation-triangle',
                                        'probable' => 'bi bi-exclamation-circle',
                                        'suspect' => 'bi bi-question-circle',
                                        'negative' => 'bi bi-check-circle',
                                    ];
                                @endphp
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium {{ $typeColors[$case->case_type] ?? 'bg-gray-100 text-gray-700' }}">
                                    <i class="{{ $typeIcons[$case->case_type] ?? 'bi bi-circle' }}"></i>
                                    {{ ucfirst($case->case_type ?? 'Unknown') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-paw text-purple-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ ucfirst($case->species ?? 'Unknown') }}</p>
                                        <p class="text-sm text-gray-500">{{ $case->animal_name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-800">{{ $case->owner_name ?? 'N/A' }}</p>
                                @if($case->owner_contact)
                                    <p class="text-sm text-gray-500">{{ $case->owner_contact }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-800">{{ $case->barangay->barangay_name ?? ($case->incident_location ?? 'N/A') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-600">{{ $case->incident_date ? \Carbon\Carbon::parse($case->incident_date)->format('M d, Y') : 'N/A' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'open' => 'bg-yellow-100 text-yellow-700',
                                        'under_investigation' => 'bg-blue-100 text-blue-700',
                                        'closed' => 'bg-green-100 text-green-700',
                                    ];
                                    $statusIcons = [
                                        'open' => 'bi bi-exclamation-circle',
                                        'under_investigation' => 'bi bi-search',
                                        'closed' => 'bi bi-check-circle',
                                    ];
                                @endphp
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$case->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    <i class="{{ $statusIcons[$case->status] ?? 'bi bi-circle' }}"></i>
                                    {{ ucfirst(str_replace('_', ' ', $case->status ?? 'Unknown')) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('rabies-cases.show', $case->id) }}"
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
                {{ $cases->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="p-16 text-center">
                <div class="w-24 h-24 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="bi bi-bug text-red-400 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">No Rabies Cases Found</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">There are currently no recorded rabies cases. Start by converting a Rabies Bite Report to a case.</p>
                <a href="{{ route($rolePrefix . '.rabies-bite-reports.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                    <i class="bi bi-plus-lg"></i>
                    Create from Report
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
