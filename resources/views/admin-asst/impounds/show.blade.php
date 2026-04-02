@extends('layouts.admin')

@section('title', 'Impound Record Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-shelter me-2"></i>Impound Record #{{ $impound->impound_id }}</h2>
        <a href="{{ route('admin-asst.impounds.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="row">
        <!-- Main Details -->
        <div class="col-md-8">
            <!-- Impound Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Impound Details</h4>
                        <span class="badge bg-{{ $impound->current_disposition == 'impounded' ? 'warning' : ($impound->current_disposition == 'adopted' ? 'success' : ($impound->current_disposition == 'claimed' ? 'info' : ($impound->current_disposition == 'euthanized' ? 'danger' : 'secondary'))) }} fs-6">
                            {{ ucfirst($impound->current_disposition) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-muted" style="width: 150px;">Impound ID:</td>
                            <td><strong>#{{ $impound->impound_id }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Animal Tag Code:</td>
                            <td>{{ $impound->animal_tag_code ?? 'Not assigned' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Intake Condition:</td>
                            <td>{{ ucfirst($impound->intake_condition ?? 'Unknown') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Intake Location:</td>
                            <td>{{ $impound->intake_location ?? 'Not specified' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Intake Date:</td>
                            <td>{{ $impound->intake_date ? $impound->intake_date->format('M d, Y h:i A') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Current Disposition:</td>
                            <td>
                                <span class="badge bg-{{ $impound->current_disposition == 'impounded' ? 'warning' : ($impound->current_disposition == 'adopted' ? 'success' : ($impound->current_disposition == 'claimed' ? 'info' : ($impound->current_disposition == 'euthanized' ? 'danger' : 'secondary'))) }}">
                                    {{ ucfirst($impound->current_disposition) }}
                                </span>
                            </td>
                        </tr>
                        @if($impound->strayReport)
                            <tr>
                                <td class="text-muted">Related Stray Report:</td>
                                <td>
                                    <a href="#">{{ $impound->strayReport->report_number ?? 'Report #' . $impound->strayReport->stray_report_id }}</a>
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>

            <!-- Status History -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Status History</h5>
                </div>
                <div class="card-body">
                    @if($impound->statusHistory && $impound->statusHistory->count() > 0)
                        <div class="timeline">
                            @foreach($impound->statusHistory->sortBy('change_date') as $history)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-{{ $history->status == 'adopted' ? 'success' : ($history->status == 'claimed' ? 'info' : ($history->status == 'euthanized' ? 'danger' : 'warning')) }}"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-0 text-capitalize">{{ str_replace('_', ' ', $history->status) }}</h6>
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

            <!-- Adoption Requests -->
            @if($impound->adoptionRequests && $impound->adoptionRequests->count() > 0)
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="fas fa-heart me-2"></i>Adoption Requests</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Adopter</th>
                                        <th>Contact</th>
                                        <th>Request Date</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($impound->adoptionRequests as $adoption)
                                        <tr>
                                            <td>{{ $adoption->adopter_name }}</td>
                                            <td>{{ $adoption->adopter_contact }}</td>
                                            <td>{{ $adoption->requested_at ? $adoption->requested_at->format('M d, Y') : 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $adoption->request_status == 'approved' ? 'success' : ($adoption->request_status == 'rejected' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($adoption->request_status) }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('admin-asst.adoptions.show', $adoption) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar Actions -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-exchange-alt me-2"></i>Update Disposition</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin-asst.impounds.update', $impound) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">New Disposition</label>
                            <select name="current_disposition" class="form-select @error('current_disposition') is-invalid @enderror">
                                <option value="impounded" {{ $impound->current_disposition == 'impounded' ? 'selected' : '' }}>Impounded</option>
                                <option value="claimed" {{ $impound->current_disposition == 'claimed' ? 'selected' : '' }}>Claimed</option>
                                <option value="adopted" {{ $impound->current_disposition == 'adopted' ? 'selected' : '' }}>Adopted</option>
                                <option value="transferred" {{ $impound->current_disposition == 'transferred' ? 'selected' : '' }}>Transferred</option>
                                <option value="euthanized" {{ $impound->current_disposition == 'euthanized' ? 'selected' : '' }}>Euthanized</option>
                            </select>
                            @error('current_disposition')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="Add notes..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-2"></i>Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Summary -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Summary</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted">Record Created:</td>
                            <td>{{ $impound->created_at->format('M d, Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Days in Shelter:</td>
                            <td>{{ $impound->intake_date ? $impound->intake_date->diffInDays(now()) : 'N/A' }} days</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Adoption Requests:</td>
                            <td>{{ $impound->adoptionRequests ? $impound->adoptionRequests->count() : 0 }}</td>
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
