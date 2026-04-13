@extends('layouts.admin')

@section('title', 'Medical & Vaccination Records')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Medical & Vaccination Records</h2>
        <a href="{{ route('admin-staff.medical-records.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Record
        </a>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Animal name or owner..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Record Type</label>
                    <select name="record_type" class="form-select">
                        <option value="">All Types</option>
                        <option value="medical" {{ request('record_type') == 'medical' ? 'selected' : '' }}>Medical</option>
                        <option value="vaccination" {{ request('record_type') == 'vaccination' ? 'selected' : '' }}>Vaccination</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Barangay</label>
                    <select name="barangay_id" class="form-select">
                        <option value="">All Barangays</option>
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

    <!-- Records Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Animal Name</th>
                            <th>Species</th>
                            <th>Owner</th>
                            <th>Barangay</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $record)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($record->record_date)->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $record->record_type == 'medical' ? 'primary' : 'success' }}">
                                        {{ ucfirst($record->record_type) }}
                                    </span>
                                </td>
                                <td>{{ $record->animal_name }}</td>
                                <td>{{ $record->species }}</td>
                                <td>{{ $record->owner_name }}</td>
                                <td>{{ $record->barangay->barangay_name ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('admin-staff.medical-records.show', $record) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin-staff.medical-records.edit', $record) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $records->links() }}
            </div>
        </div>
    </div>
</div>
@endsection