@extends('layouts.admin')

@section('title', 'Edit Pet Registration')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-edit me-2"></i>Edit Pet Registration</h2>
        <a href="{{ route('admin-asst.pet-registrations.show', $pet) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin-asst.pet-registrations.update', $pet) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Pet Information -->
                    <div class="col-md-8">
                        <h5 class="mb-3 text-primary"><i class="fas fa-info-circle me-2"></i>Pet Information</h5>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Pet Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $pet->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Species <span class="text-danger">*</span></label>
                                <select name="species" class="form-select @error('species') is-invalid @enderror" required>
                                    <option value="dog" {{ old('species', $pet->species) == 'dog' ? 'selected' : '' }}>Dog</option>
                                    <option value="cat" {{ old('species', $pet->species) == 'cat' ? 'selected' : '' }}>Cat</option>
                                    <option value="bird" {{ old('species', $pet->species) == 'bird' ? 'selected' : '' }}>Bird</option>
                                    <option value="other" {{ old('species', $pet->species) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('species')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Gender <span class="text-danger">*</span></label>
                                <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                    <option value="male" {{ old('gender', $pet->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $pet->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="unknown" {{ old('gender', $pet->gender) == 'unknown' ? 'selected' : '' }}>Unknown</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Breed <span class="text-danger">*</span></label>
                                <input type="text" name="breed" class="form-control @error('breed') is-invalid @enderror" value="{{ old('breed', $pet->breed) }}" required>
                                @error('breed')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Age</label>
                                <input type="text" name="age" class="form-control" value="{{ old('age', $pet->age) }}" placeholder="e.g., 2 years">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Weight (kg)</label>
                                <input type="text" name="weight" class="form-control" value="{{ old('weight', $pet->weight) }}" placeholder="e.g., 5.5">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Color/Markings</label>
                                <input type="text" name="color" class="form-control" value="{{ old('color', $pet->color) }}" placeholder="e.g., Brown with white spots">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Vaccination Status</label>
                                <select name="vaccination_status" class="form-select">
                                    <option value="">Select</option>
                                    <option value="up_to_date" {{ old('vaccination_status', $pet->vaccination_status) == 'up_to_date' ? 'selected' : '' }}>Up to Date</option>
                                    <option value="partial" {{ old('vaccination_status', $pet->vaccination_status) == 'partial' ? 'selected' : '' }}>Partial</option>
                                    <option value="none" {{ old('vaccination_status', $pet->vaccination_status) == 'none' ? 'selected' : '' }}>None</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Health Status</label>
                                <input type="text" name="health_status" class="form-control" value="{{ old('health_status', $pet->health_status) }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">License Number</label>
                                <input type="text" name="license_number" class="form-control" value="{{ old('license_number', $pet->license_number) }}" placeholder="LIC-2026-000001">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">License Expiry</label>
                                <input type="date" name="license_expiry" class="form-control" value="{{ old('license_expiry', $pet->license_expiry?->format('Y-m-d')) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Medical History</label>
                            <textarea name="medical_history" class="form-control" rows="2">{{ old('medical_history', $pet->medical_history) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="2">{{ old('notes', $pet->notes) }}</textarea>
                        </div>
                    </div>

                    <!-- Owner & Location -->
                    <div class="col-md-4">
                        <h5 class="mb-3 text-primary"><i class="fas fa-user me-2"></i>Owner Information</h5>
                        
                        <div class="mb-3">
                            <label class="form-label">Owner <span class="text-danger">*</span></label>
                            <select name="owner_id" class="form-select @error('owner_id') is-invalid @enderror" required>
                                <option value="">Select Owner</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('owner_id', $pet->owner_id ?? $pet->userOwner?->id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} @if($user->email)({{ $user->email }})@endif
                                    </option>
                                @endforeach
                            </select>
                            @error('owner_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Barangay</label>
                            <select name="barangay_id" class="form-select">
                                <option value="">Select Barangay</option>
                                @foreach($barangays as $barangay)
                                    <option value="{{ $barangay->barangay_id }}" {{ old('barangay_id', $pet->barangay_id) == $barangay->barangay_id ? 'selected' : '' }}>
                                        {{ $barangay->barangay_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <h5 class="mb-3 mt-4 text-primary"><i class="fas fa-camera me-2"></i>Pet Photo</h5>
                        
                        @if($pet->photo_url)
                            <div class="mb-3 text-center">
                                <img src="{{ asset('storage/' . $pet->photo_url) }}" alt="{{ $pet->name }}" class="img-thumbnail mb-2" style="max-height: 150px;">
                                <p class="small text-muted">Current photo</p>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Change Photo</label>
                            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                            <small class="text-muted">Max size: 2MB. Formats: jpeg, png, jpg, gif</small>
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin-asst.pet-registrations.show', $pet) }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Registration
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
