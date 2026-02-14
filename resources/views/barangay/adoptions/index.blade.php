@extends('layouts.admin')

@section('title', 'Adoption Requests')

@section('breadcrumb')
    <li class="breadcrumb-item active">Adoption Requests</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">
            <i class="bi bi-heart-fill me-2"></i>Adoption Requests
        </h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Adopter Name</th>
                            <th>Contact</th>
                            <th>Impound ID</th>
                            <th>Status</th>
                            <th>Requested</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($adoptions as $adoption)
                        <tr>
                            <td>#{{ $adoption->adoption_request_id }}</td>
                            <td>{{ $adoption->adopter_name }}</td>
                            <td>{{ $adoption->adopter_contact }}</td>
                            <td>#{{ $adoption->impound_id }}</td>
                            <td>
                                <span class="badge {{ $adoption->getStatusBadgeColor() }}">
                                    {{ ucfirst($adoption->request_status) }}
                                </span>
                            </td>
                            <td>{{ $adoption->requested_at->format('M d, Y') }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewAdoptionModal{{ $adoption->adoption_request_id }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                No adoption requests found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- View Modals -->
@foreach($adoptions as $adoption)
<div class="modal fade" id="viewAdoptionModal{{ $adoption->adoption_request_id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Adoption Request #{{ $adoption->adoption_request_id }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Adopter Information</h6>
                        <table class="table table-sm">
                            <tr><td><strong>Name:</strong></td><td>{{ $adoption->adopter_name }}</td></tr>
                            <tr><td><strong>Contact:</strong></td><td>{{ $adoption->adopter_contact }}</td></tr>
                            <tr><td><strong>Address:</strong></td><td>{{ $adoption->address }}</td></tr>
                            <tr><td><strong>Status:</strong></td><td>
                                <span class="badge {{ $adoption->getStatusBadgeColor() }}">
                                    {{ ucfirst($adoption->request_status) }}
                                </span>
                            </td></tr>
                            <tr><td><strong>Requested At:</strong></td><td>{{ $adoption->requested_at->format('M d, Y h:i A') }}</td></tr>
                        </table>
                    </div>
                    @if($adoption->impound)
                    <div class="col-md-6">
                        <h6 class="text-primary">Animal Information</h6>
                        <table class="table table-sm">
                            <tr><td><strong>Tag Code:</strong></td><td>{{ $adoption->impound->animal_tag_code ?? 'N/A' }}</td></tr>
                            <tr><td><strong>Intake Date:</strong></td><td>{{ $adoption->impound->intake_date->format('M d, Y') }}</td></tr>
                            <tr><td><strong>Intake Condition:</strong></td><td>{{ $adoption->impound->intake_condition ?? 'N/A' }}</td></tr>
                            <tr><td><strong>Current Disposition:</strong></td><td>{{ ucfirst($adoption->impound->current_disposition) }}</td></tr>
                        </table>
                    </div>
                    @endif
                </div>
                
                @if($adoption->statusHistory->count() > 0)
                <div class="row mt-3">
                    <div class="col-12">
                        <h6 class="text-primary">Status History</h6>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                    <th>Updated By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($adoption->statusHistory as $history)
                                <tr>
                                    <td>{{ $history->updated_at->format('M d, Y h:i A') }}</td>
                                    <td>{{ ucfirst($history->status) }}</td>
                                    <td>{{ $history->remarks ?? 'N/A' }}</td>
                                    <td>{{ $history->updatedBy->name ?? 'Unknown' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
