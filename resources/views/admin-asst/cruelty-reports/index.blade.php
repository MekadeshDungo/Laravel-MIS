@extends('layouts.admin')

@section('title', 'Cruelty Assessment Reports')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Cruelty Assessment Reports</h2>
        <a href="{{ route('admin-asst.cruelty-reports.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Report
        </a>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Report # or location..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Violation Type</label>
                    <select name="violation_type" class="form-select">
                        <option value="">All Types</option>
                        @foreach(\App\Models\CrueltyReport::VIOLATION_TYPES as $key => $label)
                            <option value="{{ $key }}" {{ request('violation_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        @foreach(\App\Models\CrueltyReport::STATUSES as $key => $label)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Barangay</label>
                    <select name="barangay_id" class="form-select">
                        <option value="">All</option>
                        @foreach($barangays as $barangay)
                            <option value="{{ $barangay->barangay_id }}" {{ request('barangay_id') == $barangay->barangay_id ? 'selected' : '' }}>
                                {{ $barangay->barangay_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-secondary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Report #</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Violation</th>
                            <th>Animals</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                            <tr>
                                <td>{{ $report->report_number }}</td>
                                <td>{{ \Carbon\Carbon::parse($report->incident_date)->format('M d, Y') }}</td>
                                <td>{{ $report->location }}</td>
                                <td>
                                    <span class="badge bg-danger">
                                        {{ \App\Models\CrueltyReport::VIOLATION_TYPES[$report->violation_type] ?? $report->violation_type }}
                                    </span>
                                </td>
                                <td>{{ $report->animal_count }}</td>
                                <td>
                                    <span class="badge bg-{{ $report->status == 'pending' ? 'warning' : ($report->status == 'investigating' ? 'info' : 'success') }}">
                                        {{ \App\Models\CrueltyReport::STATUSES[$report->status] ?? $report->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin-asst.cruelty-reports.show', $report) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin-asst.cruelty-reports.edit', $report) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No reports found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $reports->links() }}
            </div>
        </div>
    </div>
</div>
@endsection