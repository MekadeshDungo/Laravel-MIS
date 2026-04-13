@extends('layouts.admin')

@section('title', 'Stock In - ' . $item->item_name)
@section('header', 'Stock In')
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
            <h3 class="text-lg font-semibold text-gray-800">Stock In - {{ $item->item_name }}</h3>
            <p class="text-sm text-gray-500">Current Stock: {{ $item->quantity }} {{ $item->unit }}</p>
        </div>

        <form action="{{ route('inventory.stock-in.process', $item) }}" method="POST" class="p-6">
            @csrf

            <div class="mb-6">
                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity <span class="text-red-500">*</span></label>
                <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" min="1" 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('quantity') border-red-500 @enderror"
                    required>
                @error('quantity')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="reference_number" class="block text-sm font-medium text-gray-700 mb-2">Reference Number</label>
                <input type="text" name="reference_number" id="reference_number" value="{{ old('reference_number') }}" 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                    placeholder="e.g., PO-2024-001">
            </div>

            <div class="mb-6">
                <label for="remarks" class="block text-sm font-medium text-gray-700 mb-2">Remarks</label>
                <textarea name="remarks" id="remarks" rows="3" 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                    placeholder="Additional notes">{{ old('remarks') }}</textarea>
            </div>

            <div class="mb-6">
                <label for="movement_date" class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                <input type="date" name="movement_date" id="movement_date" value="{{ old('movement_date', date('Y-m-d')) }}" 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
            </div>

            <!-- New Stock Preview -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-green-600">New Stock Level</p>
                <p class="text-2xl font-bold text-green-700">{{ $item->quantity }} + <span id="preview-quantity">0</span> = <span id="preview-total">{{ $item->quantity }}</span> {{ $item->unit }}</p>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                <a href="{{ route('inventory.show', $item) }}" class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition shadow-sm">
                    <i class="bi bi-plus-circle mr-2"></i>Add Stock
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('quantity').addEventListener('input', function() {
    const quantity = parseInt(this.value) || 0;
    const currentStock = {{ $item->quantity }};
    document.getElementById('preview-quantity').textContent = quantity;
    document.getElementById('preview-total').textContent = currentStock + quantity;
});
</script>
@endsection
