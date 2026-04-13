@extends('layouts.admin')

@section('title', 'Establishment Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $establishment->name }}</h1>
        <div>
            <a href="{{ route('establishments.edit', $establishment) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('establishments.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Establishment Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Type</label>
                            <p class="mb-0">
                                @switch($establishment->type)
                                    @case('meat_shop')
                                        <span class="badge bg-danger">Meat Shop</span>
                                        @break
                                    @case('poultry')
                                        <span class="badge bg-warning">Poultry</span>
                                        @break
                                    @case('pet_shop')
                                        <span class="badge bg-info">Pet Shop</span>
                                        @break
                                    @case('vet_clinic')
                                        <span class="badge bg-success">Vet Clinic</span>
                                        @break
                                    @case('livestock_facility')
                                        <span class="badge bg-secondary">Livestock Facility</span>
                                        @break
                                    @default
                                        <span class="badge bg-light text-dark">Other</span>
                                @endswitch
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Status</label>
                            <p class="mb-0">
                                @switch($establishment->status)
                                    @case('active')
                                        <span class="badge bg-success">Active</span>
                                        @break
                                    @case('inactive')
                                        <span class="badge bg-secondary">Inactive</span>
                                        @break
                                    @case('suspended')
                                        <span class="badge bg-danger">Suspended</span>
                                        @break
                                    @case('pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @break
                                    @default
                                        <span class="badge bg-light text-dark">{{ $establishment->status }}</span>
                                @endswitch
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Permit Number</label>
                            <p class="mb-0">{{ $establishment->permit_no ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Owner</label>
                            <p class="mb-0">{{ $establishment->owner_name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Contact Number</label>
                            <p class="mb-0">{{ $establishment->contact_number ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Barangay</label>
                            <p class="mb-0">{{ $establishment->barangay->barangay_name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Address</label>
                        <p class="mb-0">{{ $establishment->address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">System Information</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Created:</strong> {{ $establishment->created_at->format('M d, Y h:i A') }}</p>
                    <p class="mb-0"><strong>Updated:</strong> {{ $establishment->updated_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
