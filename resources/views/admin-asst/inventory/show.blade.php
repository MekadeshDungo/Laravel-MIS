@extends('layouts.admin')

@section('title', 'Inventory Item Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Item Details</h2>
        <div>
            <a href="{{ route('admin-asst.inventory.edit', $inventory) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin-asst.inventory.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Item Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Item Name</label>
                            <p class="mb-0 fw-bold">{{ $inventory->item_name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Category</label>
                            <p class="mb-0">{{ ucfirst($inventory->category) }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="text-muted">Quantity</label>
                            <p class="mb-0 {{ $inventory->isLowStock() ? 'text-danger fw-bold' : '' }}">
                                {{ $inventory->quantity }} {{ $inventory->unit }}
                            </p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted">Minimum Stock</label>
                            <p class="mb-0">{{ $inventory->minimum_stock }} {{ $inventory->unit }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted">Unit Price</label>
                            <p class="mb-0">₱{{ number_format($inventory->unit_price, 2) }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted">Total Value</label>
                            <p class="mb-0">₱{{ number_format($inventory->quantity * $inventory->unit_price, 2) }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Barangay</label>
                            <p class="mb-0">{{ $inventory->barangay->barangay_name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Expiry Date</label>
                            <p class="mb-0">{{ $inventory->expiry_date ? \Carbon\Carbon::parse($inventory->expiry_date)->format('M d, Y') : 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Description</label>
                        <p class="mb-0">{{ $inventory->description ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Stock Status</h5>
                </div>
                <div class="card-body text-center">
                    @if($inventory->isLowStock())
                        <div class="text-danger mb-2">
                            <i class="fas fa-exclamation-triangle fa-3x"></i>
                        </div>
                        <h4 class="text-danger">LOW STOCK</h4>
                        <p class="text-muted">Item needs restocking</p>
                    @else
                        <div class="text-success mb-2">
                            <i class="fas fa-check-circle fa-3x"></i>
                        </div>
                        <h4 class="text-success">IN STOCK</h4>
                        <p class="text-muted">Stock level is adequate</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Item Info</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1"><small class="text-muted">Status: {{ $inventory->status }}</small></p>
                    <p class="mb-1"><small class="text-muted">Created: {{ $inventory->created_at->format('M d, Y H:i') }}</small></p>
                    <p class="mb-0"><small class="text-muted">Updated: {{ $inventory->updated_at->format('M d, Y H:i') }}</small></p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin-asst.inventory.destroy', $inventory) }}" onsubmit="return confirm('Are you sure you want to delete this item?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash"></i> Delete Item
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection