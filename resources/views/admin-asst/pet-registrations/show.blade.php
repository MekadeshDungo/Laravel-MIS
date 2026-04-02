@extends('layouts.admin')

@section('title', 'Pet Registration Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-paw me-2"></i>Pet Registration Details</h2>
        <div>
            @if(!$pet->license_number)
                <form action="{{ route('admin-asst.pet-registrations.approve', $pet) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success me-2" onclick="return confirm('Approve and issue license for this pet?')">
                        <i class="fas fa-check-circle me-2"></i>Approve & Issue License
                    </button>
                </form>
            @endif
            <a href="{{ route('admin-asst.pet-registrations.edit', $pet) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <a href="{{ route('admin-asst.pet-registrations.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Pet Details -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ $pet->name }}</h4>
                        @if($pet->license_number)
                            <span class="badge bg-success fs-6">
                                <i class="fas fa-certificate me-1"></i> {{ $pet->license_number }}
                            </span>
                        @else
                            <span class="badge bg-warning fs-6">Pending Registration</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted" style="width: 150px;">Species:</td>
                                    <td><strong>{{ ucfirst($pet->species) }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Breed:</td>
                                    <td>{{ $pet->breed }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Gender:</td>
                                    <td>{{ ucfirst($pet->gender) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Age:</td>
                                    <td>{{ $pet->age ?? 'Not specified' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Weight:</td>
                                    <td>{{ $pet->weight ? $pet->weight . ' kg' : 'Not specified' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Color:</td>
                                    <td>{{ $pet->color ?? 'Not specified' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted" style="width: 150px;">Vaccination:</td>
                                    <td>
                                        @if($pet->vaccination_status)
                                            <span class="badge bg-{{ $pet->vaccination_status == 'up_to_date' ? 'success' : ($pet->vaccination_status == 'partial' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst(str_replace('_', ' ', $pet->vaccination_status)) }}
                                            </span>
                                        @else
                                            <span class="text-muted">Not specified</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Health Status:</td>
                                    <td>{{ $pet->health_status ?? 'Not specified' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">License #:</td>
                                    <td>{{ $pet->license_number ?? 'Not issued' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">License Expiry:</td>
                                    <td>{{ $pet->license_expiry ? $pet->license_expiry->format('M d, Y') : 'Not applicable' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Microchip #:</td>
                                    <td>{{ $pet->microchip_number ?? 'Not assigned' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Registered:</td>
                                    <td>{{ $pet->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($pet->medical_history)
                        <hr>
                        <h6 class="text-muted mb-2">Medical History</h6>
                        <p class="mb-0">{{ $pet->medical_history }}</p>
                    @endif

                    @if($pet->notes)
                        <hr>
                        <h6 class="text-muted mb-2">Notes</h6>
                        <p class="mb-0">{{ $pet->notes }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Pet Photo -->
            @if($pet->photo_url)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="fas fa-camera me-2"></i>Pet Photo</h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ asset('storage/' . $pet->photo_url) }}" alt="{{ $pet->name }}" class="img-fluid rounded" style="max-height: 250px;">
                    </div>
                </div>
            @endif

            <!-- Owner Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Owner Information</h5>
                </div>
                <div class="card-body">
                    @if($pet->userOwner)
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="text-muted">Name:</td>
                                <td><strong>{{ $pet->userOwner->name }}</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Email:</td>
                                <td>{{ $pet->userOwner->email }}</td>
                            </tr>
                            @if($pet->userOwner->phone)
                                <tr>
                                    <td class="text-muted">Phone:</td>
                                    <td>{{ $pet->userOwner->phone }}</td>
                                </tr>
                            @endif
                        </table>
                    @else
                        <p class="text-muted mb-0">Owner information not available</p>
                    @endif
                </div>
            </div>

            <!-- Location Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Location</h5>
                </div>
                <div class="card-body">
                    @if($pet->barangay)
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="text-muted">Barangay:</td>
                                <td><strong>{{ $pet->barangay->barangay_name }}</strong></td>
                            </tr>
                        </table>
                    @else
                        <p class="text-muted mb-0">Location not specified</p>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin-asst.pet-registrations.destroy', $pet) }}" onsubmit="return confirm('Are you sure you want to delete this pet registration? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash me-2"></i>Delete Registration
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
