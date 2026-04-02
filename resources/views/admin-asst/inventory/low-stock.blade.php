@extends('layouts.admin')

@section('title', 'Low Stock Items')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Low Stock Items</h2>
        <a href="{{ route('admin-asst.inventory.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Inventory
        </a>
    </div>

    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i> 
        <strong>{{ count($items) }} items</strong> are below minimum stock level and need restocking.
    </div>

    <div class="card">
        <div class="card-body">
            @if(count($items) > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Current Qty</th>
                                <th>Min Stock</th>
                                <th>Unit</th>
                                <th>Needed</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->item_name }}</td>
                                    <td>{{ ucfirst($item->category) }}</td>
                                    <td class="text-danger fw-bold">{{ $item->quantity }}</td>
                                    <td>{{ $item->minimum_stock }}</td>
                                    <td>{{ $item->unit }}</td>
                                    <td class="text-danger">{{ $item->minimum_stock - $item->quantity }}</td>
                                    <td>
                                        <a href="{{ route('admin-asst.inventory.edit', $item) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-plus"></i> Restock
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                    <h4>All items are well stocked!</h4>
                    <p class="text-muted">No items are below minimum stock level.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection