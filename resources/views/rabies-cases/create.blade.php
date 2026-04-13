@extends('layouts.admin')

@section('title', 'Add Rabies Case')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            @if(isset($rabiesReport))
                Create Rabies Case from Report
            @else
                Add Rabies Case
            @endif
        </h1>
        <a href="{{ isset($rabiesReport) ? route('city-vet.rabies-bite-reports.show', $rabiesReport->id) : route('city-vet.rabies-geomap') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    @if(isset($rabiesReport))
    <!-- Source Report Info -->
    <div class="alert alert-info mb-4">
        <h5><i class="fas fa-info-circle"></i> Creating case from Rabies Bite Report</h5>
        <p class="mb-0">Report Number: <strong>{{ $rabiesReport->report_number }}</strong></p>
        <p class="mb-0">Patient: <strong>{{ $rabiesReport->patient_name }}</strong></p>
        <p class="mb-0">Incident Date: <strong>{{ \Carbon\Carbon::parse($rabiesReport->incident_date)->format('M d, Y') }}</strong></p>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ isset($rabiesReport) ? route('city-vet.rabies-bite-reports.store-case', $rabiesReport->id) : route('city-vet.rabies-geomap') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="case_type" class="form-label">Case Type *</label>
                        <select name="case_type" id="case_type" class="form-select @error('case_type') is-invalid @enderror" required>
                            <option value="">Select Type</option>
                            <option value="positive" {{ (old('case_type') ?? ($prefill['case_type'] ?? '')) == 'positive' ? 'selected' : '' }}>Positive</option>
                            <option value="probable" {{ (old('case_type') ?? ($prefill['case_type'] ?? '')) == 'probable' ? 'selected' : '' }}>Probable</option>
                            <option value="suspect" {{ (old('case_type') ?? ($prefill['case_type'] ?? '')) == 'suspect' ? 'selected' : '' }}>Suspect</option>
                            <option value="negative" {{ (old('case_type') ?? ($prefill['case_type'] ?? '')) == 'negative' ? 'selected' : '' }}>Negative</option>
                        </select>
                        @error('case_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="species" class="form-label">Species *</label>
                        <select name="species" id="species" class="form-select @error('species') is-invalid @enderror" required>
                            <option value="">Select Species</option>
                            <option value="dog" {{ (old('species') ?? ($prefill['species'] ?? '')) == 'dog' ? 'selected' : '' }}>Dog</option>
                            <option value="cat" {{ (old('species') ?? ($prefill['species'] ?? '')) == 'cat' ? 'selected' : '' }}>Cat</option>
                            <option value="other" {{ (old('species') ?? ($prefill['species'] ?? '')) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('species')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="incident_date" class="form-label">Incident Date *</label>
                        <input type="date" name="incident_date" id="incident_date" class="form-control @error('incident_date') is-invalid @enderror" value="{{ old('incident_date', ($prefill['incident_date'] ?? date('Y-m-d'))) }}" required>
                        @error('incident_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="incident_location" class="form-label">Incident Location</label>
                        <input type="text" name="incident_location" id="incident_location" class="form-control @error('incident_location') is-invalid @enderror" value="{{ old('incident_location', ($prefill['incident_location'] ?? '')) }}">
                        @error('incident_location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="animal_name" class="form-label">Animal Name / Identifier</label>
                        <input type="text" name="animal_name" id="animal_name" class="form-control" value="{{ old('animal_name', ($prefill['animal_name'] ?? '')) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="owner_name" class="form-label">Owner Name</label>
                        <input type="text" name="owner_name" id="owner_name" class="form-control" value="{{ old('owner_name', ($prefill['owner_name'] ?? '')) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="owner_contact" class="form-label">Owner Contact</label>
                        <input type="text" name="owner_contact" id="owner_contact" class="form-control" value="{{ old('owner_contact') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="barangay_id" class="form-label">Barangay</label>
                        <select name="barangay_id" id="barangay_id" class="form-select @error('barangay_id') is-invalid @enderror">
                            <option value="">Select Barangay</option>
                            @foreach($barangays as $id => $name)
                                <option value="{{ $id }}" {{ (old('barangay_id') ?? ($prefill['barangay_id'] ?? '')) == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('barangay_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="open" {{ old('status', 'open') == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                        <option value="under_investigation" {{ old('status') == 'under_investigation' ? 'selected' : '' }}>Under Investigation</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="findings" class="form-label">Findings</label>
                    <textarea name="findings" id="findings" class="form-control @error('findings') is-invalid @enderror" rows="3">{{ old('findings') }}</textarea>
                    @error('findings')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="actions_taken" class="form-label">Actions Taken</label>
                    <textarea name="actions_taken" id="actions_taken" class="form-control @error('actions_taken') is-invalid @enderror" rows="3">{{ old('actions_taken') }}</textarea>
                    @error('actions_taken')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="remarks" class="form-label">Remarks</label>
                    <textarea name="remarks" id="remarks" class="form-control @error('remarks') is-invalid @enderror" rows="2">{{ old('remarks', ($prefill['remarks'] ?? '')) }}</textarea>
                    @error('remarks')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Case
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
