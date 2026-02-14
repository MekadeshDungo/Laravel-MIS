@extends('layouts.admin')

@section('title', 'Stock Adjustment - ' . $item->item_name)
@section('header', 'Stock Adjustment')
@section('subheader', $item->item_name)

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('inventory.show', $item) }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Item</span>
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">Stock Adjustment - {{ $item->item_name }}</h3>
            <p class="text-sm text-gray-500">Current Stock: {{ $item->quantity }} {{ $item->unit }}</p>
        </div>

        <form action="{{ route('inventory.adjustment.process', $item) }}" method="POST" class="p-6">
            @csrf

            <div class="mb-6">
                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">New Quantity <span class="text-red-500">*</span></label>
                <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $item->quantity) }}" min="0" 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition @error('quantity') border-red-500 @enderror"
                    required>
                @error('quantity')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="reference_number" class="block text-sm font-medium text-gray-700 mb-2">Reference Number</label>
                <input type="text" name="reference_number" id="reference_number" value="{{ old('reference_number') }}" 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                    placeholder="e.g., ADJ-2024-001">
            </div>

            <div class="mb-6">
                <label for="remarks" class="block text-sm font-medium text-gray-700 mb-2">Reason for Adjustment <span class="text-red-500">*</span></label>
                <textarea name="remarks" id="remarks" rows="3" 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition @error('remarks') border-red-500 @enderror"
                    placeholder="Explain why the adjustment is needed" required>{{ old('remarks') }}</textarea>
                @error('remarks')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @endif
            </div>

            <div class="mb-6">
                <label for="movement_date" class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                <input type="date" name="movement_date" id="movement_date" value="{{ old('movement_date', date('Y-m-d')) }}" 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition">
            </div>

            <!-- Adjustment Summary -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-yellow-600">Adjustment Summary</p>
                <p class="text-lg font-bold text-yellow-700">
                    {{ $item->quantity }} → <span id="preview-quantity">{{ $item->quantity }}</span> {{ $item->unit }}
                    <span class="text-sm font-normal ml-2" id="adjustment-diff"></span>
                </p>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                <a href="{{ route('inventory.show', $item) }}" class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-lg transition shadow-sm">
                    <i class="bi bi-arrow-repeat mr-2"></i>Adjust Stock
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('quantity').addEventListener('input', function() {
    const newQty = parseInt(this.value) || 0;
    const currentStock = {{ $item->quantity }};
    document.getElementById('preview-quantity').textContent = newQty;
    
    const diff = newQty - currentStock;
    const diffEl = document.getElementById('adjustment-diff');
    if (diff > 0) {
        diffEl.textContent = '(+' + diff + ')';
        diffEl.className = 'text-green-600 text-sm font-normal ml-2';
    } else if (diff < 0) {
        diffEl.textContent = '(' + diff + ')';
        diffEl.className = 'text-red-600 text-sm font-normal ml-2';
    } else {
        diffEl.textContent = '(no change)';
        diffEl.className = 'text-gray-500 text-sm font-normal ml-2';
    }
});
</script>
@endsection
