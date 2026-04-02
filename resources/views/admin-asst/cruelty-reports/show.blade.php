@extends('layouts.admin')

@section('title', 'Cruelty Report Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Report: {{ $crueltyReport->report_number }}</h2>
        <div>
            <a href="{{ route('admin-asst.cruelty-reports.edit', $crueltyReport) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin-asst.cruelty-reports.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Incident Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Report Number</label>
                            <p class="mb-0 fw-bold">{{ $crueltyReport->report_number }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Status</label>
                            <p class="mb-0">
                                <span class="badge bg-{{ $crueltyReport->status == 'pending' ? 'warning' : ($crueltyReport->status == 'investigating' ? 'info' : 'success') }}">
                                    {{ \App\Models\CrueltyReport::STATUSES[$crueltyReport->status] ?? $crueltyReport->status }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Incident Date</label>
                            <p class="mb-0">{{ \Carbon\Carbon::parse($crueltyReport->incident_date)->format('M d, Y') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Violation Type</label>
                            <p class="mb-0">
                                <span class="badge bg-danger">
                                    {{ \App\Models\CrueltyReport::VIOLATION_TYPES[$crueltyReport->violation_type] ?? $crueltyReport->violation_type }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Location</label>
                            <p class="mb-0">{{ $crueltyReport->location }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Barangay</label>
                            <p class="mb-0">{{ $crueltyReport->barangay->barangay_name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Description</label>
                        <p class="mb-0">{{ $crueltyReport->description }}</p>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Animal Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Animal Type</label>
                            <p class="mb-0">{{ $crueltyReport->animal_type }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Number of Animals</label>
                            <p class="mb-0">{{ $crueltyReport->animal_count }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Description</label>
                            <p class="mb-0">{{ $crueltyReport->animal_description ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($crueltyReport->investigation_date || $crueltyReport->findings)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Investigation Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Investigation Date</label>
                            <p class="mb-0">{{ $crueltyReport->investigation_date ? \Carbon\Carbon::parse($crueltyReport->investigation_date)->format('M d, Y') : 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Outcome</label>
                            <p class="mb-0">{{ \App\Models\CrueltyReport::OUTCOMES[$crueltyReport->outcome] ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Findings</label>
                        <p class="mb-0">{{ $crueltyReport->findings ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Action Taken</label>
                        <p class="mb-0">{{ $crueltyReport->action_taken ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Reporter Information</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>Name:</strong> {{ $crueltyReport->reporter_name }}</p>
                    <p class="mb-0"><strong>Contact:</strong> {{ $crueltyReport->reporter_contact ?? 'N/A' }}</p>
                </div>
            </div>

            @if($crueltyReport->investigator)
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Investigator</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $crueltyReport->investigator->name }}</p>
                </div>
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Record Info</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1"><small class="text-muted">Created: {{ $crueltyReport->created_at->format('M d, Y H:i') }}</small></p>
                    <p class="mb-0"><small class="text-muted">Updated: {{ $crueltyReport->updated_at->format('M d, Y H:i') }}</small></p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin-asst.cruelty-reports.destroy', $crueltyReport) }}" onsubmit="return confirm('Are you sure you want to delete this report?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash"></i> Delete Report
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection