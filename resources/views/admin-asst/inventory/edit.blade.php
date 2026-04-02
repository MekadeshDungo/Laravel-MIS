@extends('layouts.admin')

@section('title', 'Edit Inventory Item')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Inventory Item</h2>
        <a href="{{ route('admin-asst.inventory.show', $inventory) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin-asst.inventory.update', $inventory) }}">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Item Name *</label>
                        <input type="text" name="item_name" class="form-control @error('item_name') is-invalid @endif" value="{{ $inventory->item_name }}" required>
                        @error('item_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Category *</label>
                        <select name="category" class="form-select @error('category') is-invalid @endif" required>
                            <option value="vaccines" {{ $inventory->category == 'vaccines' ? 'selected' : '' }}>Vaccines</option>
                            <option value="medicines" {{ $inventory->category == 'medicines' ? 'selected' : '' }}>Medicines</option>
                            <option value="supplies" {{ $inventory->category == 'supplies' ? 'selected' : '' }}>Supplies</option>
                            <option value="equipment" {{ $inventory->category == 'equipment' ? 'selected' : '' }}>Equipment</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Quantity *</label>
                        <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @endif" value="{{ $inventory->quantity }}" min="0" required>
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Unit *</label>
                        <input type="text" name="unit" class="form-control @error('unit') is-invalid @endif" value="{{ $inventory->unit }}" required>
                        @error('unit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Minimum Stock *</label>
                        <input type="number" name="minimum_stock" class="form-control @error('minimum_stock') is-invalid @endif" value="{{ $inventory->minimum_stock }}" min="0" required>
                        @error('minimum_stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Unit Price (₱) *</label>
                        <input type="number" name="unit_price" class="form-control @error('unit_price') is-invalid @endif" value="{{ $inventory->unit_price }}" min="0" step="0.01" required>
                        @error('unit_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Barangay *</label>
                        <select name="barangay_id" class="form-select @error('barangay_id') is-invalid @endif" required>
                            @foreach($barangays as $barangay)
                                <option value="{{ $barangay->barangay_id }}" {{ $inventory->barangay_id == $barangay->barangay_id ? 'selected' : '' }}>
                                    {{ $barangay->barangay_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('barangay_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Expiry Date</label>
                        <input type="date" name="expiry_date" class="form-control" value="{{ $inventory->expiry_date }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="2">{{ $inventory->description }}</textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update Item</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection