@extends('layouts.admin')

@section('title', 'Edit Cruelty Report')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Report: {{ $crueltyReport->report_number }}</h2>
        <a href="{{ route('admin-asst.cruelty-reports.show', $crueltyReport) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin-asst.cruelty-reports.update', $crueltyReport) }}">
                @csrf
                @method('PUT')

                <h5 class="mb-3">Reporter Information</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Reporter Name *</label>
                        <input type="text" name="reporter_name" class="form-control @error('reporter_name') is-invalid @endif" value="{{ $crueltyReport->reporter_name }}" required>
                        @error('reporter_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Reporter Contact</label>
                        <input type="text" name="reporter_contact" class="form-control" value="{{ $crueltyReport->reporter_contact }}">
                    </div>
                </div>

                <h5 class="mb-3">Incident Information</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Location *</label>
                        <input type="text" name="location" class="form-control @error('location') is-invalid @endif" value="{{ $crueltyReport->location }}" required>
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Barangay *</label>
                        <select name="barangay_id" class="form-select @error('barangay_id') is-invalid @endif" required>
                            @foreach($barangays as $barangay)
                                <option value="{{ $barangay->barangay_id }}" {{ $crueltyReport->barangay_id == $barangay->barangay_id ? 'selected' : '' }}>
                                    {{ $barangay->barangay_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('barangay_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Incident Date *</label>
                        <input type="date" name="incident_date" class="form-control @error('incident_date') is-invalid @endif" value="{{ $crueltyReport->incident_date }}" required>
                        @error('incident_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Violation Type *</label>
                        <select name="violation_type" class="form-select @error('violation_type') is-invalid @endif" required>
                            @foreach(\App\Models\CrueltyReport::VIOLATION_TYPES as $key => $label)
                                <option value="{{ $key }}" {{ $crueltyReport->violation_type == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('violation_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <h5 class="mb-3">Animal Information</h5>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Animal Type *</label>
                        <input type="text" name="animal_type" class="form-control @error('animal_type') is-invalid @endif" value="{{ $crueltyReport->animal_type }}" required>
                        @error('animal_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Number of Animals *</label>
                        <input type="number" name="animal_count" class="form-control @error('animal_count') is-invalid @endif" value="{{ $crueltyReport->animal_count }}" min="1" required>
                        @error('animal_count')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Animal Description</label>
                        <input type="text" name="animal_description" class="form-control" value="{{ $crueltyReport->animal_description }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description of Incident *</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @endif" rows="4" required>{{ $crueltyReport->description }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <h5 class="mb-3">Investigation (Optional)</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            @foreach(\App\Models\CrueltyReport::STATUSES as $key => $label)
                                <option value="{{ $key }}" {{ $crueltyReport->status == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Investigation Date</label>
                        <input type="date" name="investigation_date" class="form-control" value="{{ $crueltyReport->investigation_date }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Findings</label>
                        <textarea name="findings" class="form-control" rows="2">{{ $crueltyReport->findings }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Action Taken</label>
                        <textarea name="action_taken" class="form-control" rows="2">{{ $crueltyReport->action_taken }}</textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Outcome</label>
                        <select name="outcome" class="form-select">
                            <option value="">Select Outcome</option>
                            @foreach(\App\Models\CrueltyReport::OUTCOMES as $key => $label)
                                <option value="{{ $key }}" {{ $crueltyReport->outcome == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update Report</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection