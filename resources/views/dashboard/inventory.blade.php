@extends('layouts.admin')

@section('title', 'Inventory Management Dashboard')

@section('content')
<div class="w-full">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h1 class="text-xl md:text-2xl font-bold text-gray-800">Inventory Dashboard</h1>
        <a href="{{ route('inventory.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <i class="bi bi-plus-lg"></i> Add Item
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-600 text-white rounded-xl shadow-sm p-6">
            <h5 class="text-blue-100 text-sm font-medium mb-2">Total Items</h5>
            <h2 class="text-3xl md:text-4xl font-bold">{{ $items }}</h2>
        </div>
        <div class="bg-yellow-500 text-white rounded-xl shadow-sm p-6">
            <h5 class="text-yellow-100 text-sm font-medium mb-2">Low Stock</h5>
            <h2 class="text-3xl md:text-4xl font-bold">{{ $lowStock }}</h2>
        </div>
        <div class="bg-cyan-500 text-white rounded-xl shadow-sm p-6">
            <h5 class="text-cyan-100 text-sm font-medium mb-2">Expiring Soon</h5>
            <h2 class="text-3xl md:text-4xl font-bold">{{ $expiringSoon }}</h2>
        </div>
        <div class="bg-red-500 text-white rounded-xl shadow-sm p-6">
            <h5 class="text-red-100 text-sm font-medium mb-2">Expired</h5>
            <h2 class="text-3xl md:text-4xl font-bold">{{ $expired }}</h2>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
        <div class="px-6 py-4 border-b border-gray-100">
            <h5 class="font-semibold text-gray-800">Quick Actions</h5>
        </div>
        <div class="p-6">
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('inventory.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition">
                    <i class="bi bi-list"></i> View All
                </a>
                <a href="{{ route('inventory.low-stock') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-yellow-500 text-yellow-600 rounded-lg hover:bg-yellow-50 transition">
                    <i class="bi bi-exclamation-triangle"></i> Low Stock
                </a>
                <a href="{{ route('inventory.expiring') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-cyan-500 text-cyan-600 rounded-lg hover:bg-cyan-50 transition">
                    <i class="bi bi-clock"></i> Expiring
                </a>
                <a href="{{ route('inventory.movements') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-400 text-gray-600 rounded-lg hover:bg-gray-50 transition">
                    <i class="bi bi-arrow-left-right"></i> Movements
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Items & Movements -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Items -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h5 class="font-semibold text-gray-800">Recent Items</h5>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[300px]">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Item</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qty</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recentItems as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-gray-800">{{ $item->item_name }}</p>
                                <p class="text-xs text-gray-500">{{ $item->category }}</p>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $item->quantity }} {{ $item->unit }}</td>
                            <td class="px-4 py-3">
                                @if($item->isLowStock())
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Low</span>
                                @elseif($item->isExpired())
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Expired</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Good</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Movements -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h5 class="font-semibold text-gray-800">Recent Movements</h5>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[250px]">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qty</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recentMovements as $movement)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                @if($movement->movement_type == 'stock_in')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">In</span>
                                @elseif($movement->movement_type == 'stock_out')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Out</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Adj</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $movement->quantity }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $movement->movement_date->format('M d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
