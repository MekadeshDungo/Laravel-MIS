@extends('layouts.admin')

@section('title', 'Meat Inspection Reports')

@section('header', 'Meat Inspection Reports')
@section('subheader', 'View and manage meat inspection records')

@php
$role = auth()->user()->role ?? 'admin';
$dashboardRoutes = [
    'super_admin' => 'super-admin.dashboard',
    'admin' => 'admin.dashboard',
    'city_vet' => 'city-vet.dashboard',
    'admin_staff' => 'admin-staff.dashboard',
    'admin_asst' => 'admin-staff.dashboard',
    'assistant_vet' => 'assistant-vet.dashboard',
    'meat_inspector' => 'meat-inspection.dashboard',
    'livestock_inspector' => 'livestock.dashboard',
    'citizen' => 'owner.dashboard',
];
$rolePrefix = str_replace('_', '-', $role);
$dashboardRoute = $dashboardRoutes[$role] ?? $rolePrefix . '.dashboard';

// Determine the correct route prefix for meat inspection reports
$meatInspectionRoutePrefix = ($role === 'meat_inspector') ? 'meat-inspection.reports' : 'admin.meat-inspection-reports';
@endphp

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-2xl shadow-lg mb-6 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="text-white">
                <h1 class="text-2xl font-bold">Meat Inspection Reports</h1>
                <p class="text-red-100">Manage and track all meat inspection records</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route($dashboardRoute) }}" class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition backdrop-blur-sm">
                    <i class="bi bi-arrow-left mr-1"></i>Back
                </a>
                <a href="{{ route('meat-inspection.reports.create') }}" class="px-5 py-2.5 bg-white text-red-600 hover:bg-red-50 rounded-lg transition font-semibold shadow-md flex items-center gap-2">
                    <i class="bi bi-plus-lg"></i>New Report
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Inspections</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $reports->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center">
                    <i class="bi bi-clipboard-check text-red-600 text-2xl"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center text-sm text-gray-500">
                <i class="bi bi-graph-up mr-1"></i>
                <span>All time</span>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Compliant</p>
                    <p class="text-3xl font-bold text-green-600 mt-1">{{ $reports->where('compliance_status', 'compliant')->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="bi bi-check-circle text-green-600 text-2xl"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center text-sm text-green-600">
                <i class="bi bi-arrow-up mr-1"></i>
                <span>Passed inspections</span>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Non-Compliant</p>
                    <p class="text-3xl font-bold text-red-600 mt-1">{{ $reports->where('compliance_status', 'non_compliant')->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center">
                    <i class="bi bi-x-circle text-red-600 text-2xl"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center text-sm text-red-600">
                <i class="bi bi-exclamation-triangle mr-1"></i>
                <span>Condemned items</span>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">This Month</p>
                    @php
                    $count = $reports->filter(function ($item) {
                        return $item->created_at->month == now()->month &&
                               $item->created_at->year == now()->year;
                    })->count();
                    @endphp
                    <p class="text-3xl font-bold text-purple-600 mt-1">{{ $count }}</p>
                </div>
                <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="bi bi-calendar3 text-purple-600 text-2xl"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center text-sm text-gray-500">
                <i class="bi bi-calendar mr-1"></i>
                <span>{{ now()->format('F Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="bi bi-list-ul text-red-600"></i>
                Recent Inspection Records
            </h3>
            <a href="{{ route('meat-inspection.reports.index') }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1 font-medium">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        @if($reports->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Report ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Establishment</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Meat Type</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Compliance</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($reports as $report)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <span class="font-bold text-gray-800">MI-{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-shop text-orange-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $report->establishment_name ?? 'Unknown' }}</p>
                                        <p class="text-sm text-gray-500">{{ $report->establishment_address ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 capitalize">
                                    {{ $report->meat_type ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-800">{{ $report->quantity ?? 0 }}</span>
                                <span class="text-gray-500 text-sm">kg</span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'compliant' => 'bg-green-100 text-green-700 border-green-200',
                                        'non_compliant' => 'bg-red-100 text-red-700 border-red-200',
                                        'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-medium border {{ $statusColors[$report->compliance_status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                    {{ ucfirst(str_replace('_', ' ', $report->compliance_status ?? 'Unknown')) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route($meatInspectionRoutePrefix . '.show', $report) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition font-medium">
                                    <i class="bi bi-eye"></i>
                                    View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $reports->links() }}
            </div>
        @else
            <div class="p-16 text-center">
                <div class="w-24 h-24 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="bi bi-clipboard-check text-red-400 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">No Meat Inspection Reports Found</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">There are currently no recorded meat inspection reports. Start by creating a new report to begin monitoring.</p>
                <a href="{{ route('meat-inspection.reports.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                    <i class="bi bi-plus-lg"></i>
                    Create Meat Inspection Report
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
