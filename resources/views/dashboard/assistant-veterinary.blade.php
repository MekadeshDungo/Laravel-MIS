@extends('layouts.admin')

@section('title', 'Assistant Veterinary Dashboard')

@section('header', 'Assistant Veterinary')
@section('subheader', 'Assistant Veterinary monitoring and reporting')

@php
$rolePrefix = str_replace('_', '-', auth()->user()->getRoleAttribute() ?? 'assistant-vet');
@endphp

@section('content')
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-green-600 to-teal-700 rounded-xl p-6 mb-8 text-white">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold mb-2">Assistant Veterinary Dashboard</h2>
            <p class="text-green-100">Monitor and manage animal health programs</p>
        </div>
        <div class="hidden md:block">
            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center">
                <i class="bi bi-bug text-4xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Bite & Rabies Reports Stats - Combined -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">
            <i class="bi bi-file-text mr-2 text-green-600"></i>Bite & Rabies Reports Overview
        </h3>
        <a href="{{ route($rolePrefix . '.rabies-bite-reports.index') }}" class="text-sm text-green-600 hover:text-green-800">
            View All Reports <i class="bi bi-arrow-right ml-1"></i>
        </a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <!-- Total -->
        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-4 border border-red-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-red-600 font-medium">Total Reports</p>
                    <p class="text-2xl font-bold text-red-700">{{ $stats['total_bite_reports'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-red-200 rounded-lg flex items-center justify-center">
                    <i class="bi bi-file-text text-red-600"></i>
                </div>
            </div>
        </div>

        <!-- Animal Bite -->
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4 border border-orange-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-orange-600 font-medium">Animal Bite</p>
                    <p class="text-2xl font-bold text-orange-700">{{ $stats['bite_stats']['total'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-orange-200 rounded-lg flex items-center justify-center">
                    <i class="bi bi-exclamation-triangle text-orange-600"></i>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-4 border border-yellow-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-yellow-600 font-medium">Pending</p>
                    <p class="text-2xl font-bold text-yellow-700">{{ ($stats['bite_stats']['pending'] ?? 0) + ($stats['rabies_stats']['pending'] ?? 0) }}</p>
                </div>
                <div class="w-10 h-10 bg-yellow-200 rounded-lg flex items-center justify-center">
                    <i class="bi bi-clock text-yellow-600"></i>
                </div>
            </div>
        </div>

        <!-- Checked/Acknowledged -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-blue-600 font-medium">Checked</p>
                    <p class="text-2xl font-bold text-blue-700">{{ ($stats['bite_stats']['investigating'] ?? 0) + ($stats['rabies_stats']['under_review'] ?? 0) }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-200 rounded-lg flex items-center justify-center">
                    <i class="bi bi-check2-square text-blue-600"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route($rolePrefix . '.rabies-bite-reports.index') }}" class="flex flex-col items-center p-4 bg-green-50 hover:bg-green-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-file-text text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Bite & Rabies</span>
        </a>

        <a href="{{ route($rolePrefix . '.rabies-geomap') }}" class="flex flex-col items-center p-4 bg-red-50 hover:bg-red-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-map text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Rabies Mapping</span>
        </a>

        <a href="{{ route($rolePrefix . '.vaccinations.index') }}" class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-shield-check text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Anti-Rabies Vaccination</span>
        </a>

        <a href="#" class="flex flex-col items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-heart text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Spay/Neuter</span>
        </a>
    </div>
</div>

<!-- Charts & Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Status Distribution Chart -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="bi bi-pie-chart mr-2 text-green-600"></i>Status Distribution
        </h3>
        @php
            $total = max(1, $stats['total_bite_reports'] ?? 1);
            $pending = ($stats['bite_stats']['pending'] ?? 0) + ($stats['rabies_stats']['pending'] ?? 0);
            $inProgress = ($stats['bite_stats']['investigating'] ?? 0) + ($stats['rabies_stats']['under_review'] ?? 0);
            $resolved = ($stats['bite_stats']['resolved'] ?? 0) + ($stats['rabies_stats']['resolved'] ?? 0);
            $closed = $stats['rabies_stats']['closed'] ?? 0;
        @endphp
        <div class="space-y-4">
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">Pending</span>
                    <span class="font-medium">{{ $pending }} ({{ round($pending / max($total, 1) * 100) }}%)</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-yellow-500 h-3 rounded-full" style="width: {{ $pending / max($total, 1) * 100 }}%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">Checked/Acknowledged</span>
                    <span class="font-medium">{{ $inProgress }} ({{ round($inProgress / max($total, 1) * 100) }}%)</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-blue-500 h-3 rounded-full" style="width: {{ $inProgress / max($total, 1) * 100 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Types Chart -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="bi bi-pie-chart mr-2 text-purple-600"></i>Report Types
        </h3>
        @php
            $biteTotal = $stats['bite_stats']['total'] ?? 0;
            $rabiesTotal = $stats['rabies_stats']['total'] ?? 0;
        @endphp
        <div class="flex items-center justify-center py-6">
            <div class="relative w-40 h-40">
                <svg class="w-full h-full" viewBox="0 0 100 100">
                    @if($biteTotal > 0 || $rabiesTotal > 0)
                    <circle class="text-gray-200" stroke-width="20" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50"></circle>
                    <circle class="text-orange-500" stroke-width="20" stroke-dasharray="{{ ($biteTotal / max($total, 1) * 251.2) }} 251.2" stroke-linecap="round" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50" transform="rotate(-90 50 50)"></circle>
                    <circle class="text-purple-500" stroke-width="20" stroke-dasharray="{{ ($rabiesTotal / max($total, 1) * 251.2) }} 251.2" stroke-linecap="round" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50" transform="rotate({{ 360 - ($biteTotal / max($total, 1) * 360) }} 50 50)"></circle>
                    @else
                    <circle class="text-gray-200" stroke-width="20" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50"></circle>
                    @endif
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-2xl font-bold text-gray-800">{{ $total }}</span>
                </div>
            </div>
        </div>
        <div class="flex justify-center gap-6 mt-4">
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 bg-orange-500 rounded-full"></div>
                <span class="text-sm text-gray-600">Animal Bite ({{ $biteTotal }})</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                <span class="text-sm text-gray-600">Rabies ({{ $rabiesTotal }})</span>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-semibold text-gray-800">
            <i class="bi bi-clock-history mr-2 text-green-600"></i>Recent Bite & Rabies Reports
        </h3>
        <a href="{{ route($rolePrefix . '.rabies-bite-reports.index') }}" class="text-sm text-green-600 hover:text-green-800">View All</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Case No.</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @php
                    $recentReports = \App\Models\BiteRabiesReport::latest()->take(5)->get();
                @endphp
                @forelse($recentReports as $report)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
                                <i class="bi bi-virus"></i>Bite & Rabies
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-800">{{ $report->report_number }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-gray-800">{{ $report->patient_name ?? 'Unknown' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-gray-600">{{ $report->created_at->format('M d, Y') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $status = $report->status;
                                $statusColors = [
                                    'Pending Review' => 'bg-yellow-100 text-yellow-700',
                                    'Under Review' => 'bg-blue-100 text-blue-700',
                                    'Resolved' => 'bg-green-100 text-green-700',
                                    'Closed' => 'bg-gray-100 text-gray-700',
                                ];
                            @endphp
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ $status ?? 'Unknown' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="bi bi-inbox text-3xl mb-2"></i>
                                <p>No recent reports</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
