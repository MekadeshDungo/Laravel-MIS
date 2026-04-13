@extends('layouts.admin')

@section('title', 'Stock Movements')
@section('header', 'Stock Movements')
@section('subheader', 'Inventory Movement Log')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Stock Movements</h2>
            <p class="text-sm text-gray-500">View all inventory movements</p>
        </div>
        <a href="{{ route('inventory.index') }}" class="text-gray-600 hover:text-gray-800">
            <i class="bi bi-arrow-left mr-1"></i>Back to Inventory
        </a>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">Filter by Item</label>
                <select name="item_id" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Items</option>
                    @foreach($items as $id => $name)
                        <option value="{{ $id }}" {{ request('item_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-40">
                <label class="block text-sm font-medium text-gray-700 mb-1">Movement Type</label>
                <select name="movement_type" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Types</option>
                    <option value="stock_in" {{ request('movement_type') == 'stock_in' ? 'selected' : '' }}>Stock In</option>
                    <option value="stock_out" {{ request('movement_type') == 'stock_out' ? 'selected' : '' }}>Stock Out</option>
                    <option value="adjustment" {{ request('movement_type') == 'adjustment' ? 'selected' : '' }}>Adjustment</option>
                </select>
            </div>
            <div class="w-40">
                <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" 
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="w-40">
                <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" 
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>

    <!-- Movements Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($movements as $movement)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $movement->movement_date->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <p class="text-sm text-gray-800 font-medium">{{ $movement->item->item_name }}</p>
                        <p class="text-xs text-gray-500">{{ $movement->item->item_code ?? 'N/A' }}</p>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $movement->movement_type === 'stock_in' ? 'bg-green-100 text-green-800' : 
                               ($movement->movement_type === 'stock_out' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst(str_replace('_', ' ', $movement->movement_type)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $movement->movement_type === 'stock_in' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $movement->movement_type === 'stock_in' ? '+' : '-' }}{{ $movement->quantity }}
                        <span class="text-gray-400 font-normal">({{ $movement->previous_quantity }} → {{ $movement->new_quantity }})</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $movement->reference_number ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $movement->remarks ?? 'N/A' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <i class="bi bi-inbox text-4xl mb-2"></i>
                        <p>No stock movements found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $movements->appends(request()->query())->links() }}
    </div>
</div>
@endsection
