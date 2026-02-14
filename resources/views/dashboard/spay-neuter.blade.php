@extends('layouts.admin')

@section('title', 'Spay/Neuter Dashboard')

@section('content')
<div class="w-full">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h1 class="text-xl md:text-2xl font-bold text-gray-800">Spay/Neuter Dashboard</h1>
        <a href="{{ route('spay-neuter.reports.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <i class="bi bi-plus-lg"></i> New Report
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-600 text-white rounded-xl shadow-sm p-6">
            <h5 class="text-blue-100 text-sm font-medium mb-2">Total Reports</h5>
            <h2 class="text-3xl md:text-4xl font-bold">{{ $totalReports }}</h2>
        </div>
        <div class="bg-green-500 text-white rounded-xl shadow-sm p-6">
            <h5 class="text-green-100 text-sm font-medium mb-2">Completed</h5>
            <h2 class="text-3xl md:text-4xl font-bold">{{ $completed }}</h2>
        </div>
        <div class="bg-cyan-500 text-white rounded-xl shadow-sm p-6">
            <h5 class="text-cyan-100 text-sm font-medium mb-2">Scheduled</h5>
            <h2 class="text-3xl md:text-4xl font-bold">{{ $scheduled }}</h2>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
        <div class="px-6 py-4 border-b border-gray-100">
            <h5 class="font-semibold text-gray-800">Quick Actions</h5>
        </div>
        <div class="p-6">
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('spay-neuter.reports.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition">
                    <i class="bi bi-list"></i> All Reports
                </a>
                <a href="{{ route('spay-neuter.reports.create') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-green-600 text-green-600 rounded-lg hover:bg-green-50 transition">
                    <i class="bi bi-plus-lg"></i> New Report
                </a>
                <a href="{{ route('spay-neuter.reports.index') }}?status=completed" class="inline-flex items-center gap-2 px-4 py-2 border border-green-500 text-green-600 rounded-lg hover:bg-green-50 transition">
                    <i class="bi bi-check-circle"></i> Completed
                </a>
                <a href="{{ route('spay-neuter.reports.index') }}?status=scheduled" class="inline-flex items-center gap-2 px-4 py-2 border border-cyan-500 text-cyan-600 rounded-lg hover:bg-cyan-50 transition">
                    <i class="bi bi-calendar"></i> Scheduled
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Reports -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h5 class="font-semibold text-gray-800">Recent Reports</h5>
        </div>
        <div class="overflow-x-auto">
            @if($reports->count() > 0)
            <table class="w-full min-w-[600px]">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Owner</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pet</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Procedure</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($reports as $report)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $report->procedure_date->format('M d, Y') }}</td>
                        <td class="px-4 py-3 text-sm">{{ $report->owner_name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ ucfirst($report->pet_type) }}</td>
                        <td class="px-4 py-3">
                            @if($report->procedure_type == 'spay')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Spay</span>
                            @elseif($report->procedure_type == 'neuter')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-cyan-100 text-cyan-800">Neuter</span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Both</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($report->status == 'completed')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Completed</span>
                            @elseif($report->status == 'scheduled')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-cyan-100 text-cyan-800">Scheduled</span>
                            @elseif($report->status == 'cancelled')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Cancelled</span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('spay-neuter.reports.show', $report->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition">
                                <i class="bi bi-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="p-8 text-center text-gray-500">
                <i class="bi bi-inbox text-4xl mb-3 block"></i>
                <p>No spay/neuter reports yet.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
