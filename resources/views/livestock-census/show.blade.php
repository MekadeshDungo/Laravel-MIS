@extends('layouts.admin')

@section('title', 'Livestock Census Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            {{ ucfirst($census->species) }} - {{ $census->report_year }}
        </h1>
        <div>
            <a href="{{ route('livestock-census.edit', $census) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('livestock-census.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Census Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="text-muted">Species</label>
                    <p class="mb-0 fw-bold">{{ ucfirst($census->species) }}</p>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="text-muted">Report Period</label>
                    <p class="mb-0">{{ \Carbon\Carbon::create()->month($census->report_month)->format('F') }} {{ $census->report_year }}</p>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="text-muted">Number of Heads</label>
                    <p class="mb-0 fw-bold">{{ number_format($census->no_of_heads) }}</p>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="text-muted">Number of Farmers</label>
                    <p class="mb-0">{{ number_format($census->no_of_farmers) }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="text-muted">Barangay</label>
                    <p class="mb-0">{{ $census->barangay->barangay_name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-muted">Encoded By</label>
                    <p class="mb-0">{{ $census->user->name ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">System Information</h5>
        </div>
        <div class="card-body">
            <p class="mb-2"><strong>Created:</strong> {{ $census->created_at->format('M d, Y h:i A') }}</p>
            <p class="mb-0"><strong>Updated:</strong> {{ $census->updated_at->format('M d, Y h:i A') }}</p>
        </div>
    </div>
</div>
@endsection
