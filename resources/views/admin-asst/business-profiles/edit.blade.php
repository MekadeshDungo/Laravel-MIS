@extends('layouts.admin')

@section('title', 'Edit Business Profile')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-edit me-2"></i>Edit Business Profile</h2>
        <a href="{{ route('admin-asst.business-profiles.show', $businessProfile) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin-asst.business-profiles.update', $businessProfile) }}">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Business Information -->
                    <div class="col-md-6">
                        <h5 class="mb-3 text-primary"><i class="fas fa-building me-2"></i>Business Information</h5>
                        
                        <div class="mb-3">
                            <label class="form-label">Business Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $businessProfile->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Business Type <span class="text-danger">*</span></label>
                                <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                    <option value="poultry" {{ old('type', $businessProfile->type) == 'poultry' ? 'selected' : '' }}>🐔 Poultry Farm</option>
                                    <option value="livestock_facility" {{ old('type', $businessProfile->type) == 'livestock_facility' ? 'selected' : '' }}>🐄 Livestock Facility</option>
                                    <option value="meat_shop" {{ old('type', $businessProfile->type) == 'meat_shop' ? 'selected' : '' }}>🥩 Meat Shop</option>
                                    <option value="pet_shop" {{ old('type', $businessProfile->type) == 'pet_shop' ? 'selected' : '' }}>🐾 Pet Shop</option>
                                    <option value="vet_clinic" {{ old('type', $businessProfile->type) == 'vet_clinic' ? 'selected' : '' }}>🏥 Veterinary Clinic</option>
                                    <option value="other" {{ old('type', $businessProfile->type) == 'other' ? 'selected' : '' }}>📋 Other</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Permit Number</label>
                                <input type="text" name="permit_no" class="form-control" value="{{ old('permit_no', $businessProfile->permit_no) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Business Capacity</label>
                                <input type="text" name="capacity" class="form-control" value="{{ old('capacity', $businessProfile->capacity) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Operations Start Date</label>
                                <input type="date" name="operations_start" class="form-control" value="{{ old('operations_start', $businessProfile->operations_start?->format('Y-m-d')) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address <span class="text-danger">*</span></label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2" required>{{ old('address', $businessProfile->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Barangay <span class="text-danger">*</span></label>
                            <select name="barangay_id" class="form-select @error('barangay_id') is-invalid @enderror" required>
                                <option value="">Select Barangay</option>
                                @foreach($barangays as $barangay)
                                    <option value="{{ $barangay->barangay_id }}" {{ old('barangay_id', $businessProfile->barangay_id) == $barangay->barangay_id ? 'selected' : '' }}>
                                        {{ $barangay->barangay_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('barangay_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Owner Information -->
                    <div class="col-md-6">
                        <h5 class="mb-3 text-primary"><i class="fas fa-user me-2"></i>Owner Information</h5>

                        <div class="mb-3">
                            <label class="form-label">Owner Name <span class="text-danger">*</span></label>
                            <input type="text" name="owner_name" class="form-control @error('owner_name') is-invalid @enderror" value="{{ old('owner_name', $businessProfile->owner_name) }}" required>
                            @error('owner_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Contact Number</label>
                                <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number', $businessProfile->contact_number) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="owner_email" class="form-control" value="{{ old('owner_email', $businessProfile->owner_email) }}">
                            </div>
                        </div>

                        <h5 class="mb-3 mt-4 text-primary"><i class="fas fa-cog me-2"></i>Status & Notes</h5>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="pending" {{ old('status', $businessProfile->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="active" {{ old('status', $businessProfile->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $businessProfile->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="suspended" {{ old('status', $businessProfile->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Additional Notes</label>
                            <textarea name="notes" class="form-control" rows="3">{{ old('notes', $businessProfile->notes) }}</textarea>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin-asst.business-profiles.show', $businessProfile) }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Business Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
