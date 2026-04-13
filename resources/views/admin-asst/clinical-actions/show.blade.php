@extends('layouts.admin')

@section('title', 'Clinical Action Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Action Details</h2>
        <div>
            <a href="{{ route('admin-asst.clinical-actions.edit', $clinicalAction) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin-asst.clinical-actions.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Action Type</label>
                            <p class="mb-0">
                                <span class="badge bg-info">
                                    {{ \App\Models\ClinicalAction::ACTION_TYPES[$clinicalAction->action_type] ?? $clinicalAction->action_type }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Action Date</label>
                            <p class="mb-0">{{ \Carbon\Carbon::parse($clinicalAction->action_date)->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Animal Name</label>
                            <p class="mb-0">{{ $clinicalAction->animal_name }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Species</label>
                            <p class="mb-0">{{ $clinicalAction->species }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Outcome</label>
                            <p class="mb-0">{{ \App\Models\ClinicalAction::OUTCOMES[$clinicalAction->outcome] ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Owner Name</label>
                            <p class="mb-0">{{ $clinicalAction->owner_name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Owner Contact</label>
                            <p class="mb-0">{{ $clinicalAction->owner_contact ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Barangay</label>
                        <p class="mb-0">{{ $clinicalAction->barangay->barangay_name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Clinical Details</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted">Description</label>
                        <p class="mb-0">{{ $clinicalAction->description ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Diagnosis</label>
                        <p class="mb-0">{{ $clinicalAction->diagnosis ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Treatment Given</label>
                        <p class="mb-0">{{ $clinicalAction->treatment_given ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Medication</label>
                        <p class="mb-0">{{ $clinicalAction->medication ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Follow-up Date</label>
                        <p class="mb-0">{{ $clinicalAction->follow_up_date ? \Carbon\Carbon::parse($clinicalAction->follow_up_date)->format('M d, Y') : 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Veterinarian</h5>
                </div>
                <div class="card-body">
                    @if($clinicalAction->veterinarian)
                        <p class="mb-0">{{ $clinicalAction->veterinarian->name }}</p>
                    @else
                        <p class="mb-0 text-muted">Not assigned</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Record Info</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1"><small class="text-muted">Created: {{ $clinicalAction->created_at->format('M d, Y H:i') }}</small></p>
                    <p class="mb-0"><small class="text-muted">Updated: {{ $clinicalAction->updated_at->format('M d, Y H:i') }}</small></p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin-asst.clinical-actions.destroy', $clinicalAction) }}" onsubmit="return confirm('Are you sure you want to delete this action?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash"></i> Delete Action
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection