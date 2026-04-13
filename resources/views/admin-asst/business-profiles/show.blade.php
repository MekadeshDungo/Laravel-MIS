@extends('layouts.admin')

@section('title', 'Business Profile Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-building me-2"></i>Business Profile Details</h2>
        <div>
            @if($businessProfile->status == 'pending')
                <form action="{{ route('admin-asst.business-profiles.approve', $businessProfile) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success me-2" onclick="return confirm('Approve this business profile?')">
                        <i class="fas fa-check-circle me-2"></i>Approve
                    </button>
                </form>
            @endif
            @if($businessProfile->status == 'active')
                <form action="{{ route('admin-asst.business-profiles.suspend', $businessProfile) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger me-2" onclick="return confirm('Suspend this business profile?')">
                        <i class="fas fa-ban me-2"></i>Suspend
                    </button>
                </form>
            @endif
            <a href="{{ route('admin-asst.business-profiles.edit', $businessProfile) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <a href="{{ route('admin-asst.business-profiles.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Business Details -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ $businessProfile->name }}</h4>
                        @if($businessProfile->status == 'active')
                            <span class="badge bg-success fs-6">Active</span>
                        @elseif($businessProfile->status == 'pending')
                            <span class="badge bg-warning fs-6">Pending</span>
                        @elseif($businessProfile->status == 'suspended')
                            <span class="badge bg-danger fs-6">Suspended</span>
                        @else
                            <span class="badge bg-secondary fs-6">{{ ucfirst($businessProfile->status) }}</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted" style="width: 150px;">Permit Number:</td>
                                    <td><code class="fs-6">{{ $businessProfile->permit_no ?? 'Not assigned' }}</code></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Business Type:</td>
                                    <td>
                                        @if($businessProfile->type == 'poultry')
                                            <span class="badge bg-warning"><i class="fas fa-egg me-1"></i>Poultry Farm</span>
                                        @elseif($businessProfile->type == 'livestock_facility')
                                            <span class="badge bg-success"><i class="fas fa-cow me-1"></i>Livestock Facility</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $businessProfile->type)) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Capacity:</td>
                                    <td>{{ $businessProfile->capacity ?? 'Not specified' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Operations Start:</td>
                                    <td>{{ $businessProfile->operations_start ? $businessProfile->operations_start->format('M d, Y') : 'Not specified' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted" style="width: 150px;">Address:</td>
                                    <td>{{ $businessProfile->address }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Barangay:</td>
                                    <td>{{ $businessProfile->barangay ? $businessProfile->barangay->barangay_name : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Registered:</td>
                                    <td>{{ $businessProfile->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Last Updated:</td>
                                    <td>{{ $businessProfile->updated_at->format('M d, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($businessProfile->notes)
                        <hr>
                        <h6 class="text-muted mb-2">Notes</h6>
                        <p class="mb-0">{{ $businessProfile->notes }}</p>
                    @endif
                </div>
            </div>

            <!-- Owner Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Owner Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" style="width: 150px;">Owner Name:</td>
                            <td><strong>{{ $businessProfile->owner_name }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Contact Number:</td>
                            <td>{{ $businessProfile->contact_number ?? 'Not provided' }}</td>
                        </tr>
                        @if($businessProfile->owner_email)
                            <tr>
                                <td class="text-muted">Email:</td>
                                <td>{{ $businessProfile->owner_email }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Summary -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Summary</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted">Profile ID:</td>
                            <td><strong>#{{ $businessProfile->id }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Status:</td>
                            <td>
                                @if($businessProfile->status == 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif($businessProfile->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($businessProfile->status == 'suspended')
                                    <span class="badge bg-danger">Suspended</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($businessProfile->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Recorded By:</td>
                            <td>{{ $businessProfile->user ? $businessProfile->user->name : 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Actions</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin-asst.business-profiles.destroy', $businessProfile) }}" onsubmit="return confirm('Are you sure you want to delete this business profile? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash me-2"></i>Delete Profile
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
