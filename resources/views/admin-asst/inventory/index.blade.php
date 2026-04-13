@extends('layouts.admin')

@section('title', 'Inventory Control')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Inventory Control</h2>
        <div>
            <a href="{{ route('admin-asst.inventory.low-stock') }}" class="btn btn-warning">
                <i class="fas fa-exclamation-triangle"></i> Low Stock ({{ $lowStockCount }})
            </a>
            <a href="{{ route('admin-asst.inventory.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Item
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Item name..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        <option value="vaccines" {{ request('category') == 'vaccines' ? 'selected' : '' }}>Vaccines</option>
                        <option value="medicines" {{ request('category') == 'medicines' ? 'selected' : '' }}>Medicines</option>
                        <option value="supplies" {{ request('category') == 'supplies' ? 'selected' : '' }}>Supplies</option>
                        <option value="equipment" {{ request('category') == 'equipment' ? 'selected' : '' }}>Equipment</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Barangay</label>
                    <select name="barangay_id" class="form-select">
                        <option value="">All Barangays</option>
                        @foreach($barangays as $barangay)
                            <option value="{{ $barangay->barangay_id }}" {{ request('barangay_id') == $barangay->barangay_id ? 'selected' : '' }}>
                                {{ $barangay->barangay_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-secondary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Inventory Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Unit Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ ucfirst($item->category) }}</td>
                                <td>
                                    <span class="{{ $item->isLowStock() ? 'text-danger fw-bold' : '' }}">
                                        {{ $item->quantity }}
                                    </span>
                                </td>
                                <td>{{ $item->unit }}</td>
                                <td>₱{{ number_format($item->unit_price, 2) }}</td>
                                <td>
                                    @if($item->isLowStock())
                                        <span class="badge bg-danger">Low Stock</span>
                                    @else
                                        <span class="badge bg-success">OK</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin-asst.inventory.show', $item) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin-asst.inventory.edit', $item) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No items found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</div>
@endsection