@extends('layouts.admin')

@section('title', 'Low Stock Alerts')
@section('header', 'Low Stock Alerts')
@section('subheader', 'Items below minimum stock level')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Low Stock Alerts</h2>
            <p class="text-sm text-gray-500">Items that need restocking</p>
        </div>
        <a href="{{ route('inventory.index') }}" class="text-gray-600 hover:text-gray-800">
            <i class="bi bi-arrow-left mr-1"></i>Back to Inventory
        </a>
    </div>

    @if($items->count() > 0)
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
        <div class="flex items-center gap-2 text-red-600">
            <i class="bi bi-exclamation-triangle text-xl"></i>
            <span class="font-medium">{{ $items->count() }} item(s) are below minimum stock level</span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Min Level</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supplier</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($items as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                <i class="bi bi-box-seam text-red-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $item->item_name }}</p>
                                <p class="text-sm text-gray-500">{{ $item->item_code ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $item->category }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-lg font-bold text-red-600">{{ $item->quantity }} {{ $item->unit }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $item->min_stock_level ?? 'N/A' }} {{ $item->unit }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $item->supplier ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('inventory.stock-in', $item) }}" class="text-green-600 hover:text-green-700 mr-3">
                            <i class="bi bi-plus-circle"></i> Stock In
                        </a>
                        <a href="{{ route('inventory.show', $item) }}" class="text-blue-600 hover:text-blue-700">
                            <i class="bi bi-eye"></i> View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
        <i class="bi bi-check-circle text-4xl text-green-500 mb-4"></i>
        <p class="text-gray-500 text-lg">No low stock alerts</p>
        <p class="text-sm text-gray-400 mt-2">All items are above minimum stock levels</p>
    </div>
    @endif
</div>
@endsection
