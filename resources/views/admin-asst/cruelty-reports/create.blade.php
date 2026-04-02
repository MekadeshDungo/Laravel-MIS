@extends('layouts.admin')

@section('title', 'New Cruelty Report')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>New Cruelty Report</h2>
        <a href="{{ route('admin-asst.cruelty-reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin-asst.cruelty-reports.store') }}">
                @csrf

                <h5 class="mb-3">Reporter Information</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Reporter Name *</label>
                        <input type="text" name="reporter_name" class="form-control @error('reporter_name') is-invalid @endif" value="{{ old('reporter_name') }}" required>
                        @error('reporter_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Reporter Contact</label>
                        <input type="text" name="reporter_contact" class="form-control" value="{{ old('reporter_contact') }}">
                    </div>
                </div>

                <h5 class="mb-3">Incident Information</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Location *</label>
                        <input type="text" name="location" class="form-control @error('location') is-invalid @endif" value="{{ old('location') }}" required>
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Barangay *</label>
                        <select name="barangay_id" class="form-select @error('barangay_id') is-invalid @endif" required>
                            <option value="">Select Barangay</option>
                            @foreach($barangays as $barangay)
                                <option value="{{ $barangay->barangay_id }}">{{ $barangay->barangay_name }}</option>
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
                        <input type="date" name="incident_date" class="form-control @error('incident_date') is-invalid @endif" value="{{ old('incident_date') }}" required>
                        @error('incident_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Violation Type *</label>
                        <select name="violation_type" class="form-select @error('violation_type') is-invalid @endif" required>
                            <option value="">Select Type</option>
                            @foreach(\App\Models\CrueltyReport::VIOLATION_TYPES as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
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
                        <input type="text" name="animal_type" class="form-control @error('animal_type') is-invalid @endif" value="{{ old('animal_type') }}" placeholder="e.g., Dog, Cat" required>
                        @error('animal_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Number of Animals *</label>
                        <input type="number" name="animal_count" class="form-control @error('animal_count') is-invalid @endif" value="{{ old('animal_count') }}" min="1" required>
                        @error('animal_count')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Animal Description</label>
                        <input type="text" name="animal_description" class="form-control" value="{{ old('animal_description') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description of Incident *</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @endif" rows="4" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit Report</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection