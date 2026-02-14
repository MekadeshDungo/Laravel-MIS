@extends('layouts.admin')

@section('title', 'Expiring Items')
@section('header', 'Expiring Items')
@section('subheader', 'Items expiring soon')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Expiring Items</h2>
            <p class="text-sm text-gray-500">Items expiring within 30 days</p>
        </div>
        <a href="{{ route('inventory.index') }}" class="text-gray-600 hover:text-gray-800">
            <i class="bi bi-arrow-left mr-1"></i>Back to Inventory
        </a>
    </div>

    @if($items->count() > 0)
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6">
        <div class="flex items-center gap-2 text-yellow-600">
            <i class="bi bi-clock-history text-xl"></i>
            <span class="font-medium">{{ $items->count() }} item(s) are expiring soon</span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expiry Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Days Left</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($items as $item)
                @php
                $daysLeft = now()->diffInDays($item->expiry_date, false);
                $rowClass = $daysLeft <= 7 ? 'bg-red-50' : ($daysLeft <= 14 ? 'bg-orange-50' : 'bg-yellow-50');
                @endphp
                <tr class="hover:bg-gray-50 {{ $rowClass }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                <i class="bi bi-calendar-event text-yellow-600"></i>
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
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        {{ $item->quantity }} {{ $item->unit }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $item->expiry_date->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $daysLeft <= 7 ? 'bg-red-100 text-red-800' : ($daysLeft <= 14 ? 'bg-orange-100 text-orange-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ $daysLeft }} days
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('inventory.stock-out', $item) }}" class="text-red-600 hover:text-red-700 mr-3">
                            <i class="bi bi-dash-circle"></i> Use Stock
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
        <p class="text-gray-500 text-lg">No items expiring soon</p>
        <p class="text-sm text-gray-400 mt-2">All items have more than 30 days before expiry</p>
    </div>
    @endif
</div>
@endsection
