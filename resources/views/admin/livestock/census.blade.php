@extends('layouts.admin')

@section('title', 'Livestock Census Summary')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-green-700">Livestock Census Summary</h1>
        <a href="{{ route('livestock.index') }}" class="text-gray-600 hover:text-gray-800 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Records
        </a>
    </div>

    <!-- Grand Total -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-lg shadow-lg p-6 mb-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg opacity-90">Grand Total Livestock</h2>
                <p class="text-4xl font-bold">{{ number_format($grandTotal) }}</p>
            </div>
            <div class="text-right">
                <svg class="w-16 h-16 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Overall by Animal Type -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Overall Count by Animal Type</h2>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            @foreach($overallByAnimalType as $type => $count)
                <div class="bg-green-50 rounded-lg p-4 text-center">
                    <p class="text-sm text-gray-600 uppercase tracking-wider">{{ ucfirst($type) }}</p>
                    <p class="text-2xl font-bold text-green-700">{{ number_format($count) }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Total by Barangay -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Total Livestock Count by Barangay</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-green-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barangay</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Count</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($totalByBarangay as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $item->barangay->barangay_name ?? 'Unknown' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right font-bold text-green-700 text-lg">{{ number_format($item->total_count) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-4 text-center text-gray-500">No data available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Census by Animal Type per Barangay -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Census Data by Animal Type per Barangay</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-green-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barangay</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Animal Type</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Count</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        $currentBarangay = null;
                    @endphp
                    @forelse($censusByAnimalType as $barangayId => $records)
                        @foreach($records as $record)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                    @if($currentBarangay != $barangayId)
                                        {{ $record->barangay->barangay_name ?? 'Unknown' }}
                                        @php $currentBarangay = $barangayId; @endphp
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ ucfirst($record->species) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right font-semibold text-gray-900">{{ number_format($record->total_count) }}</td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">No census data available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
