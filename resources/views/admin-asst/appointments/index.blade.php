@extends('layouts.admin')

@section('title', 'Service Requests / Appointments')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-calendar-check me-2"></i>Service Requests / Appointments</h2>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
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
        <div class="col-md-3">
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
        <div class="col-md-3">
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
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-info bg-opacity-10">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-calendar-day fa-2x text-info"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted">Today</h6>
                            <h3 class="mb-0">{{ $todayCount }}</h3>
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
                    <input type="text" name="search" class="form-control" placeholder="Citizen name or contact..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
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
                    <label class="form-label">Form Type</label>
                    <select name="form_type" class="form-select">
                        <option value="">All Types</option>
                        @foreach($serviceForms as $form)
                            <option value="{{ $form->form_type }}" {{ request('form_type') == $form->form_type ? 'selected' : '' }}>
                                {{ $form->title }} ({{ ucfirst(str_replace('_', ' ', $form->form_type)) }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Date From</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Date To</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
            </form>
        </div>
    </div>

    <!-- Submissions List -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Citizen</th>
                            <th>Contact</th>
                            <th>Service Type</th>
                            <th>Submitted</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($submissions as $submission)
                        <tr>
                            <td>
                                <strong>#{{ $submission->id }}</strong>
                            </td>
                            <td>{{ $submission->citizen_name }}</td>
                            <td>{{ $submission->citizen_contact ?? 'N/A' }}</td>
                            <td>
                                @if($submission->form)
                                    <span class="badge bg-secondary">{{ $submission->form->title }}</span>
                                @else
                                    <span class="badge bg-light text-dark">N/A</span>
                                @endif
                            </td>
                            <td>
                                {{ $submission->submitted_at ? $submission->submitted_at->format('M d, Y h:i A') : 'N/A' }}
                            </td>
                            <td>
                                @if($submission->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($submission->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($submission->status == 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @elseif($submission->status == 'completed')
                                    <span class="badge bg-info">Completed</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($submission->status) }}</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin-asst.appointments.show', $submission) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($submission->status == 'pending')
                                    <form action="{{ route('admin-asst.appointments.approve', $submission) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="review_notes" value="Approved">
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Approve this request?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin-asst.appointments.reject', $submission) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="review_notes" value="Rejected">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Reject this request?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p class="mb-0">No service requests found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $submissions->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
