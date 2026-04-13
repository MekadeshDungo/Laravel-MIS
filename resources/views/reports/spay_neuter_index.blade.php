@extends('layouts.admin')

@section('title', 'Spay/Neuter Reports')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Spay/Neuter Reports</h1>
        <a href="{{ route('spay-neuter.reports.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Report
        </a>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('spay-neuter.reports.index') }}" class="row g-3">
                <div class="col-md-2">
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="procedure_type" class="form-control">
                        <option value="">All Procedures</option>
                        <option value="spay" {{ request('procedure_type') == 'spay' ? 'selected' : '' }}>Spay</option>
                        <option value="neuter" {{ request('procedure_type') == 'neuter' ? 'selected' : '' }}>Neuter</option>
                        <option value="both" {{ request('procedure_type') == 'both' ? 'selected' : '' }}>Both</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="pet_type" class="form-control">
                        <option value="">All Pets</option>
                        <option value="dog" {{ request('pet_type') == 'dog' ? 'selected' : '' }}>Dog</option>
                        <option value="cat" {{ request('pet_type') == 'cat' ? 'selected' : '' }}>Cat</option>
                        <option value="other" {{ request('pet_type') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" placeholder="Start Date">
                </div>
                <div class="col-md-2">
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" placeholder="End Date">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Owner Name</th>
                        <th>Pet Type</th>
                        <th>Procedure</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                    <tr>
                        <td>{{ $report->procedure_date->format('M d, Y') }}</td>
                        <td>{{ $report->owner_name }}</td>
                        <td>{{ ucfirst($report->pet_type) }}</td>
                        <td>
                            @if($report->procedure_type == 'spay')
                            <span class="badge bg-primary">Spay (F)</span>
                            @elseif($report->procedure_type == 'neuter')
                            <span class="badge bg-info">Neuter (M)</span>
                            @else
                            <span class="badge bg-success">Both</span>
                            @endif
                        </td>
                        <td>
                            @if($report->status == 'completed')
                            <span class="badge bg-success">Completed</span>
                            @elseif($report->status == 'scheduled')
                            <span class="badge bg-info">Scheduled</span>
                            @elseif($report->status == 'cancelled')
                            <span class="badge bg-danger">Cancelled</span>
                            @else
                            <span class="badge bg-warning">Pending</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('spay-neuter.reports.show', $report->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('spay-neuter.reports.edit', $report->id) }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('spay-neuter.reports.destroy', $report->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $reports->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
