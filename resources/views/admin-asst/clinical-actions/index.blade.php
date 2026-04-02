@extends('layouts.admin')

@section('title', 'Clinical Actions')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Clinical Actions</h2>
        <a href="{{ route('admin-asst.clinical-actions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Action
        </a>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Animal or owner name..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Action Type</label>
                    <select name="action_type" class="form-select">
                        <option value="">All Types</option>
                        @foreach(\App\Models\ClinicalAction::ACTION_TYPES as $key => $label)
                            <option value="{{ $key }}" {{ request('action_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
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

    <!-- Actions Table -->
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
                        @forelse($actions as $action)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($action->action_date)->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge bg-info">{{ \App\Models\ClinicalAction::ACTION_TYPES[$action->action_type] ?? $action->action_type }}</span>
                                </td>
                                <td>{{ $action->animal_name }}</td>
                                <td>{{ $action->species }}</td>
                                <td>{{ $action->owner_name }}</td>
                                <td>{{ $action->barangay->barangay_name ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('admin-asst.clinical-actions.show', $action) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin-asst.clinical-actions.edit', $action) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No clinical actions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $actions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection