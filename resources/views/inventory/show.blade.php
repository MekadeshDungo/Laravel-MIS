@extends('layouts.admin')

@section('title', $item->item_name)
@section('header', $item->item_name)
@section('subheader', 'Inventory Details')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('inventory.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Inventory</span>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Item Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-800">{{ $item->item_name }}</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div>
                            <p class="text-sm text-gray-500">Item Code</p>
                            <p class="font-medium">{{ $item->item_code ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Category</p>
                            <p class="font-medium">{{ $item->category }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Quantity</p>
                            <p class="font-medium text-lg">{{ $item->quantity }} {{ $item->unit }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Min Stock Level</p>
                            <p class="font-medium">{{ $item->min_stock_level ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Expiry Date</p>
                            <p class="font-medium">{{ $item->expiry_date ? $item->expiry_date->format('M d, Y') : 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Supplier</p>
                            <p class="font-medium">{{ $item->supplier ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Cost per Unit</p>
                            <p class="font-medium">{{ $item->cost_per_unit ? '₱' . number_format($item->cost_per_unit, 2) : 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Location</p>
                            <p class="font-medium">{{ $item->location ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    @if($item->description)
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <p class="text-sm text-gray-500">Description</p>
                        <p class="mt-1 text-gray-700">{{ $item->description }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Quick Actions</h3>
                </div>
                <div class="p-4 space-y-2">
                    <a href="{{ route('inventory.stock-in', $item) }}" class="block w-full px-4 py-2 text-center bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                        <i class="bi bi-plus-circle mr-2"></i>Stock In
                    </a>
                    <a href="{{ route('inventory.stock-out', $item) }}" class="block w-full px-4 py-2 text-center bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                        <i class="bi bi-dash-circle mr-2"></i>Stock Out
                    </a>
                    <a href="{{ route('inventory.adjustment', $item) }}" class="block w-full px-4 py-2 text-center bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition">
                        <i class="bi bi-arrow-repeat mr-2"></i>Adjustment
                    </a>
                    <a href="{{ route('inventory.edit', $item) }}" class="block w-full px-4 py-2 text-center bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                        <i class="bi bi-pencil mr-2"></i>Edit Item
                    </a>
                </div>
            </div>

            <!-- Stock Alert -->
            @if($item->quantity <= $item->min_stock_level)
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                <div class="flex items-center gap-2 text-red-600">
                    <i class="bi bi-exclamation-triangle text-xl"></i>
                    <span class="font-medium">Low Stock Alert</span>
                </div>
                <p class="text-sm text-red-500 mt-1">Current stock is below minimum level.</p>
            </div>
            @endif

            <!-- Expiry Alert -->
            @if($item->expiry_date && $item->expiry_date->diffInDays(now()) <= 30)
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                <div class="flex items-center gap-2 text-yellow-600">
                    <i class="bi bi-clock-history text-xl"></i>
                    <span class="font-medium">Expiring Soon</span>
                </div>
                <p class="text-sm text-yellow-500 mt-1">Expires on {{ $item->expiry_date->format('M d, Y') }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Stock Movements -->
    <div class="mt-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Stock Movements</h3>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
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
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $movement->movement_type === 'stock_in' ? 'bg-green-100 text-green-800' : 
                                   ($movement->movement_type === 'stock_out' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst(str_replace('_', ' ', $movement->movement_type)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $movement->movement_type === 'stock_in' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $movement->movement_type === 'stock_in' ? '+' : '-' }}{{ $movement->quantity }}
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
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <i class="bi bi-inbox text-4xl mb-2"></i>
                            <p>No stock movements recorded</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $movements->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
