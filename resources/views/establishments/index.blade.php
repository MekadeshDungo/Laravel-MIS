@extends('layouts.admin')

@section('title', 'Establishments')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Establishments</h1>
        <a href="{{ route('establishments.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Establishment
        </a>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('establishments.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="type" class="form-label">Type</label>
                    <select name="type" id="type" class="form-select">
                        <option value="">All Types</option>
                        <option value="meat_shop" {{ request('type') == 'meat_shop' ? 'selected' : '' }}>Meat Shop</option>
                        <option value="poultry" {{ request('type') == 'poultry' ? 'selected' : '' }}>Poultry</option>
                        <option value="pet_shop" {{ request('type') == 'pet_shop' ? 'selected' : '' }}>Pet Shop</option>
                        <option value="vet_clinic" {{ request('type') == 'vet_clinic' ? 'selected' : '' }}>Vet Clinic</option>
                        <option value="livestock_facility" {{ request('type') == 'livestock_facility' ? 'selected' : '' }}>Livestock Facility</option>
                        <option value="other" {{ request('type') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" name="search" id="search" class="form-control" placeholder="Establishment name" value="{{ request('search') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Establishments Table -->
    <div class="card">
        <div class="card-body">
            @if($establishments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Permit No.</th>
                                <th>Owner</th>
                                <th>Barangay</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($establishments as $establishment)
                                <tr>
                                    <td>{{ $establishment->name }}</td>
                                    <td>
                                        @switch($establishment->type)
                                            @case('meat_shop')
                                                <span class="badge bg-danger">Meat Shop</span>
                                                @break
                                            @case('poultry')
                                                <span class="badge bg-warning">Poultry</span>
                                                @break
                                            @case('pet_shop')
                                                <span class="badge bg-info">Pet Shop</span>
                                                @break
                                            @case('vet_clinic')
                                                <span class="badge bg-success">Vet Clinic</span>
                                                @break
                                            @case('livestock_facility')
                                                <span class="badge bg-secondary">Livestock Facility</span>
                                                @break
                                            @default
                                                <span class="badge bg-light text-dark">Other</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $establishment->permit_no ?? 'N/A' }}</td>
                                    <td>{{ $establishment->owner_name ?? 'N/A' }}</td>
                                    <td>{{ $establishment->barangay->barangay_name ?? 'N/A' }}</td>
                                    <td>
                                        @switch($establishment->status)
                                            @case('active')
                                                <span class="badge bg-success">Active</span>
                                                @break
                                            @case('inactive')
                                                <span class="badge bg-secondary">Inactive</span>
                                                @break
                                            @case('suspended')
                                                <span class="badge bg-danger">Suspended</span>
                                                @break
                                            @case('pending')
                                                <span class="badge bg-warning">Pending</span>
                                                @break
                                            @default
                                                <span class="badge bg-light text-dark">{{ $establishment->status }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('establishments.show', $establishment) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('establishments.edit', $establishment) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('establishments.destroy', $establishment) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this establishment?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $establishments->links() }}
            @else
                <div class="text-center py-4">
                    <i class="fas fa-building fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No establishments found.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
