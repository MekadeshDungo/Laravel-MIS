@extends('layouts.admin')

@section('title', 'Rabies Case Details')

@section('header', 'Rabies Case Details')
@section('subheader', 'View case information and updates')

@php
$rolePrefix = str_replace('_', '-', auth()->user()->role ?? 'assistant-vet');
@endphp

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header with Breadcrumb -->
    <div class="mb-6">
        <nav class="text-sm text-gray-500 mb-2">
            <ol class="list-none p-0 flex items-center space-x-2">
                <li><a href="{{ route('city-vet.dashboard') }}" class="hover:text-green-600 transition">Dashboard</a></li>
                <li><i class="bi bi-chevron-right text-xs"></i></li>
                <li><a href="{{ route('rabies-cases.index') }}" class="hover:text-green-600 transition">Rabies Cases</a></li>
                <li><i class="bi bi-chevron-right text-xs"></i></li>
                <li class="text-gray-800">Details</li>
            </ol>
        </nav>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Rabies Case Details</h1>
                <p class="text-gray-500 mt-1">Case No: {{ $case->case_number ?? 'RC-' . str_pad($case->id, 5, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('rabies-cases.index') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition">
                    <i class="bi bi-arrow-left mr-1"></i>Back to List
                </a>
                <button onclick="window.print()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    <i class="bi bi-printer mr-1"></i>Print
                </button>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            <i class="bi bi-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Status Badge -->
    <div class="mb-6 flex items-center gap-4 flex-wrap">
        <span class="text-lg font-semibold text-gray-700">Status:</span>
        @php
            $statusConfig = [
                'open' => ['class' => 'bg-yellow-100 text-yellow-800', 'icon' => 'bi-exclamation-circle'],
                'under_investigation' => ['class' => 'bg-blue-100 text-blue-800', 'icon' => 'bi-search'],
                'closed' => ['class' => 'bg-green-100 text-green-800', 'icon' => 'bi-check-circle'],
            ];
            $status = $statusConfig[$case->status] ?? ['class' => 'bg-gray-100 text-gray-800', 'icon' => 'bi-circle'];
        @endphp
        <span class="px-4 py-2 text-sm font-semibold rounded-full {{ $status['class'] }}">
            <i class="{{ $status['icon'] }} mr-1"></i>{{ ucfirst(str_replace('_', ' ', $case->status)) }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Case Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-red-600 px-6 py-3 flex items-center gap-2">
                    <i class="bi bi-bug text-white"></i>
                    <h3 class="text-lg font-semibold text-white">Case Information</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Case Type</label>
                            @php
                                $typeColors = [
                                    'positive' => 'bg-red-100 text-red-700',
                                    'probable' => 'bg-yellow-100 text-yellow-700',
                                    'suspect' => 'bg-blue-100 text-blue-700',
                                    'negative' => 'bg-green-100 text-green-700',
                                ];
                            @endphp
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium {{ $typeColors[$case->case_type] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($case->case_type ?? 'Unknown') }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Species</label>
                            <p class="text-gray-900 font-medium">{{ ucfirst($case->species ?? 'N/A') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Animal Name</label>
                            <p class="text-gray-900 font-medium">{{ $case->animal_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Incident Date</label>
                            <p class="text-gray-900 font-medium">{{ $case->incident_date ? \Carbon\Carbon::parse($case->incident_date)->format('F d, Y') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Owner Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-blue-600 px-6 py-3 flex items-center gap-2">
                    <i class="bi bi-person text-white"></i>
                    <h3 class="text-lg font-semibold text-white">Owner Information</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Owner Name</label>
                            <p class="text-gray-900 font-medium">{{ $case->owner_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Contact</label>
                            <p class="text-gray-900 font-medium">{{ $case->owner_contact ?? 'N/A' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Address</label>
                            <p class="text-gray-900 font-medium">{{ $case->address ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Location -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-green-600 px-6 py-3 flex items-center gap-2">
                    <i class="bi bi-geo-alt text-white"></i>
                    <h3 class="text-lg font-semibold text-white">Location</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Barangay</label>
                            <p class="text-gray-900 font-medium">{{ $case->barangay->barangay_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Incident Location</label>
                            <p class="text-gray-900 font-medium">{{ $case->incident_location ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Investigation Details -->
            @if($case->findings || $case->actions_taken || $case->remarks)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-purple-600 px-6 py-3 flex items-center gap-2">
                    <i class="bi bi-clipboard-pulse text-white"></i>
                    <h3 class="text-lg font-semibold text-white">Investigation Details</h3>
                </div>
                <div class="p-6 space-y-4">
                    @if($case->findings)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Findings</label>
                        <p class="text-gray-900 whitespace-pre-line">{{ $case->findings }}</p>
                    </div>
                    @endif
                    @if($case->actions_taken)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Actions Taken</label>
                        <p class="text-gray-900 whitespace-pre-line">{{ $case->actions_taken }}</p>
                    </div>
                    @endif
                    @if($case->remarks)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Remarks</label>
                        <p class="text-gray-900 whitespace-pre-line">{{ $case->remarks }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar - Actions -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
                <div class="bg-gray-800 px-6 py-3 flex items-center gap-2">
                    <i class="bi bi-gear text-white"></i>
                    <h3 class="text-lg font-semibold text-white">Actions</h3>
                </div>
                <div class="p-6 space-y-4">

                    <!-- Case Info -->
                    <div class="border-b border-gray-200 pb-4">
                        <h4 class="font-semibold text-gray-800 mb-3">Case Information</h4>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Case No:</span>
                                <span class="text-gray-900 font-medium">{{ $case->case_number ?? 'RC-' . str_pad($case->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Created:</span>
                                <span class="text-gray-900">{{ $case->created_at->format('M d, Y h:i A') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Updated:</span>
                                <span class="text-gray-900">{{ $case->updated_at->format('M d, Y h:i A') }}</span>
                            </div>
                            @if($case->user)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Encoded By:</span>
                                <span class="text-gray-900">{{ $case->user->name }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Linked Report -->
                    @if($case->rabiesReport)
                    <div class="border-b border-gray-200 pb-4">
                        <h4 class="font-semibold text-gray-800 mb-3">Linked Report</h4>
                        <div class="space-y-2 text-sm">
                            <a href="{{ route('city-vet.rabies-bite-reports.show', $case->rabiesReport->id) }}"
                               class="flex items-center gap-2 text-purple-600 hover:text-purple-800">
                                <i class="bi bi-file-text"></i>
                                <span>{{ $case->rabiesReport->report_number }}</span>
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- Status Actions -->
                    @if($case->status !== 'closed')
                        <a href="{{ route('rabies-cases.index') }}?status={{ $case->status }}"
                           class="w-full inline-flex justify-center items-center gap-2 px-4 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition">
                            <i class="bi bi-list"></i> View Similar Cases
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
