@extends('layouts.admin')

@section('title', 'Bite Reports')

@section('header', 'My Bite Reports')
@section('subheader', 'List of submitted bite incident reports')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">My Bite Reports</h1>
                <p class="text-gray-500 mt-1">Track and manage submitted bite incident reports</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('clinic.bite-reports.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    <i class="bi bi-plus-lg mr-1"></i>New Bite Report
                </a>
            </div>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-700 font-medium">
                    <tr>
                        <th class="px-4 py-3">Report #</th>
                        <th class="px-4 py-3">Patient</th>
                        <th class="px-4 py-3">Animal</th>
                        <th class="px-4 py-3">Incident Date</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reports as $report)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $report->report_number }}</td>
                            <td class="px-4 py-3">{{ $report->patient_name }}</td>
                            <td class="px-4 py-3">
                                {{ $report->animal_species }}
                                <span class="text-gray-500 text-xs">({{ $report->animal_status }})</span>
                            </td>
                            <td class="px-4 py-3">{{ $report->incident_date?->format('M d, Y') }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $statusColors = [
                                        'Pending Review' => 'bg-yellow-100 text-yellow-800',
                                        'Under Review' => 'bg-blue-100 text-blue-800',
                                        'resolved' => 'bg-green-100 text-green-800',
                                        'closed' => 'bg-gray-100 text-gray-800',
                                    ];
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$report->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $report->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('clinic.bite-reports.show', $report) }}" class="text-green-600 hover:text-green-800 font-medium">
                                    <i class="bi bi-eye mr-1"></i>View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                <i class="bi bi-inbox text-4xl mb-2 block"></i>
                                No bite reports found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($reports->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">
                {{ $reports->links() }}
            </div>
        @endif
    </div>
</div>
@endsection