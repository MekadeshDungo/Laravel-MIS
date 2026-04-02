@extends('layouts.admin')

@section('title', 'Service Request Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-file-alt me-2"></i>Service Request #{{ $appointment->id }}</h2>
        <a href="{{ route('admin-asst.appointments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="row">
        <!-- Main Details -->
        <div class="col-md-8">
            <!-- Request Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Request Details</h4>
                        @if($appointment->status == 'pending')
                            <span class="badge bg-warning fs-6">Pending</span>
                        @elseif($appointment->status == 'approved')
                            <span class="badge bg-success fs-6">Approved</span>
                        @elseif($appointment->status == 'rejected')
                            <span class="badge bg-danger fs-6">Rejected</span>
                        @elseif($appointment->status == 'completed')
                            <span class="badge bg-info fs-6">Completed</span>
                        @else
                            <span class="badge bg-secondary fs-6">{{ ucfirst($appointment->status) }}</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted" style="width: 150px;">Service Type:</td>
                                    <td>
                                        @if($appointment->form)
                                            <strong>{{ $appointment->form->title }}</strong>
                                            <br><small class="text-muted">{{ ucfirst(str_replace('_', ' ', $appointment->form->form_type)) }}</small>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Submission ID:</td>
                                    <td><strong>#{{ $appointment->id }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Submitted At:</td>
                                    <td>{{ $appointment->submitted_at ? $appointment->submitted_at->format('M d, Y h:i A') : 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted" style="width: 150px;">Status:</td>
                                    <td>
                                        @if($appointment->status == 'pending')
                                            <span class="badge bg-warning">Pending Review</span>
                                        @elseif($appointment->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($appointment->status == 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @else
                                            <span class="badge bg-info">{{ ucfirst($appointment->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @if($appointment->reviewer)
                                    <tr>
                                        <td class="text-muted">Reviewed By:</td>
                                        <td>{{ $appointment->reviewer->name }}</td>
                                    </tr>
                                @endif
                                @if($appointment->reviewed_at)
                                    <tr>
                                        <td class="text-muted">Reviewed At:</td>
                                        <td>{{ $appointment->reviewed_at->format('M d, Y h:i A') }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    @if($appointment->review_notes)
                        <hr>
                        <h6 class="text-muted mb-2">Review Notes</h6>
                        <div class="alert alert-info mb-0">
                            {{ $appointment->review_notes }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Citizen Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Citizen Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" style="width: 150px;">Name:</td>
                            <td><strong>{{ $appointment->citizen_name }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Contact:</td>
                            <td>{{ $appointment->citizen_contact ?? 'Not provided' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Address:</td>
                            <td>{{ $appointment->citizen_address ?? 'Not provided' }}</td>
                        </tr>
                        @if($appointment->submitter)
                            <tr>
                                <td class="text-muted">Submitted By:</td>
                                <td>{{ $appointment->submitter->name }} ({{ $appointment->submitter->email }})</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>

            <!-- Form Data / Payload -->
            @if($appointment->payload_json)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="fas fa-database me-2"></i>Form Data</h5>
                    </div>
                    <div class="card-body">
                        <pre class="mb-0 bg-light p-3 rounded" style="max-height: 300px; overflow: auto;">{{ json_encode($appointment->payload_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar Actions -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Actions</h5>
                </div>
                <div class="card-body">
                    @if($appointment->status == 'pending')
                        <form action="{{ route('admin-asst.appointments.approve', $appointment) }}" method="POST" class="mb-2">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label small">Approval Notes (optional)</label>
                                <textarea name="review_notes" class="form-control" rows="2" placeholder="Add notes..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-check-circle me-2"></i>Approve Request
                            </button>
                        </form>
                        
                        <hr>
                        
                        <form action="{{ route('admin-asst.appointments.reject', $appointment) }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label small">Rejection Reason (optional)</label>
                                <textarea name="review_notes" class="form-control" rows="2" placeholder="Reason for rejection..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-times-circle me-2"></i>Reject Request
                            </button>
                        </form>
                    @elseif($appointment->status == 'approved')
                        <form action="{{ route('admin-asst.appointments.complete', $appointment) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-info w-100">
                                <i class="fas fa-check-double me-2"></i>Mark as Completed
                            </button>
                        </form>
                        
                        <form action="{{ route('admin-asst.appointments.reset', $appointment) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-undo me-2"></i>Reset to Pending
                            </button>
                        </form>
                    @elseif($appointment->status == 'rejected')
                        <form action="{{ route('admin-asst.appointments.reset', $appointment) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="fas fa-undo me-2"></i>Reset to Pending
                            </button>
                        </form>
                    @elseif($appointment->status == 'completed')
                        <div class="alert alert-success mb-0 text-center">
                            <i class="fas fa-check-double fa-2x mb-2"></i>
                            <p class="mb-0">This request has been completed.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Timeline -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Timeline</h5>
                </div>
                <div class="card-body">
                    <ul class="timeline mb-0">
                        <li class="timeline-item">
                            <div class="timeline-marker bg-secondary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-0">Submitted</h6>
                                <small class="text-muted">
                                    {{ $appointment->submitted_at ? $appointment->submitted_at->format('M d, Y h:i A') : 'N/A' }}
                                </small>
                            </div>
                        </li>
                        @if($appointment->reviewed_at)
                            <li class="timeline-item">
                                <div class="timeline-marker bg-{{ $appointment->status == 'approved' ? 'success' : 'danger' }}"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-0 text-capitalize">{{ $appointment->status }}</h6>
                                    <small class="text-muted">
                                        {{ $appointment->reviewed_at->format('M d, Y h:i A') }}
                                    </small>
                                    @if($appointment->reviewer)
                                        <br><small>by {{ $appointment->reviewer->name }}</small>
                                    @endif
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .timeline {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .timeline-item {
        position: relative;
        padding-left: 30px;
        padding-bottom: 20px;
    }
    .timeline-item:last-child {
        padding-bottom: 0;
    }
    .timeline-marker {
        position: absolute;
        left: 0;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }
    .timeline-content {
        padding-left: 10px;
        border-left: 2px solid #e9ecef;
    }
</style>
@endpush
