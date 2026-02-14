@extends('layouts.admin')

@section('title', 'New Stray Report')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('barangay.reports.index') }}">Stray Reports</a></li>
    <li class="breadcrumb-item active">New</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">
                <i class="bi bi-plus-circle me-2"></i>New Stray Report
            </h2>
            <p class="text-muted">Submit a new stray, nuisance, or injured animal report.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('barangay.reports.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="report_type" class="form-label">Report Type *</label>
                                <select class="form-select @error('report_type') is-invalid @enderror" id="report_type" name="report_type" required>
                                    <option value="">Select type...</option>
                                    <option value="stray" {{ old('report_type') == 'stray' ? 'selected' : '' }}>Stray Animal</option>
                                    <option value="nuisance" {{ old('report_type') == 'nuisance' ? 'selected' : '' }}>Nuisance Complaint</option>
                                    <option value="injured" {{ old('report_type') == 'injured' ? 'selected' : 'injured' }}>Injured Animal</option>
                                </select>
                                @error('report_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="species" class="form-label">Species *</label>
                                <select class="form-select @error('species') is-invalid @enderror" id="species" name="species" required>
                                    <option value="">Select species...</option>
                                    <option value="dog" {{ old('species') == 'dog' ? 'selected' : '' }}>Dog</option>
                                    <option value="cat" {{ old('species') == 'cat' ? 'selected' : '' }}>Cat</option>
                                    <option value="other" {{ old('species') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('species')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="urgency_level" class="form-label">Urgency Level *</label>
                            <select class="form-select @error('urgency_level') is-invalid @enderror" id="urgency_level" name="urgency_level" required>
                                <option value="low" {{ old('urgency_level') == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('urgency_level') == 'medium' ? 'selected' : 'medium' }}>Medium</option>
                                <option value="high" {{ old('urgency_level') == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                            @error('urgency_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="location_text" class="form-label">Location Description</label>
                            <input type="text" class="form-control @error('location_text') is-invalid @enderror" 
                                id="location_text" name="location_text" value="{{ old('location_text') }}" 
                                placeholder="e.g., Near the church, Corner of Main St.">
                            @error('location_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="street_address" class="form-label">Street Address</label>
                                <input type="text" class="form-control @error('street_address') is-invalid @enderror" 
                                    id="street_address" name="street_address" value="{{ old('street_address') }}" 
                                    placeholder="e.g., 123 Main Street">
                                @error('street_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="landmark" class="form-label">Landmark</label>
                                <input type="text" class="form-control @error('landmark') is-invalid @enderror" 
                                    id="landmark" name="landmark" value="{{ old('landmark') }}" 
                                    placeholder="e.g., Near the church, beside school">
                                @error('landmark')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Photo</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Upload a photo of the animal (optional)</small>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="4" 
                                placeholder="Provide additional details about the animal or situation...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('barangay.reports.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>Submit Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card bg-info text-white shadow-sm">
                <div class="card-body">
                    <h5><i class="bi bi-info-circle me-2"></i>Tips</h5>
                    <ul class="mb-0">
                        <li>Be specific about the location</li>
                        <li>Describe the animal's appearance</li>
                        <li>Mention if the animal appears sick or aggressive</li>
                        <li>Include any identifying marks</li>
                        <li>Note if the animal has an owner</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
