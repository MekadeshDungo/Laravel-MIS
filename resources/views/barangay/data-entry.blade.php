@extends('layouts.admin')

@section('title', 'Data Entry')

@section('breadcrumb')
    <li class="breadcrumb-item active">Data Entry</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">
                <i class="bi bi-pencil-square me-2"></i>Data Entry
            </h2>
            <p class="text-muted">Submit new reports and records for your barangay.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <a href="{{ route('barangay.reports.create') }}" class="text-decoration-none">
                <div class="card bg-warning text-dark h-100 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-exclamation-triangle fs-1"></i>
                        <h4 class="mt-3">Stray Report</h4>
                        <p class="mb-0">Report stray, nuisance, or injured animals</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white h-100 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-box-seam fs-1"></i>
                    <h4 class="mt-3">Impound Record</h4>
                    <p class="mb-0">Record impounded animals</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white h-100 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-heart-fill fs-1"></i>
                    <h4 class="mt-3">Adoption Request</h4>
                    <p class="mb-0">Process adoption requests</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>Quick Guide
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h6 class="text-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i>Stray Report
                            </h6>
                            <ul class="text-muted">
                                <li>Use for reporting stray animals</li>
                                <li>Use for nuisance complaints</li>
                                <li>Use for injured animal reports</li>
                                <li>Include location details</li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-info">
                                <i class="bi bi-box-seam me-2"></i>Impound Record
                            </h6>
                            <ul class="text-muted">
                                <li>Record when animals are impounded</li>
                                <li>Track intake condition</li>
                                <li>Update disposition status</li>
                                <li>Link to original report</li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-success">
                                <i class="bi bi-heart-fill me-2"></i>Adoption Request
                            </h6>
                            <ul class="text-muted">
                                <li>Process adoption applications</li>
                                <li>Review adopter information</li>
                                <li>Track approval status</li>
                                <li>Complete adoptions</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
