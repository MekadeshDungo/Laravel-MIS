@extends('layouts.admin')

@section('title', 'Admin Assistant Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-tachometer-alt me-2"></i>Admin Assistant Dashboard</h2>
        <span class="text-muted">Welcome back! {{ auth()->user()->name }}</span>
    </div>

    <!-- Statistics Cards Row 1 -->
    <div class="row g-3 mb-4">
        <!-- Pet Registration Stats -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Pets</h6>
                            <h3 class="mb-0">{{ $totalPets }}</h3>
                        </div>
                        <div class="icon-circle bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-paw fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-warning">{{ $pendingPetRegistrations }}</span>
                        <small class="text-muted">Pending Registration</small>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('admin-asst.pet-registrations.index') }}" class="text-primary text-decoration-none small">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Appointment Stats -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Service Requests</h6>
                            <h3 class="mb-0">{{ $pendingAppointments }}</h3>
                        </div>
                        <div class="icon-circle bg-success bg-opacity-10 text-success">
                            <i class="fas fa-calendar-check fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-info">{{ $todayAppointments }}</span>
                        <small class="text-muted">Submitted Today</small>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('admin-asst.appointments.index') }}" class="text-success text-decoration-none small">
                        Manage Requests <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Cruelty Reports Stats -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Cruelty Reports</h6>
                            <h3 class="mb-0">{{ $totalCrueltyReports }}</h3>
                        </div>
                        <div class="icon-circle bg-danger bg-opacity-10 text-danger">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-danger">{{ $pendingCrueltyReports }}</span>
                        <small class="text-muted">Pending Action</small>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('admin-asst.cruelty-reports.index') }}" class="text-danger text-decoration-none small">
                        Review Reports <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Inventory Stats -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Inventory Items</h6>
                            <h3 class="mb-0">{{ $totalInventoryItems }}</h3>
                        </div>
                        <div class="icon-circle bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-boxes fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-danger">{{ $lowStockItems }}</span>
                        <small class="text-muted">Low Stock</small>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('admin-asst.inventory.low-stock') }}" class="text-warning text-decoration-none small">
                        View Alerts <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards Row 2 -->
    <div class="row g-3 mb-4">
        <!-- Adoption Stats -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Adoption Requests</h6>
                            <h3 class="mb-0">{{ $totalAdoptions }}</h3>
                        </div>
                        <div class="icon-circle bg-info bg-opacity-10 text-info">
                            <i class="fas fa-heart fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-warning">{{ $pendingAdoptions }}</span>
                        <small class="text-muted">Pending Review</small>
                        <span class="badge bg-success ms-2">{{ $approvedAdoptions }}</span>
                        <small class="text-muted">Approved</small>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('admin-asst.adoptions.index') }}" class="text-info text-decoration-none small">
                        Manage Adoptions <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Impound Stats -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Impounded Animals</h6>
                            <h3 class="mb-0">{{ $totalImpounds }}</h3>
                        </div>
                        <div class="icon-circle bg-secondary bg-opacity-10 text-secondary">
                            <i class="fas fa-shelter fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-info">{{ $availableForAdoption }}</span>
                        <small class="text-muted">Available for Adoption</small>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('admin-asst.impounds.index') }}" class="text-secondary text-decoration-none small">
                        View Impounds <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Expiring Items -->
        <div class="col-xl-4 col-md-12">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Expiring Items (30 days)</h6>
                            <h3 class="mb-0">{{ $expiringItems }}</h3>
                        </div>
                        <div class="icon-circle bg-dark bg-opacity-10 text-dark">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">Items expiring soon - review and use accordingly</small>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('admin-asst.inventory.index') }}" class="text-dark text-decoration-none small">
                        Check Inventory <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="row g-4">
        <!-- Recent Pet Registrations -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-paw me-2 text-primary"></i>Recent Pet Registrations</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Pet Name</th>
                                    <th>Species</th>
                                    <th>Owner</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPetRegistrations as $pet)
                                <tr>
                                    <td>{{ $pet->name }}</td>
                                    <td><span class="badge bg-secondary">{{ ucfirst($pet->species) }}</span></td>
                                    <td>{{ $pet->userOwner ? $pet->userOwner->name : 'N/A' }}</td>
                                    <td>
                                        @if($pet->license_number)
                                            <span class="badge bg-success">Registered</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No recent registrations</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Cruelty Reports -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-exclamation-circle me-2 text-danger"></i>Recent Cruelty Reports</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Report #</th>
                                    <th>Location</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentCrueltyReports as $report)
                                <tr>
                                    <td>{{ $report->report_number }}</td>
                                    <td>{{ Str::limit($report->location, 20) }}</td>
                                    <td>{{ $report->violation_type }}</td>
                                    <td>
                                        <span class="badge bg-{{ $report->status == 'pending' ? 'warning' : ($report->status == 'resolved' ? 'success' : 'secondary') }}">
                                            {{ ucfirst($report->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No recent reports</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Adoption Requests -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-heart me-2 text-info"></i>Recent Adoption Requests</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Adopter</th>
                                    <th>Contact</th>
                                    <th>Request Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentAdoptions as $adoption)
                                <tr>
                                    <td>{{ $adoption->adopter_name }}</td>
                                    <td>{{ $adoption->adopter_contact }}</td>
                                    <td>{{ $adoption->requested_at->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $adoption->request_status == 'pending' ? 'warning' : ($adoption->request_status == 'approved' ? 'success' : ($adoption->request_status == 'rejected' ? 'danger' : 'info')) }}">
                                            {{ ucfirst($adoption->request_status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No recent adoption requests</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Service Submissions -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-file-alt me-2 text-success"></i>Recent Service Submissions</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Citizen</th>
                                    <th>Form Type</th>
                                    <th>Submitted</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentSubmissions as $submission)
                                <tr>
                                    <td>{{ $submission->citizen_name }}</td>
                                    <td>{{ $submission->form ? $submission->form->title : 'N/A' }}</td>
                                    <td>{{ $submission->submitted_at ? $submission->submitted_at->format('M d, Y') : 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $submission->status == 'pending' ? 'warning' : ($submission->status == 'approved' ? 'success' : ($submission->status == 'rejected' ? 'danger' : 'secondary')) }}">
                                            {{ ucfirst($submission->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No recent submissions</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-primary bg-opacity-5">
                <div class="card-body">
                    <h5 class="mb-3"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('admin-asst.pet-registrations.create') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-plus-circle me-2"></i>Register New Pet
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin-asst.cruelty-reports.create') }}" class="btn btn-outline-danger w-100">
                                <i class="fas fa-flag me-2"></i>File Cruelty Report
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin-asst.inventory.create') }}" class="btn btn-outline-warning w-100">
                                <i class="fas fa-box-open me-2"></i>Add Inventory Item
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin-asst.appointments.index') }}" class="btn btn-outline-success w-100">
                                <i class="fas fa-clipboard-check me-2"></i>Review Requests
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush
