@extends('layouts.admin')

@section('title', 'Rabies Cases')

@section('header', 'Rabies Cases Management')
@section('subheader', 'Track and manage rabies cases')

@php
$rolePrefix = str_replace('_', '-', auth()->user()->role ?? 'disease-control');
@endphp

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Rabies Cases</h1>
                <p class="text-gray-500">Manage and track all rabies cases in the system</p>
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
                    <p class="text-sm text-gray-500">Total Cases</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $cases->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-clipboard2-pulse text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Open Cases</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $cases->where('status', 'open')->count() ?? 'N/A' }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-exclamation-circle text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Under Treatment</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $cases->where('status', 'treatment')->count() ?? 'N/A' }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-activity text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Closed Cases</p>
                    <p class="text-2xl font-bold text-green-600">{{ $cases->where('status', 'closed')->count() ?? 'N/A' }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" action="{{ route($rolePrefix . '.rabies-cases.index') }}" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">All Status</option>
                    <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                    <option value="treatment" {{ request('status') === 'treatment' ? 'selected' : '' }}>Under Treatment</option>
                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                    <i class="bi bi-funnel mr-1"></i>Filter
                </button>
                <a href="{{ route($rolePrefix . '.rabies-cases.index') }}" class="px-6 py-2 text-gray-600 hover:text-gray-800 font-medium transition">
                    Clear
                </a>
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
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Case ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Animal</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Location</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Reported Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($cases as $case)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-800">RC-{{ str_pad($case->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                        <i class="bi bi-bug text-orange-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $case->animal_type ?? 'Unknown' }}</p>
                                        <p class="text-sm text-gray-500">{{ $case->animal_name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-800">{{ $case->location ?? 'N/A' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-600">{{ $case->reported_date ? \Carbon\Carbon::parse($case->reported_date)->format('M d, Y') : 'N/A' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'open' => 'bg-yellow-100 text-yellow-700',
                                        'treatment' => 'bg-blue-100 text-blue-700',
                                        'closed' => 'bg-green-100 text-green-700',
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$case->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($case->status ?? 'Unknown') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="#" class="inline-flex items-center gap-1 px-3 py-1 text-sm text-blue-600 hover:text-blue-800 transition">
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
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-clipboard2-pulse text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-800 mb-2">No rabies cases found</h3>
                <p class="text-gray-500">Get started by creating a new rabies case report.</p>
            </div>
        @endif
    </div>
</div>
