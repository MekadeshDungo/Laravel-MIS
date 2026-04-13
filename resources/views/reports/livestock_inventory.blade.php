@extends('layouts.admin')

@section('title', 'Livestock Inventory')

@section('header', 'Livestock Inventory')
@section('subheader', 'Provincial livestock census data')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-8">
    @php
        $livestock = [
            'cattle' => ['name' => 'Cattle', 'icon' => 'bi-cow', 'color' => 'brown'],
            'carabao' => ['name' => 'Carabao', 'icon' => 'bi-circle-square', 'color' => 'gray'],
            'swine' => ['name' => 'Swine', 'icon' => 'bi-basket', 'color' => 'pink'],
            'horse' => ['name' => 'Horse', 'icon' => 'bi-gem', 'color' => 'yellow'],
            'goat' => ['name' => 'Goat', 'icon' => 'bi-triangle', 'color' => 'green'],
            'dog' => ['name' => 'Dog', 'icon' => 'bi-hearts', 'color' => 'blue'],
            'pigeon' => ['name' => 'Pigeon', 'icon' => 'bi-send', 'color' => 'purple'],
        ];
    @endphp
    
    @foreach($livestock as $key => $item)
        @php
            $count = \App\Models\LivestockCensus::sum($key) ?? 0;
            $colors = [
                'brown' => 'bg-amber-100 text-amber-600',
                'gray' => 'bg-gray-100 text-gray-600',
                'pink' => 'bg-pink-100 text-pink-600',
                'yellow' => 'bg-yellow-100 text-yellow-600',
                'green' => 'bg-green-100 text-green-600',
                'blue' => 'bg-blue-100 text-blue-600',
                'purple' => 'bg-purple-100 text-purple-600',
            ];
        @endphp
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-2xl {{ $colors[$item['color']] }}"><i class="bi {{ $item['icon'] }}"></i></span>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($count) }}</p>
            <p class="text-xs text-gray-500">{{ $item['name'] }}</p>
        </div>
    @endforeach
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Quick Actions</h3>
        <a href="{{ route('livestock-census.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2">
            <i class="bi bi-plus-lg"></i> Add Record
        </a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('livestock-census.index') }}" class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-list text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">All Records</span>
        </a>

        <a href="#" class="flex flex-col items-center p-4 bg-green-50 hover:bg-green-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-file-earmark-bar-graph text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Summary Report</span>
        </a>

        <a href="#" class="flex flex-col items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-download text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Export Data</span>
        </a>

        <a href="#" class="flex flex-col items-center p-4 bg-orange-50 hover:bg-orange-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-orange-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-printer text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Print Report</span>
        </a>
    </div>
</div>

<!-- Data Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800">Recent Census Records</h3>
        <a href="{{ route('livestock-census.index') }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1">
            View All <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barangay</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cattle</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Swine</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Goat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse(\App\Models\LivestockCensus::latest()->take(5)->get() as $census)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-800">{{ $census->barangay->barangay_name ?? 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $census->period_year }}-{{ $census->period_quarter }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ number_format($census->cattle) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ number_format($census->swine) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ number_format($census->goat) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                            {{ number_format($census->cattle + $census->swine + $census->goat + $census->carabao + $census->horse + $census->dog + $census->pigeon) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <i class="bi bi-inbox text-4xl mb-2 block"></i>
                            No livestock census records yet
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
