@extends('layouts.admin')

@section('title', isset($report) ? 'Edit Spay/Neuter Report' : 'New Spay/Neuter Report')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            {{ isset($report) ? 'Edit Spay/Neuter Report' : 'New Spay/Neuter Report' }}
        </h1>
        <a href="{{ route('spay-neuter.reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ isset($report) ? route('spay-neuter.reports.update', $report->id) : route('spay-neuter.reports.store') }}" method="POST">
                @csrf
                @if(isset($report))
                @method('PUT')
                @endif

                <div class="row">
                    <!-- Pet Information -->
                    <div class="col-md-6 mb-3">
                        <h5 class="text-primary mb-3">Pet Information</h5>
                        
                        <div class="mb-3">
                            <label for="pet_name" class="form-label">Pet Name (Optional)</label>
                            <input type="text" class="form-control @error('pet_name') is-invalid @enderror" 
                                   id="pet_name" name="pet_name" value="{{ old('pet_name', $report->pet_name ?? '') }}">
                            @error('pet_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pet_type" class="form-label">Pet Type *</label>
                            <select class="form-control @error('pet_type') is-invalid @enderror" id="pet_type" name="pet_type" required>
                                <option value="">Select Type</option>
                                <option value="dog" {{ old('pet_type', $report->pet_type ?? '') == 'dog' ? 'selected' : '' }}>Dog</option>
                                <option value="cat" {{ old('pet_type', $report->pet_type ?? '') == 'cat' ? 'selected' : '' }}>Cat</option>
                                <option value="other" {{ old('pet_type', $report->pet_type ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('pet_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pet_breed" class="form-label">Breed (Optional)</label>
                            <input type="text" class="form-control @error('pet_breed') is-invalid @enderror" 
                                   id="pet_breed" name="pet_breed" value="{{ old('pet_breed', $report->pet_breed ?? '') }}">
                            @error('pet_breed')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pet_age" class="form-label">Age (years)</label>
                                <input type="number" class="form-control @error('pet_age') is-invalid @endreed' name="pet_age" min="0" value="{{ old('pet_age', $report->pet_age ?? '') }}">
                                @error('pet_age')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="pet_sex" class="form-label">Sex *</label>
                                <select class="form-control @error('pet_sex') is-invalid @enderror" id="pet_sex" name="pet_sex" required>
                                    <option value="">Select Sex</option>
                                    <option value="male" {{ old('pet_sex', $report->pet_sex ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('pet_sex', $report->pet_sex ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('pet_sex')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="color_markings" class="form-label">Color/Markings (Optional)</label>
                            <input type="text" class="form-control @error('color_markings') is-invalid @endreed' name="color_markings" value="{{ old('color_markings', $report->color_markings ?? '') }}">
                            @error('color_markings')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight (kg) (Optional)</label>
                            <input type="number" step="0.01" class="form-control @error('weight') is-invalid @endreed' id="weight" name="weight" min="0" value="{{ old('weight', $report->weight ?? '') }}">
                            @error('weight')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Owner Information -->
                    <div class="col-md-6 mb-3">
                        <h5 class="text-primary mb-3">Owner Information</h5>
                        
                        <div class="mb-3">
                            <label for="owner_name" class="form-label">Owner Name *</label>
                            <input type="text" class="form-control @error('owner_name') is-invalid @endreed' id="owner_name" name="owner_name" required value="{{ old('owner_name', $report->owner_name ?? '') }}">
                            @error('owner_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="owner_contact" class="form-label">Contact Number (Optional)</label>
                            <input type="text" class="form-control @error('owner_contact') is-invalid @endreed' id="owner_contact" name="owner_contact" value="{{ old('owner_contact', $report->owner_contact ?? '') }}">
                            @error('owner_contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="owner_address" class="form-label">Address (Optional)</label>
                            <textarea class="form-control @error('owner_address') is-invalid @endreed' id="owner_address" name="owner_address" rows="3">{{ old('owner_address', $report->owner_address ?? '') }}</textarea>
                            @error('owner_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="barangay" class="form-label">Barangay (Optional)</label>
                            <input type="text" class="form-control @error('barangay') is-invalid @endreed' id="barangay" name="barangay" value="{{ old('barangay', $report->barangay ?? '') }}">
                            @error('barangay')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Procedure Information -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h5 class="text-primary mb-3">Procedure Information</h5>
                        
                        <div class="mb-3">
                            <label for="procedure_type" class="form-label">Procedure Type *</label>
                            <select class="form-control @error('procedure_type') is-invalid @endreed' id="procedure_type" name="procedure_type" required>
                                <option value="">Select Procedure</option>
                                <option value="spay" {{ old('procedure_type', $report->procedure_type ?? '') == 'spay' ? 'selected' : '' }}>Spay (Female)</option>
                                <option value="neuter" {{ old('procedure_type', $report->procedure_type ?? '') == 'neuter' ? 'selected' : '' }}>Neuter (Male)</option>
                                <option value="both" {{ old('procedure_type', $report->procedure_type ?? '') == 'both' ? 'selected' : '' }}>Both</option>
                            </select>
                            @error('procedure_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="procedure_date" class="form-label">Procedure Date *</label>
                            <input type="date" class="form-control @error('procedure_date') is-invalid @endreed' id="procedure_date" name="procedure_date" required value="{{ old('procedure_date', isset($report) ? $report->procedure_date->format('Y-m-d') : date('Y-m-d')) }}">
                            @error('procedure_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="veterinarian" class="form-label">Veterinarian (Optional)</label>
                            <input type="text" class="form-control @error('veterinarian') is-invalid @endreed' id="veterinarian" name="veterinarian" value="{{ old('veterinarian', $report->veterinarian ?? '') }}">
                            @error('veterinarian')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="clinic_name" class="form-label">Clinic Name (Optional)</label>
                            <input type="text" class="form-control @error('clinic_name') is-invalid @endreed' id="clinic_name" name="clinic_name" value="{{ old('clinic_name', $report->clinic_name ?? '') }}">
                            @error('clinic_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <h5 class="text-primary mb-3">Status & Remarks</h5>
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control @error('status') is-invalid @endreed' id="status" name="status">
                                <option value="pending" {{ old('status', $report->status ?? 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="scheduled" {{ old('status', $report->status ?? '') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="completed" {{ old('status', $report->status ?? '') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status', $report->status ?? '') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks (Optional)</label>
                            <textarea class="form-control @error('remarks') is-invalid @endreed' id="remarks" name="remarks" rows="4">{{ old('remarks', $report->remarks ?? '') }}</textarea>
                            @error('remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('spay-neuter.reports.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ isset($report) ? 'Update Report' : 'Submit Report' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
