@extends('layouts.admin')

@section('title', 'Rabies Cases')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Rabies Cases</h1>
        <a href="{{ route('rabies-cases.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Case
        </a>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('rabies-cases.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="case_type" class="form-label">Case Type</label>
                    <select name="case_type" id="case_type" class="form-select">
                        <option value="">All Types</option>
                        <option value="positive" {{ request('case_type') == 'positive' ? 'selected' : '' }}>Positive</option>
                        <option value="probable" {{ request('case_type') == 'probable' ? 'selected' : '' }}>Probable</option>
                        <option value="suspect" {{ request('case_type') == 'suspect' ? 'selected' : '' }}>Suspect</option>
                        <option value="negative" {{ request('case_type') == 'negative' ? 'selected' : '' }}>Negative</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                        <option value="under_investigation" {{ request('status') == 'under_investigation' ? 'selected' : '' }}>Under Investigation</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="barangay_id" class="form-label">Barangay</label>
                    <select name="barangay_id" id="barangay_id" class="form-select">
                        <option value="">All Barangays</option>
                        @foreach($barangays as $id => $name)
                            <option value="{{ $id }}" {{ request('barangay_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Cases Table -->
    <div class="card">
        <div class="card-body">
            @if($cases->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Case No.</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Species</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cases as $case)
                                <tr>
                                    <td>{{ $case->case_number }}</td>
                                    <td>{{ $case->incident_date->format('M d, Y') }}</td>
                                    <td>
                                        @switch($case->case_type)
                                            @case('positive')
                                                <span class="badge bg-danger">Positive</span>
                                                @break
                                            @case('probable')
                                                <span class="badge bg-warning">Probable</span>
                                                @break
                                            @case('suspect')
                                                <span class="badge bg-info">Suspect</span>
                                                @break
                                            @case('negative')
                                                <span class="badge bg-secondary">Negative</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>{{ ucfirst($case->species) }}</td>
                                    <td>{{ $case->incident_location ?? 'N/A' }}</td>
                                    <td>
                                        @switch($case->status)
                                            @case('open')
                                                <span class="badge bg-primary">Open</span>
                                                @break
                                            @case('closed')
                                                <span class="badge bg-success">Closed</span>
                                                @break
                                            @case('under_investigation')
                                                <span class="badge bg-warning">Under Investigation</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('rabies-cases.show', $case) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('rabies-cases.edit', $case) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('rabies-cases.destroy', $case) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this case?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $cases->links() }}
            @else
                <div class="text-center py-4">
                    <i class="fas fa-exclamation-triangle fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No rabies cases found.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
