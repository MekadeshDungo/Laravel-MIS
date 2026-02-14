@extends('layouts.admin')

@section('title', 'Impound Records')

@section('breadcrumb')
    <li class="breadcrumb-item active">Impound Records</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">
            <i class="bi bi-box-seam me-2"></i>Impound Records
        </h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tag Code</th>
                            <th>Intake Date</th>
                            <th>Condition</th>
                            <th>Location</th>
                            <th>Disposition</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($impounds as $impound)
                        <tr>
                            <td>#{{ $impound->impound_id }}</td>
                            <td>{{ $impound->animal_tag_code ?? 'N/A' }}</td>
                            <td>{{ $impound->intake_date->format('M d, Y') }}</td>
                            <td>{{ $impound->intake_condition ?? 'N/A' }}</td>
                            <td>{{ $impound->intake_location ?? 'N/A' }}</td>
                            <td>
                                <span class="badge {{ $impound->getDispositionBadgeColor() }}">
                                    {{ ucfirst($impound->current_disposition) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewImpoundModal{{ $impound->impound_id }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                No impound records found.
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
@foreach($impounds as $impound)
<div class="modal fade" id="viewImpoundModal{{ $impound->impound_id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Impound Record #{{ $impound->impound_id }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Animal Information</h6>
                        <table class="table table-sm">
                            <tr><td><strong>Tag Code:</strong></td><td>{{ $impound->animal_tag_code ?? 'N/A' }}</td></tr>
                            <tr><td><strong>Intake Date:</strong></td><td>{{ $impound->intake_date->format('M d, Y h:i A') }}</td></tr>
                            <tr><td><strong>Intake Condition:</strong></td><td>{{ $impound->intake_condition ?? 'N/A' }}</td></tr>
                            <tr><td><strong>Intake Location:</strong></td><td>{{ $impound->intake_location ?? 'N/A' }}</td></tr>
                            <tr><td><strong>Current Disposition:</strong></td><td>{{ ucfirst($impound->current_disposition) }}</td></tr>
                        </table>
                    </div>
                    @if($impound->strayReport)
                    <div class="col-md-6">
                        <h6 class="text-primary">Related Report</h6>
                        <table class="table table-sm">
                            <tr><td><strong>Report ID:</strong></td><td>#{{ $impound->strayReport->stray_report_id }}</td></tr>
                            <tr><td><strong>Type:</strong></td><td>{{ ucfirst($impound->strayReport->report_type) }}</td></tr>
                            <tr><td><strong>Species:</strong></td><td>{{ ucfirst($impound->strayReport->species) }}</td></tr>
                            <tr><td><strong>Location:</strong></td><td>{{ $impound->strayReport->location_text ?? 'N/A' }}</td></tr>
                        </table>
                    </div>
                    @endif
                </div>
                
                @if($impound->statusHistory->count() > 0)
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
                                @foreach($impound->statusHistory as $history)
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
