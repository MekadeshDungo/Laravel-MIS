@extends('layouts.admin')

@section('title', 'Medical/Vaccination Record Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Record Details</h2>
        <div>
            <a href="{{ route('admin-staff.medical-records.edit', $medicalRecord) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin-staff.medical-records.index') }}" class="btn btn-secondary">
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
                            <label class="text-muted">Record Type</label>
                            <p class="mb-0">
                                <span class="badge bg-{{ $medicalRecord->record_type == 'medical' ? 'primary' : 'success' }}">
                                    {{ ucfirst($medicalRecord->record_type) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Record Date</label>
                            <p class="mb-0">{{ \Carbon\Carbon::parse($medicalRecord->record_date)->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Animal Name</label>
                            <p class="mb-0">{{ $medicalRecord->animal_name }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Species</label>
                            <p class="mb-0">{{ $medicalRecord->species }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Breed</label>
                            <p class="mb-0">{{ $medicalRecord->breed ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Owner Name</label>
                            <p class="mb-0">{{ $medicalRecord->owner_name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Owner Contact</label>
                            <p class="mb-0">{{ $medicalRecord->owner_contact ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Barangay</label>
                        <p class="mb-0">{{ $medicalRecord->barangay->barangay_name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Medical Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted">Diagnosis</label>
                        <p class="mb-0">{{ $medicalRecord->diagnosis ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Treatment</label>
                        <p class="mb-0">{{ $medicalRecord->treatment ?? 'N/A' }}</p>
                    </div>
                    @if($medicalRecord->record_type == 'vaccination')
                    <hr>
                    <h6>Vaccination Details</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Vaccine Name</label>
                            <p class="mb-0">{{ $medicalRecord->vaccine_name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Vaccination Date</label>
                            <p class="mb-0">{{ $medicalRecord->vaccination_date ? \Carbon\Carbon::parse($medicalRecord->vaccination_date)->format('M d, Y') : 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Next Vaccination</label>
                            <p class="mb-0">{{ $medicalRecord->next_vaccination_date ? \Carbon\Carbon::parse($medicalRecord->next_vaccination_date)->format('M d, Y') : 'N/A' }}</p>
                        </div>
                    </div>
                    @endif
                    <div class="mb-3">
                        <label class="text-muted">Notes</label>
                        <p class="mb-0">{{ $medicalRecord->notes ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Record Info</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1"><small class="text-muted">Created: {{ $medicalRecord->created_at->format('M d, Y H:i') }}</small></p>
                    <p class="mb-0"><small class="text-muted">Last Updated: {{ $medicalRecord->updated_at->format('M d, Y H:i') }}</small></p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin-staff.medical-records.destroy', $medicalRecord) }}" onsubmit="return confirm('Are you sure you want to delete this record?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash"></i> Delete Record
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection