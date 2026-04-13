@extends('layouts.admin')

@section('title', 'Add Medical/Vaccination Record')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Add Medical/Vaccination Record</h2>
        <a href="{{ route('admin-staff.medical-records.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin-staff.medical-records.store') }}">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Record Type *</label>
                        <select name="record_type" class="form-select @error('record_type') is-invalid @endif" required>
                            <option value="">Select Type</option>
                            <option value="medical">Medical Record</option>
                            <option value="vaccination">Vaccination Record</option>
                        </select>
                        @error('record_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Record Date *</label>
                        <input type="date" name="record_date" class="form-control @error('record_date') is-invalid @endif" value="{{ old('record_date') }}" required>
                        @error('record_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Animal Name *</label>
                        <input type="text" name="animal_name" class="form-control @error('animal_name') is-invalid @endif" value="{{ old('animal_name') }}" required>
                        @error('animal_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Species *</label>
                        <input type="text" name="species" class="form-control @error('species') is-invalid @endif" value="{{ old('species') }}" placeholder="e.g., Dog, Cat" required>
                        @error('species')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Breed</label>
                        <input type="text" name="breed" class="form-control" value="{{ old('breed') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Owner Name *</label>
                        <input type="text" name="owner_name" class="form-control @error('owner_name') is-invalid @endif" value="{{ old('owner_name') }}" required>
                        @error('owner_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Owner Contact</label>
                        <input type="text" name="owner_contact" class="form-control" value="{{ old('owner_contact') }}">
                    </div>
                </div>

                <div class="row mb-3">
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

                <div class="mb-3">
                    <label class="form-label">Diagnosis</label>
                    <textarea name="diagnosis" class="form-control" rows="2">{{ old('diagnosis') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Treatment</label>
                    <textarea name="treatment" class="form-control" rows="2">{{ old('treatment') }}</textarea>
                </div>

                <h5 class="mt-4 mb-3">Vaccination Details (if applicable)</h5>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Vaccine Name</label>
                        <input type="text" name="vaccine_name" class="form-control" value="{{ old('vaccine_name') }}" placeholder="e.g., Anti-Rabies">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Vaccination Date</label>
                        <input type="date" name="vaccination_date" class="form-control" value="{{ old('vaccination_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Next Vaccination Date</label>
                        <input type="date" name="next_vaccination_date" class="form-control" value="{{ old('next_vaccination_date') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Save Record</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection