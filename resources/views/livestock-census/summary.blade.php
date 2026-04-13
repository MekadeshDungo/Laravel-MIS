@extends('layouts.admin')

@section('title', 'Livestock Census Summary')
@section('header', 'Livestock Census Summary')
@section('subheader', 'Year: ' . $year)

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Livestock Census Summary</h2>
            <p class="text-sm text-gray-500">{{ $month ? \Carbon\Carbon::create($year, $month)->format('F Y') : 'Year ' . $year }}</p>
        </div>
        <a href="{{ route('livestock-census.index') }}" class="text-gray-600 hover:text-gray-800">
            <i class="bi bi-arrow-left mr-1"></i>Back to Census
        </a>
    </div>

    <!-- Year/Month Filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="w-40">
                <label class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                <select name="year" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    @for($y = date('Y'); $y >= date('Y') - 10; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="w-40">
                <label class="block text-sm font-medium text-gray-700 mb-1">Month</label>
                <select name="month" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">All Months</option>
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create(null, $m)->format('F') }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg transition">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <p class="text-sm font-medium text-gray-500">Total Heads</p>
            <p class="text-3xl font-bold text-emerald-600 mt-1">{{ number_format($totalHeads) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <p class="text-sm font-medium text-gray-500">Total Farmers</p>
            <p class="text-3xl font-bold text-blue-600 mt-1">{{ number_format($totalFarmers) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <p class="text-sm font-medium text-gray-500">Species Count</p>
            <p class="text-3xl font-bold text-purple-600 mt-1">{{ $summary->count() }}</p>
        </div>
    </div>

    <!-- Summary Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Breakdown by Species</h3>
        </div>
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Species</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Heads</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Farmers</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Percentage</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($summary as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center mr-3">
                                <i class="bi bi-award text-emerald-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ ucfirst($item->species) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-lg font-semibold text-gray-800">
                        {{ number_format($item->total_heads) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ number_format($item->total_farmers) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            <div class="flex-1 bg-gray-200 rounded-full h-2 w-24">
                                <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $totalHeads > 0 ? ($item->total_heads / $totalHeads * 100) : 0 }}%"></div>
                            </div>
                            <span class="text-sm text-gray-600">{{ $totalHeads > 0 ? round($item->total_heads / $totalHeads * 100, 1) : 0 }}%</span>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                        <i class="bi bi-inbox text-4xl mb-2"></i>
                        <p>No livestock census data for this period</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tfoot class="bg-gray-50">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800">Total</td>
                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800">{{ number_format($totalHeads) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800">{{ number_format($totalFarmers) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800">100%</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Export Options -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Export Options</h3>
        <div class="flex gap-4">
            <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition" onclick="window.print()">
                <i class="bi bi-file-pdf mr-2"></i>Print / Save PDF
            </button>
            <button class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                <i class="bi bi-file-excel mr-2"></i>Export to Excel
            </button>
        </div>
    </div>
</div>
