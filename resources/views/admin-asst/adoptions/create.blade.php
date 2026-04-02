@extends('layouts.admin')

@section('title', 'New Adoption Request')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-heart me-2"></i>New Adoption Request</h2>
        <a href="{{ route('admin-asst.adoptions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin-asst.adoptions.store') }}">
                @csrf
                
                <!-- Animal Selection -->
                <h5 class="mb-3 text-primary"><i class="fas fa-paw me-2"></i>Select Impounded Animal</h5>
                
                <div class="mb-4">
                    <label class="form-label">Impounded Animal <span class="text-danger">*</span></label>
                    <select name="impound_id" class="form-select @error('impound_id') is-invalid @enderror" required>
                        <option value="">Select an animal...</option>
                        @forelse($availableImpounds as $impound)
                            <option value="{{ $impound->impound_id }}" {{ old('impound_id') == $impound->impound_id ? 'selected' : '' }}>
                                #{{ $impound->impound_id }} - {{ $impound->animal_tag_code ?? 'No Tag' }} 
                                ({{ $impound->intake_condition ?? 'Unknown condition' }}) 
                                - Intake: {{ $impound->intake_date ? $impound->intake_date->format('M d, Y') : 'N/A' }}
                            </option>
                        @empty
                            <option value="" disabled>No available impounds found</option>
                        @endforelse
                    </select>
                    @error('impound_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if($availableImpounds->isEmpty())
                        <small class="text-warning">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            No impounded animals available for adoption at this time.
                        </small>
                    @endif
                </div>

                <hr class="my-4">

                <!-- Adopter Information -->
                <h5 class="mb-3 text-primary"><i class="fas fa-user me-2"></i>Adopter Information</h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="adopter_name" class="form-control @error('adopter_name') is-invalid @enderror" 
                               value="{{ old('adopter_name') }}" required placeholder="Enter full name">
                        @error('adopter_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                        <input type="text" name="adopter_contact" class="form-control @error('adopter_contact') is-invalid @enderror" 
                               value="{{ old('adopter_contact') }}" required placeholder="09XX XXX XXXX">
                        @error('adopter_contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Complete Address <span class="text-danger">*</span></label>
                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2" required>{{ old('address') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Occupation</label>
                        <input type="text" name="occupation" class="form-control" value="{{ old('occupation') }}" placeholder="e.g., Teacher, Engineer">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Housing Type</label>
                        <select name="housing_type" class="form-select">
                            <option value="">Select</option>
                            <option value="owned" {{ old('housing_type') == 'owned' ? 'selected' : '' }}>Owned House</option>
                            <option value="rented" {{ old('housing_type') == 'rented' ? 'selected' : '' }}>Rented</option>
                            <option value="apartment" {{ old('housing_type') == 'apartment' ? 'selected' : '' }}>Apartment/Condo</option>
                            <option value="other" {{ old('housing_type') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Additional Information -->
                <h5 class="mb-3 text-primary"><i class="fas fa-question-circle me-2"></i>Additional Information</h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Do you have other pets?</label>
                        <div class="mt-2">
                            <div class="form-check form-check-inline">
                                <input type="radio" name="has_other_pets" id="hasPetsYes" value="1" class="form-check-input" {{ old('has_other_pets') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="hasPetsYes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="has_other_pets" id="hasPetsNo" value="0" class="form-check-input" {{ old('has_other_pets') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="hasPetsNo">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Other Pets Details</label>
                        <input type="text" name="other_pets_details" class="form-control" value="{{ old('other_pets_details') }}" placeholder="Describe other pets...">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Previous Pet Ownership Experience</label>
                    <textarea name="previous_experience" class="form-control" rows="2" placeholder="Describe your experience with pets...">{{ old('previous_experience') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Reason for Adoption <span class="text-danger">*</span></label>
                    <textarea name="reason_for_adoption" class="form-control @error('reason_for_adoption') is-invalid @enderror" rows="3" required placeholder="Why do you want to adopt?">{{ old('reason_for_adoption') }}</textarea>
                    @error('reason_for_adoption')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Additional Notes</label>
                    <textarea name="notes" class="form-control" rows="2" placeholder="Any additional information...">{{ old('notes') }}</textarea>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin-asst.adoptions.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary" @if($availableImpounds->isEmpty()) disabled @endif>
                        <i class="fas fa-paper-plane me-2"></i>Submit Adoption Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
