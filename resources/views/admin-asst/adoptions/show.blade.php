@extends('layouts.admin')

@section('title', 'Adoption Request Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-heart me-2"></i>Adoption Request #{{ $adoption->adoption_request_id }}</h2>
        <a href="{{ route('admin-asst.adoptions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="row">
        <!-- Main Details -->
        <div class="col-md-8">
            <!-- Adopter Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-user me-2"></i>Adopter Information</h4>
                        @if($adoption->request_status == 'pending')
                            <span class="badge bg-warning fs-6">Pending Review</span>
                        @elseif($adoption->request_status == 'approved')
                            <span class="badge bg-success fs-6">Approved</span>
                        @elseif($adoption->request_status == 'rejected')
                            <span class="badge bg-danger fs-6">Rejected</span>
                        @elseif($adoption->request_status == 'completed')
                            <span class="badge bg-info fs-6">Completed</span>
                        @else
                            <span class="badge bg-secondary fs-6">{{ ucfirst($adoption->request_status) }}</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted" style="width: 150px;">Name:</td>
                                    <td><strong>{{ $adoption->adopter_name }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Contact:</td>
                                    <td>{{ $adoption->adopter_contact }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Address:</td>
                                    <td>{{ $adoption->address }}</td>
                                </tr>
                                @if($adoption->occupation)
                                    <tr>
                                        <td class="text-muted">Occupation:</td>
                                        <td>{{ $adoption->occupation }}</td>
                                    </tr>
                                @endif
                                @if($adoption->housing_type)
                                    <tr>
                                        <td class="text-muted">Housing Type:</td>
                                        <td>{{ ucfirst($adoption->housing_type) }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted" style="width: 150px;">Has Other Pets:</td>
                                    <td>{{ $adoption->has_other_pets ? 'Yes' : 'No' }}</td>
                                </tr>
                                @if($adoption->other_pets_details)
                                    <tr>
                                        <td class="text-muted">Other Pets:</td>
                                        <td>{{ $adoption->other_pets_details }}</td>
                                    </tr>
                                @endif
                                @if($adoption->previous_experience)
                                    <tr>
                                        <td class="text-muted">Previous Experience:</td>
                                        <td>{{ $adoption->previous_experience }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="text-muted">Request Date:</td>
                                    <td>{{ $adoption->requested_at ? $adoption->requested_at->format('M d, Y') : 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>
                    <h6 class="text-muted mb-2">Reason for Adoption</h6>
                    <p class="mb-0">{{ $adoption->reason_for_adoption }}</p>

                    @if($adoption->notes)
                        <hr>
                        <h6 class="text-muted mb-2">Additional Notes</h6>
                        <p class="mb-0">{{ $adoption->notes }}</p>
                    @endif
                </div>
            </div>

            <!-- Impound/Animal Information -->
            @if($adoption->impound)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="fas fa-paw me-2"></i>Impounded Animal</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="text-muted" style="width: 150px;">Impound ID:</td>
                                <td><strong>#{{ $adoption->impound->impound_id }}</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Tag Code:</td>
                                <td>{{ $adoption->impound->animal_tag_code ?? 'Not assigned' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Intake Condition:</td>
                                <td>{{ ucfirst($adoption->impound->intake_condition ?? 'N/A') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Intake Location:</td>
                                <td>{{ $adoption->impound->intake_location ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Intake Date:</td>
                                <td>{{ $adoption->impound->intake_date ? $adoption->impound->intake_date->format('M d, Y') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Current Status:</td>
                                <td>
                                    <span class="badge bg-{{ $adoption->impound->current_disposition == 'impounded' ? 'warning' : ($adoption->impound->current_disposition == 'adopted' ? 'success' : 'secondary') }}">
                                        {{ ucfirst($adoption->impound->current_disposition) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Status History -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Status History</h5>
                </div>
                <div class="card-body">
                    @if($adoption->statusHistory && $adoption->statusHistory->count() > 0)
                        <div class="timeline">
                            @foreach($adoption->statusHistory->sortBy('change_date') as $history)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-{{ $history->status == 'approved' ? 'success' : ($history->status == 'rejected' ? 'danger' : ($history->status == 'completed' ? 'info' : 'warning')) }}"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-0 text-capitalize">{{ $history->status }}</h6>
                                        <small class="text-muted">{{ $history->change_date->format('M d, Y h:i A') }}</small>
                                        @if($history->notes)
                                            <p class="mb-0 mt-1">{{ $history->notes }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No status history available.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Actions</h5>
                </div>
                <div class="card-body">
                    @if($adoption->request_status == 'pending')
                        <form action="{{ route('admin-asst.adoptions.approve', $adoption) }}" method="POST" class="mb-2">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label small">Approval Notes (optional)</label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="Add notes..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-check-circle me-2"></i>Approve Adoption
                            </button>
                        </form>
                        
                        <hr>
                        
                        <form action="{{ route('admin-asst.adoptions.reject', $adoption) }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label small">Rejection Reason (optional)</label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="Reason for rejection..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-times-circle me-2"></i>Reject Request
                            </button>
                        </form>
                    @elseif($adoption->request_status == 'approved')
                        <form action="{{ route('admin-asst.adoptions.complete', $adoption) }}" method="POST" class="mb-2">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label small">Completion Notes (optional)</label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="Add notes..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-info w-100">
                                <i class="fas fa-check-double me-2"></i>Mark as Completed
                            </button>
                        </form>
                        
                        <form action="{{ route('admin-asst.adoptions.reset', $adoption) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-undo me-2"></i>Reset to Pending
                            </button>
                        </form>
                    @elseif($adoption->request_status == 'rejected')
                        <form action="{{ route('admin-asst.adoptions.reset', $adoption) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="fas fa-undo me-2"></i>Reset to Pending
                            </button>
                        </form>
                    @elseif($adoption->request_status == 'completed')
                        <div class="alert alert-success mb-0 text-center">
                            <i class="fas fa-check-double fa-2x mb-2"></i>
                            <p class="mb-0">Adoption completed successfully!</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Summary Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Summary</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted">Request ID:</td>
                            <td><strong>#{{ $adoption->adoption_request_id }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Status:</td>
                            <td>
                                @if($adoption->request_status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($adoption->request_status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($adoption->request_status == 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-info">Completed</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Submitted:</td>
                            <td>{{ $adoption->requested_at ? $adoption->requested_at->diffForHumans() : 'N/A' }}</td>
                        </tr>
                    </table>
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
