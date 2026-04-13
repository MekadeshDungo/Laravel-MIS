@extends('layouts.admin')

@section('title', 'Add Inventory Item')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Add Inventory Item</h2>
        <a href="{{ route('admin-asst.inventory.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin-asst.inventory.store') }}">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Item Name *</label>
                        <input type="text" name="item_name" class="form-control @error('item_name') is-invalid @endif" value="{{ old('item_name') }}" required>
                        @error('item_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Category *</label>
                        <select name="category" class="form-select @error('category') is-invalid @endif" required>
                            <option value="">Select Category</option>
                            <option value="vaccines">Vaccines</option>
                            <option value="medicines">Medicines</option>
                            <option value="supplies">Supplies</option>
                            <option value="equipment">Equipment</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Quantity *</label>
                        <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @endif" value="{{ old('quantity') }}" min="0" required>
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Unit *</label>
                        <input type="text" name="unit" class="form-control @error('unit') is-invalid @endif" value="{{ old('unit') }}" placeholder="e.g., pcs, bottles, boxes" required>
                        @error('unit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Minimum Stock *</label>
                        <input type="number" name="minimum_stock" class="form-control @error('minimum_stock') is-invalid @endif" value="{{ old('minimum_stock') }}" min="0" required>
                        @error('minimum_stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Unit Price (₱) *</label>
                        <input type="number" name="unit_price" class="form-control @error('unit_price') is-invalid @endif" value="{{ old('unit_price') }}" min="0" step="0.01" required>
                        @error('unit_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Barangay *</label>
                        <select name="barangay_id" class="form-select @error('barangay_id') is-invalid @endif" required>
                            <option value="">Select Barangay</option>
                            @foreach($barangays as $barangay)
                                <option value="{{ $barangay->barangay_id }}">{{ $barangay->barangay_name }}</option>
                            @endforeach
                        </select>
                        @error('barangay_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Expiry Date</label>
                        <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Save Item</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection