@extends('layouts.admin')

@section('title', 'Edit Medical/Vaccination Record')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Medical/Vaccination Record</h2>
        <a href="{{ route('admin-staff.medical-records.show', $medicalRecord) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin-staff.medical-records.update', $medicalRecord) }}">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Record Type *</label>
                        <select name="record_type" class="form-select @error('record_type') is-invalid @endif" required>
                            <option value="medical" {{ $medicalRecord->record_type == 'medical' ? 'selected' : '' }}>Medical Record</option>
                            <option value="vaccination" {{ $medicalRecord->record_type == 'vaccination' ? 'selected' : '' }}>Vaccination Record</option>
                        </select>
                        @error('record_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Record Date *</label>
                        <input type="date" name="record_date" class="form-control @error('record_date') is-invalid @endif" value="{{ $medicalRecord->record_date }}" required>
                        @error('record_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Animal Name *</label>
                        <input type="text" name="animal_name" class="form-control @error('animal_name') is-invalid @endif" value="{{ $medicalRecord->animal_name }}" required>
                        @error('animal_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Species *</label>
                        <input type="text" name="species" class="form-control @error('species') is-invalid @endif" value="{{ $medicalRecord->species }}" required>
                        @error('species')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Breed</label>
                        <input type="text" name="breed" class="form-control" value="{{ $medicalRecord->breed }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Owner Name *</label>
                        <input type="text" name="owner_name" class="form-control @error('owner_name') is-invalid @endif" value="{{ $medicalRecord->owner_name }}" required>
                        @error('owner_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Owner Contact</label>
                        <input type="text" name="owner_contact" class="form-control" value="{{ $medicalRecord->owner_contact }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Barangay *</label>
                        <select name="barangay_id" class="form-select @error('barangay_id') is-invalid @endif" required>
                            @foreach($barangays as $barangay)
                                <option value="{{ $barangay->barangay_id }}" {{ $medicalRecord->barangay_id == $barangay->barangay_id ? 'selected' : '' }}>
                                    {{ $barangay->barangay_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('barangay_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Diagnosis</label>
                    <textarea name="diagnosis" class="form-control" rows="2">{{ $medicalRecord->diagnosis }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Treatment</label>
                    <textarea name="treatment" class="form-control" rows="2">{{ $medicalRecord->treatment }}</textarea>
                </div>

                <h5 class="mt-4 mb-3">Vaccination Details</h5>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Vaccine Name</label>
                        <input type="text" name="vaccine_name" class="form-control" value="{{ $medicalRecord->vaccine_name }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Vaccination Date</label>
                        <input type="date" name="vaccination_date" class="form-control" value="{{ $medicalRecord->vaccination_date }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Next Vaccination Date</label>
                        <input type="date" name="next_vaccination_date" class="form-control" value="{{ $medicalRecord->next_vaccination_date }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ $medicalRecord->notes }}</textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update Record</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection