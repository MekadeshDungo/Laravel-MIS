@extends('layouts.admin')

@section('title', 'Add Clinical Action')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Add Clinical Action</h2>
        <a href="{{ route('admin-asst.clinical-actions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin-asst.clinical-actions.store') }}">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Action Type *</label>
                        <select name="action_type" class="form-select @error('action_type') is-invalid @endif" required>
                            <option value="">Select Type</option>
                            @foreach(\App\Models\ClinicalAction::ACTION_TYPES as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('action_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Action Date *</label>
                        <input type="date" name="action_date" class="form-control @error('action_date') is-invalid @endif" value="{{ old('action_date') }}" required>
                        @error('action_date')
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
                        <label class="form-label">Veterinarian</label>
                        <select name="veterinarian_id" class="form-select">
                            <option value="">Select Veterinarian</option>
                            @foreach($veterinarians as $vet)
                                <option value="{{ $vet->id }}">{{ $vet->name }}</option>
                            @endforeach
                        </select>
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
                    <div class="col-md-6">
                        <label class="form-label">Outcome</label>
                        <select name="outcome" class="form-select">
                            <option value="">Select Outcome</option>
                            @foreach(\App\Models\ClinicalAction::OUTCOMES as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Diagnosis</label>
                    <textarea name="diagnosis" class="form-control" rows="2">{{ old('diagnosis') }}</textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Treatment Given</label>
                        <textarea name="treatment_given" class="form-control" rows="2">{{ old('treatment_given') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Medication</label>
                        <textarea name="medication" class="form-control" rows="2">{{ old('medication') }}</textarea>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Follow-up Date</label>
                    <input type="date" name="follow_up_date" class="form-control" value="{{ old('follow_up_date') }}">
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Save Action</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection