@extends('layouts.admin')

@section('title', 'Adoption Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-heart me-2"></i>Adoption Management</h2>
        <a href="{{ route('admin-asst.adoptions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Adoption Request
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-2">
            <div class="card border-0 shadow-sm bg-primary bg-opacity-10">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-list fa-2x text-primary"></i>
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
        <div class="col-md-2">
            <div class="card border-0 shadow-sm bg-success bg-opacity-10">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted">Approved</h6>
                            <h3 class="mb-0">{{ $approvedCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm bg-danger bg-opacity-10">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-times-circle fa-2x text-danger"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted">Rejected</h6>
                            <h3 class="mb-0">{{ $rejectedCount }}</h3>
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
                            <i class="fas fa-check-double fa-2x text-info"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted">Completed</h6>
                            <h3 class="mb-0">{{ $completedCount }}</h3>
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
                            <i class="fas fa-paw fa-2x text-secondary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted">Available</h6>
                            <h3 class="mb-0">Impounds</h3>
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
                <div class="col-md-4">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Adopter name or contact..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
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
                    <a href="{{ route('admin-asst.adoptions.index') }}" class="btn btn-outline-secondary">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Adoption List -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Adopter</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Request Date</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($adoptions as $adoption)
                        <tr>
                            <td>
                                <strong>#{{ $adoption->adoption_request_id }}</strong>
                            </td>
                            <td>{{ $adoption->adopter_name }}</td>
                            <td>{{ $adoption->adopter_contact }}</td>
                            <td>{{ Str::limit($adoption->address, 30) }}</td>
                            <td>{{ $adoption->requested_at ? $adoption->requested_at->format('M d, Y') : 'N/A' }}</td>
                            <td>
                                @if($adoption->request_status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($adoption->request_status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($adoption->request_status == 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @elseif($adoption->request_status == 'completed')
                                    <span class="badge bg-info">Completed</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($adoption->request_status) }}</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin-asst.adoptions.show', $adoption) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($adoption->request_status == 'pending')
                                    <form action="{{ route('admin-asst.adoptions.approve', $adoption) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="notes" value="Approved by Admin Assistant">
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Approve this adoption request?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin-asst.adoptions.reject', $adoption) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="notes" value="Rejected by Admin Assistant">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Reject this adoption request?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-heart fa-3x mb-3"></i>
                                <p class="mb-0">No adoption requests found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $adoptions->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
