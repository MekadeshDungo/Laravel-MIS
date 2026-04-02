@extends('layouts.admin')

@section('title', 'Impounded Animals')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-shelter me-2"></i>Impounded Animals</h2>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
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
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-warning bg-opacity-10">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted">Impounded</h6>
                            <h3 class="mb-0">{{ $impoundedCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-success bg-opacity-10">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-user-check fa-2x text-success"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted">Claimed</h6>
                            <h3 class="mb-0">{{ $claimedCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-info bg-opacity-10">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-heart fa-2x text-info"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted">Adopted</h6>
                            <h3 class="mb-0">{{ $adoptedCount }}</h3>
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
                    <input type="text" name="search" class="form-control" placeholder="Tag code or location..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Disposition</label>
                    <select name="disposition" class="form-select">
                        <option value="">All Status</option>
                        <option value="impounded" {{ request('disposition') == 'impounded' ? 'selected' : '' }}>Impounded</option>
                        <option value="claimed" {{ request('disposition') == 'claimed' ? 'selected' : '' }}>Claimed</option>
                        <option value="adopted" {{ request('disposition') == 'adopted' ? 'selected' : '' }}>Adopted</option>
                        <option value="transferred" {{ request('disposition') == 'transferred' ? 'selected' : '' }}>Transferred</option>
                        <option value="euthanized" {{ request('disposition') == 'euthanized' ? 'selected' : '' }}>Euthanized</option>
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
                    <a href="{{ route('admin-asst.impounds.index') }}" class="btn btn-outline-secondary">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Impounds List -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tag Code</th>
                            <th>Intake Condition</th>
                            <th>Intake Location</th>
                            <th>Intake Date</th>
                            <th>Disposition</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($impounds as $impound)
                        <tr>
                            <td><strong>#{{ $impound->impound_id }}</strong></td>
                            <td>{{ $impound->animal_tag_code ?? 'Not assigned' }}</td>
                            <td>{{ ucfirst($impound->intake_condition ?? 'Unknown') }}</td>
                            <td>{{ Str::limit($impound->intake_location ?? 'N/A', 30) }}</td>
                            <td>{{ $impound->intake_date ? $impound->intake_date->format('M d, Y') : 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $impound->current_disposition == 'impounded' ? 'warning' : ($impound->current_disposition == 'adopted' ? 'success' : ($impound->current_disposition == 'claimed' ? 'info' : ($impound->current_disposition == 'euthanized' ? 'danger' : 'secondary'))) }}">
                                    {{ ucfirst($impound->current_disposition) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin-asst.impounds.show', $impound) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p class="mb-0">No impound records found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $impounds->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
