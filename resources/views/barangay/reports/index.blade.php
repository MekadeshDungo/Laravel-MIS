@extends('layouts.admin')

@section('title', 'Stray Reports')

@section('breadcrumb')
    <li class="breadcrumb-item active">Stray Reports</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">
            <i class="bi bi-exclamation-triangle me-2"></i>Stray Reports
        </h2>
        <a href="{{ route('barangay.reports.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>New Report
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Species</th>
                            <th>Location</th>
                            <th>Landmark</th>
                            <th>Photo</th>
                            <th>Urgency</th>
                            <th>Status</th>
                            <th>Reported</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                        <tr>
                            <td>#{{ $report->stray_report_id }}</td>
                            <td>
                                <span class="badge bg-{{ $report->report_type == 'stray' ? 'warning' : ($report->report_type == 'injured' ? 'danger' : 'info') }}">
                                    {{ ucfirst($report->report_type) }}
                                </span>
                            </td>
                            <td>{{ ucfirst($report->species) }}</td>
                            <td>{{ $report->street_address ?? $report->location_text ?? 'N/A' }}</td>
                            <td>{{ $report->landmark ?? '-' }}</td>
                            <td>
                                @if($report->image_path)
                                    <img src="{{ asset('storage/' . $report->image_path) }}" alt="Photo" class="img-thumbnail" style="max-width: 50px; max-height: 50px;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $report->getUrgencyBadgeColor() }}">
                                    {{ ucfirst($report->urgency_level) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $report->getStatusBadgeColor() }}">
                                    {{ ucfirst($report->report_status) }}
                                </span>
                            </td>
                            <td>{{ $report->created_at->format('M d, Y h:i A') }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewReportModal{{ $report->stray_report_id }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                No stray reports found.
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
@foreach($reports as $report)
<div class="modal fade" id="viewReportModal{{ $report->stray_report_id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">Stray Report #{{ $report->stray_report_id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Report Information</h6>
                        <table class="table table-sm">
                            <tr><td><strong>Type:</strong></td><td>{{ ucfirst($report->report_type) }}</td></tr>
                            <tr><td><strong>Species:</strong></td><td>{{ ucfirst($report->species) }}</td></tr>
                            <tr><td><strong>Urgency:</strong></td><td>{{ ucfirst($report->urgency_level) }}</td></tr>
                            <tr><td><strong>Status:</strong></td><td>{{ ucfirst($report->report_status) }}</td></tr>
                            <tr><td><strong>Reported At:</strong></td><td>{{ $report->reported_at->format('M d, Y h:i A') }}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary">Location Details</h6>
                        <table class="table table-sm">
                            <tr><td><strong>Street Address:</strong></td><td>{{ $report->street_address ?? $report->location_text ?? 'N/A' }}</td></tr>
                            @if($report->landmark)
                            <tr><td><strong>Landmark:</strong></td><td>{{ $report->landmark }}</td></tr>
                            @endif
                        </table>
                    </div>
                </div>
                @if($report->image_path)
                <div class="row mt-3">
                    <div class="col-12">
                        <h6 class="text-primary">Photo</h6>
                        <img src="{{ asset('storage/' . $report->image_path) }}" alt="Photo" class="img-thumbnail" style="max-width: 300px;">
                    </div>
                </div>
                @endif
                @if($report->description)
                <div class="row mt-3">
                    <div class="col-12">
                        <h6 class="text-primary">Description</h6>
                        <p>{{ $report->description }}</p>
                    </div>
                </div>
                @endif
                <div class="row mt-2">
                    <div class="col-md-6">
                        <h6 class="text-primary">Reporter Information</h6>
                        @if($report->reporter)
                        <table class="table table-sm">
                            <tr><td><strong>Name:</strong></td><td>{{ $report->reporter->name }}</td></tr>
                            <tr><td><strong>Email:</strong></td><td>{{ $report->reporter->email }}</td></tr>
                        </table>
                        @else
                        <p class="text-muted">Unknown reporter</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
