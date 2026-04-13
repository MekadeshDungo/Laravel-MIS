@extends('layouts.admin')

@section('title', 'Rabies Case Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $case->case_number }}</h1>
        <div>
            <a href="{{ route('rabies-cases.edit', $case) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('rabies-cases.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Case Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="text-muted">Case Type</label>
                            <p class="mb-0">
                                @switch($case->case_type)
                                    @case('positive')
                                        <span class="badge bg-danger">Positive</span>
                                        @break
                                    @case('probable')
                                        <span class="badge bg-warning">Probable</span>
                                        @break
                                    @case('suspect')
                                        <span class="badge bg-info">Suspect</span>
                                        @break
                                    @case('negative')
                                        <span class="badge bg-secondary">Negative</span>
                                        @break
                                @endswitch
                            </p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted">Species</label>
                            <p class="mb-0 fw-bold">{{ ucfirst($case->species) }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted">Status</label>
                            <p class="mb-0">
                                @switch($case->status)
                                    @case('open')
                                        <span class="badge bg-primary">Open</span>
                                        @break
                                    @case('closed')
                                        <span class="badge bg-success">Closed</span>
                                        @break
                                    @case('under_investigation')
                                        <span class="badge bg-warning">Under Investigation</span>
                                        @break
                                @endswitch
                            </p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted">Incident Date</label>
                            <p class="mb-0">{{ $case->incident_date->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Animal Name</label>
                            <p class="mb-0">{{ $case->animal_name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Incident Location</label>
                            <p class="mb-0">{{ $case->incident_location ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Owner Name</label>
                            <p class="mb-0">{{ $case->owner_name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Owner Contact</label>
                            <p class="mb-0">{{ $case->owner_contact ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Barangay</label>
                            <p class="mb-0">{{ $case->barangay->barangay_name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Address</label>
                            <p class="mb-0">{{ $case->address ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($case->findings || $case->actions_taken || $case->remarks)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Investigation Details</h5>
                </div>
                <div class="card-body">
                    @if($case->findings)
                    <div class="mb-3">
                        <label class="text-muted">Findings</label>
                        <p class="mb-0">{{ $case->findings }}</p>
                    </div>
                    @endif
                    @if($case->actions_taken)
                    <div class="mb-3">
                        <label class="text-muted">Actions Taken</label>
                        <p class="mb-0">{{ $case->actions_taken }}</p>
                    </div>
                    @endif
                    @if($case->remarks)
                    <div>
                        <label class="text-muted">Remarks</label>
                        <p class="mb-0">{{ $case->remarks }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">System Information</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Case No:</strong> {{ $case->case_number }}</p>
                    <p class="mb-2"><strong>Encoded By:</strong> {{ $case->user->name ?? 'N/A' }}</p>
                    <p class="mb-2"><strong>Created:</strong> {{ $case->created_at->format('M d, Y h:i A') }}</p>
                    <p class="mb-0"><strong>Updated:</strong> {{ $case->updated_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
