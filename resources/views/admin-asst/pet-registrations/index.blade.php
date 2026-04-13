@extends('layouts.admin')

@section('title', 'Pet Registrations')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-paw me-2"></i>Pet Registrations</h2>
        <div>
            <a href="{{ route('admin-asst.pet-registrations.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Registration
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary bg-opacity-10">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-list fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted">Total Pets</h6>
                            <h3 class="mb-0">{{ $totalCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-success bg-opacity-10">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted">Registered</h6>
                            <h3 class="mb-0">{{ $registeredCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-warning bg-opacity-10">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-clock fa-2x text-warning"></i>
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
                    <input type="text" name="search" class="form-control" placeholder="Pet name or owner..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="registered" {{ request('status') == 'registered' ? 'selected' : '' }}>Registered</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Species</label>
                    <select name="species" class="form-select">
                        <option value="">All Species</option>
                        <option value="dog" {{ request('species') == 'dog' ? 'selected' : '' }}>Dog</option>
                        <option value="cat" {{ request('species') == 'cat' ? 'selected' : '' }}>Cat</option>
                        <option value="bird" {{ request('species') == 'bird' ? 'selected' : '' }}>Bird</option>
                        <option value="other" {{ request('species') == 'other' ? 'selected' : '' }}>Other</option>
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
                    <a href="{{ route('admin-asst.pet-registrations.index') }}" class="btn btn-outline-secondary">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Pet List -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Pet Name</th>
                            <th>Species</th>
                            <th>Breed</th>
                            <th>Owner</th>
                            <th>License #</th>
                            <th>Status</th>
                            <th>Registered</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pets as $pet)
                        <tr>
                            <td>
                                <strong>{{ $pet->name }}</strong>
                                @if($pet->gender)
                                    <span class="badge bg-secondary ms-1">{{ ucfirst($pet->gender[0]) }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ ucfirst($pet->species) }}</span>
                            </td>
                            <td>{{ $pet->breed }}</td>
                            <td>{{ $pet->userOwner ? $pet->userOwner->name : 'N/A' }}</td>
                            <td>
                                @if($pet->license_number)
                                    <code>{{ $pet->license_number }}</code>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($pet->license_number)
                                    <span class="badge bg-success">Registered</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                            <td>{{ $pet->created_at->format('M d, Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin-asst.pet-registrations.show', $pet) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin-asst.pet-registrations.edit', $pet) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if(!$pet->license_number)
                                    <form action="{{ route('admin-asst.pet-registrations.approve', $pet) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Approve and issue license for this pet?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin-asst.pet-registrations.destroy', $pet) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this record?')">
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
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p class="mb-0">No pet registrations found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $pets->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
