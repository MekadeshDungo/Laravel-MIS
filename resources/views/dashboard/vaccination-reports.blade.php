@extends('layouts.admin')

@section('title', 'Rabies Vaccination Reports')

@section('header', 'Rabies Vaccination Reports')
@section('subheader', 'View and manage vaccination records from clinics')

@php
$rolePrefix = str_replace('_', '-', auth()->user()->role ?? 'admin');
@endphp

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Rabies Vaccination Reports</h1>
                <p class="text-gray-500">Manage and track all rabies vaccination records</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route($rolePrefix . '.dashboard') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition">
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
                    <p class="text-sm text-gray-500">Total Reports</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $reports->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-shield-check text-blue-600 text-xl"></i>
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
                    <p class="text-2xl font-bold text-green-600">{{ $count }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-calendar-check text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Vaccinated Animals</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $reports->sum('number_of_animals') ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-bug text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Active Clinics</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $reports->unique('clinic_name')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-hospital text-orange-600 text-xl"></i>
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
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Clinic</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Vaccine Used</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Animals</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Report Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($reports as $report)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-800">RV-{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="bi bi-hospital text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $report->clinic_name ?? 'Unknown' }}</p>
                                        <p class="text-sm text-gray-500">{{ $report->clinic_address ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-800">{{ $report->vaccine_name ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-500">{{ $report->vaccine_batch ?? 'N/A' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-800">{{ $report->number_of_animals ?? 0 }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-600">{{ $report->report_date ? \Carbon\Carbon::parse($report->report_date)->format('M d, Y') : 'N/A' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route($rolePrefix . '.vaccination-reports.show', $report) }}" class="inline-flex items-center gap-1 px-3 py-1 text-sm text-blue-600 hover:text-blue-800 transition">
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
            <div class="p-16 text-center">
                <div class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="bi bi-shield-check text-green-400 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">No Vaccination Reports Found</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">There are currently no recorded vaccination reports. Start by creating a new vaccination report to begin tracking.</p>
                <a href="#" class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                    <i class="bi bi-plus-lg"></i>
                    Create Vaccination Report
                </a>
            </div>
        @endif
    </div>
</div>
