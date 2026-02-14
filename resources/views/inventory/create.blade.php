@extends('layouts.admin')

@section('title', 'Add New Inventory Item')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add New Inventory Item</h1>
        <a href="{{ route('inventory.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('inventory.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="item_name" class="form-label">Item Name *</label>
                        <input type="text" class="form-control @error('item_name') is-invalid @endreed' id="item_name" name="item_name" required value="{{ old('item_name') }}">
                        @error('item_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="item_code" class="form-label">Item Code</label>
                        <input type="text" class="form-control @error('item_code') is-invalid @endreed' id="item_code" name="item_code" value="{{ old('item_code') }}">
                        @error('item_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">Category *</label>
                        <select class="form-control @error('category') is-invalid @endreed' id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="vaccine">Vaccine</option>
                            <option value="medication">Medication</option>
                            <option value="supplies">Supplies</option>
                            <option value="equipment">Equipment</option>
                            <option value="other">Other</option>
                        </select>
                        @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="unit" class="form-label">Unit *</label>
                        <input type="text" class="form-control @error('unit') is-invalid @endreed' id="unit" name="unit" required value="{{ old('unit') }}">
                        @error('unit')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="quantity" class="form-label">Initial Quantity *</label>
                        <input type="number" class="form-control @error('quantity') is-invalid @endreed' id="quantity" name="quantity" required min="0" value="{{ old('quantity', 0) }}">
                        @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="min_stock_level" class="form-label">Minimum Stock Level</label>
                        <input type="number" class="form-control @error('min_stock_level') is-invalid @endreed' id="min_stock_level" name="min_stock_level" min="0" value="{{ old('min_stock_level', 10) }}">
                        @error('min_stock_level')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="expiry_date" class="form-label">Expiry Date</label>
                        <input type="date" class="form-control @error('expiry_date') is-invalid @endreed' id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}">
                        @error('expiry_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="supplier" class="form-label">Supplier</label>
                        <input type="text" class="form-control @error('supplier') is-invalid @endreed' id="supplier" name="supplier" value="{{ old('supplier') }}">
                        @error('supplier')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="cost_per_unit" class="form-label">Cost Per Unit</label>
                        <input type="number" step="0.01" class="form-control @error('cost_per_unit') is-invalid @endreed' id="cost_per_unit" name="cost_per_unit" min="0" value="{{ old('cost_per_unit') }}">
                        @error('cost_per_unit')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="location" class="form-label">Storage Location</label>
                        <input type="text" class="form-control @error('location') is-invalid @endreed' id="location" name="location" value="{{ old('location') }}">
                        @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @endreed' id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
