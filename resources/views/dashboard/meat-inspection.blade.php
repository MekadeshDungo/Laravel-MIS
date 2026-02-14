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
    'disease_control' => 'disease-control.dashboard',
    'inventory_staff' => 'inventory.dashboard',
    'city_pound' => 'city-pound.dashboard',
    'meat_inspector' => 'meat-inspection.dashboard',
    'records_staff' => 'records-staff.dashboard',
    'barangay_encoder' => 'barangay.dashboard',
    'barangay' => 'barangay.dashboard',
    'clinic' => 'clinic.dashboard',
    'viewer' => 'viewer.dashboard',
];
$rolePrefix = str_replace('_', '-', $role);
$dashboardRoute = $dashboardRoutes[$role] ?? $rolePrefix . '.dashboard';

// Determine the correct route prefix for meat inspection reports
$meatInspectionRoutePrefix = ($role === 'meat_inspector') ? 'meat-inspection.reports' : 'admin.meat-inspection-reports';
@endphp

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Meat Inspection Reports</h1>
                <p class="text-gray-500">Manage and track all meat inspection records</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route($dashboardRoute) }}" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition">
                    <i class="bi bi-arrow-left mr-1"></i>Back
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Inspections</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $reports->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-clipboard-check text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Compliant</p>
                    <p class="text-2xl font-bold text-green-600">{{ $reports->where('compliance_status', 'compliant')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Non-Compliant</p>
                    <p class="text-2xl font-bold text-red-600">{{ $reports->where('compliance_status', 'non_compliant')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-x-circle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">This Month</p>
                    @php
                    $count = $reports->filter(function ($item) {
                        return $item->created_at->month == now()->month &&
                               $item->created_at->year == now()->year;
                    })->count();
                    @endphp
                    <p class="text-2xl font-bold text-purple-600">{{ $count }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-calendar3 text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($reports->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Report ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Establishment</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Meat Type</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Quantity</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Compliance</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($reports as $report)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-800">MI-{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                        <i class="bi bi-shop text-orange-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $report->establishment_name ?? 'Unknown' }}</p>
                                        <p class="text-sm text-gray-500">{{ $report->establishment_address ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-800">{{ $report->meat_type ?? 'N/A' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-800">{{ $report->quantity ?? 0 }} kg</p>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'compliant' => 'bg-green-100 text-green-700',
                                        'non_compliant' => 'bg-red-100 text-red-700',
                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$report->compliance_status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst(str_replace('_', ' ', $report->compliance_status ?? 'Unknown')) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route($meatInspectionRoutePrefix . '.show', $report) }}" class="inline-flex items-center gap-1 px-3 py-1 text-sm text-blue-600 hover:text-blue-800 transition">
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
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-clipboard-check text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-800 mb-2">No meat inspection reports found</h3>
                <p class="text-gray-500">No meat inspection reports have been submitted yet.</p>
            </div>
        @endif
    </div>
</div>
