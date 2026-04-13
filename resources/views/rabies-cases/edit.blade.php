@extends('layouts.admin')

@section('title', 'Edit Rabies Case')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Rabies Case: {{ $case->case_number }}</h1>
        <a href="{{ route('rabies-cases.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('rabies-cases.update', $case) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="case_type" class="form-label">Case Type *</label>
                        <select name="case_type" id="case_type" class="form-select @error('case_type') is-invalid @endreq" required>
                            <option value="">Select Type</option>
                            <option value="positive" {{ old('case_type', $case->case_type) == 'positive' ? 'selected' : '' }}>Positive</option>
                            <option value="probable" {{ old('case_type', $case->case_type) == 'probable' ? 'selected' : '' }}>Probable</option>
                            <option value="suspect" {{ old('case_type', $case->case_type) == 'suspect' ? 'selected' : '' }}>Suspect</option>
                            <option value="negative" {{ old('case_type', $case->case_type) == 'negative' ? 'selected' : '' }}>Negative</option>
                        </select>
                        @error('case_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="species" class="form-label">Species *</label>
                        <select name="species" id="species" class="form-select @error('species') is-invalid @endreq" required>
                            <option value="">Select Species</option>
                            <option value="dog" {{ old('species', $case->species) == 'dog' ? 'selected' : '' }}>Dog</option>
                            <option value="cat" {{ old('species', $case->species) == 'cat' ? 'selected' : '' }}>Cat</option>
                            <option value="other" {{ old('species', $case->species) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('species')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="incident_date" class="form-label">Incident Date *</label>
                        <input type="date" name="incident_date" id="incident_date" class="form-control @error('incident_date') is-invalid @endreq" value="{{ old('incident_date', $case->incident_date->format('Y-m-d')) }}" required>
                        @error('incident_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="incident_location" class="form-label">Incident Location</label>
                        <input type="text" name="incident_location" id="incident_location" class="form-control" value="{{ old('incident_location', $case->incident_location) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="animal_name" class="form-label">Animal Name</label>
                        <input type="text" name="animal_name" id="animal_name" class="form-control" value="{{ old('animal_name', $case->animal_name) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="owner_name" class="form-label">Owner Name</label>
                        <input type="text" name="owner_name" id="owner_name" class="form-control" value="{{ old('owner_name', $case->owner_name) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="owner_contact" class="form-label">Owner Contact</label>
                        <input type="text" name="owner_contact" id="owner_contact" class="form-control" value="{{ old('owner_contact', $case->owner_contact) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="barangay_id" class="form-label">Barangay</label>
                        <select name="barangay_id" id="barangay_id" class="form-select">
                            <option value="">Select Barangay</option>
                            @foreach($barangays as $id => $name)
                                <option value="{{ $id }}" {{ old('barangay_id', $case->barangay_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $case->address) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="open" {{ old('status', $case->status) == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="closed" {{ old('status', $case->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                        <option value="under_investigation" {{ old('status', $case->status) == 'under_investigation' ? 'selected' : '' }}>Under Investigation</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="findings" class="form-label">Findings</label>
                    <textarea name="findings" id="findings" class="form-control" rows="3">{{ old('findings', $case->findings) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="actions_taken" class="form-label">Actions Taken</label>
                    <textarea name="actions_taken" id="actions_taken" class="form-control" rows="3">{{ old('actions_taken', $case->actions_taken) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="remarks" class="form-label">Remarks</label>
                    <textarea name="remarks" id="remarks" class="form-control" rows="2">{{ old('remarks', $case->remarks) }}</textarea>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Case
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
