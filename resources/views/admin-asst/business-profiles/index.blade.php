@extends('layouts.admin')

@section('title', 'Business Profiles - Poultry & Livestock')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-building me-2"></i>Business Profiles (Poultry & Livestock)</h2>
        <div>
            <a href="{{ route('admin-asst.business-profiles.export') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-download me-2"></i>Export CSV
            </a>
            <a href="{{ route('admin-asst.business-profiles.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Profile
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-2">
            <div class="card border-0 shadow-sm bg-primary bg-opacity-10">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-building fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted">Total</h6>
                            <h3 class="mb-0">{{ $totalCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm bg-warning bg-opacity-10">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-egg fa-2x text-warning"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted">Poultry</h6>
                            <h3 class="mb-0">{{ $poultryCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm bg-success bg-opacity-10">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-cow fa-2x text-success"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted">Livestock</h6>
                            <h3 class="mb-0">{{ $livestockCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm bg-info bg-opacity-10">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-check-circle fa-2x text-info"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted">Active</h6>
                            <h3 class="mb-0">{{ $activeCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm bg-secondary bg-opacity-10">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-clock fa-2x text-secondary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted">Pending</h6>
                            <h3 class="mb-0">{{ $pendingCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Name, owner, or permit..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        <option value="poultry" {{ request('type') == 'poultry' ? 'selected' : '' }}>Poultry</option>
                        <option value="livestock_facility" {{ request('type') == 'livestock_facility' ? 'selected' : '' }}>Livestock Facility</option>
                        <option value="meat_shop" {{ request('type') == 'meat_shop' ? 'selected' : '' }}>Meat Shop</option>
                        <option value="pet_shop" {{ request('type') == 'pet_shop' ? 'selected' : '' }}>Pet Shop</option>
                        <option value="vet_clinic" {{ request('type') == 'vet_clinic' ? 'selected' : '' }}>Vet Clinic</option>
                        <option value="other" {{ request('type') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
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
                    <button type="submit" class="btn btn-secondary w-100 me-2">Filter</button>
                    <a href="{{ route('admin-asst.business-profiles.index') }}" class="btn btn-outline-secondary">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Business Profiles List -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Permit #</th>
                            <th>Business Name</th>
                            <th>Type</th>
                            <th>Owner</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Registered</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($establishments as $establishment)
                        <tr>
                            <td><code>{{ $establishment->permit_no ?? 'N/A' }}</code></td>
                            <td><strong>{{ $establishment->name }}</strong></td>
                            <td>
                                @if($establishment->type == 'poultry')
                                    <span class="badge bg-warning"><i class="fas fa-egg me-1"></i>Poultry</span>
                                @elseif($establishment->type == 'livestock_facility')
                                    <span class="badge bg-success"><i class="fas fa-cow me-1"></i>Livestock</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $establishment->type)) }}</span>
                                @endif
                            </td>
                            <td>{{ $establishment->owner_name }}</td>
                            <td>{{ $establishment->barangay ? $establishment->barangay->barangay_name : 'N/A' }}</td>
                            <td>
                                @if($establishment->status == 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif($establishment->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($establishment->status == 'inactive')
                                    <span class="badge bg-secondary">Inactive</span>
                                @elseif($establishment->status == 'suspended')
                                    <span class="badge bg-danger">Suspended</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($establishment->status) }}</span>
                                @endif
                            </td>
                            <td>{{ $establishment->created_at->format('M d, Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin-asst.business-profiles.show', $establishment) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin-asst.business-profiles.edit', $establishment) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($establishment->status == 'pending')
                                    <form action="{{ route('admin-asst.business-profiles.approve', $establishment) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Approve this business profile?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                                @if($establishment->status == 'active')
                                    <form action="{{ route('admin-asst.business-profiles.suspend', $establishment) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Suspend this business profile?')">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin-asst.business-profiles.destroy', $establishment) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this profile?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-building fa-3x mb-3"></i>
                                <p class="mb-0">No business profiles found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $establishments->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
