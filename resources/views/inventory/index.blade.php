@extends('layouts.admin')

@section('title', 'Inventory Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Inventory Management</h1>
        <a href="{{ route('inventory.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Item
        </a>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('inventory.index') }}" class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search items..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-control">
                        <option value="">All Categories</option>
                        <option value="vaccine" {{ request('category') == 'vaccine' ? 'selected' : '' }}>Vaccine</option>
                        <option value="medication" {{ request('category') == 'medication' ? 'selected' : '' }}>Medication</option>
                        <option value="supplies" {{ request('category') == 'supplies' ? 'selected' : '' }}>Supplies</option>
                        <option value="equipment" {{ request('category') == 'equipment' ? 'selected' : '' }}>Equipment</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('inventory.index') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('inventory.low-stock') }}" class="btn btn-warning w-100">
                        <i class="fas fa-exclamation-triangle"></i> Low Stock
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Inventory Table -->
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Expiry Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>{{ $item->item_code ?? 'N/A' }}</td>
                        <td>{{ $item->item_name }}</td>
                        <td>{{ ucfirst($item->category) }}</td>
                        <td>
                            <span class="{{ $item->isLowStock() ? 'text-danger fw-bold' : '' }}">
                                {{ $item->quantity }}
                            </span>
                        </td>
                        <td>{{ $item->unit }}</td>
                        <td>
                            @if($item->expiry_date)
                            {{ $item->expiry_date->format('M d, Y') }}
                            @if($item->isExpired())
                            <span class="badge bg-danger">Expired</span>
                            @elseif($item->isExpiringSoon())
                            <span class="badge bg-warning">Expiring</span>
                            @endif
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                            @if($item->isLowStock())
                            <span class="badge bg-warning">Low Stock</span>
                            @else
                            <span class="badge bg-success">Good</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('inventory.show', $item->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('inventory.edit', $item->id) }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('inventory.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $items->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
