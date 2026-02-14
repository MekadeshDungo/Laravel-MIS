@extends('layouts.admin')

@section('title', 'Livestock Census')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Livestock Census</h1>
        <a href="{{ route('livestock-census.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Census Record
        </a>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('livestock-census.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="species" class="form-label">Species</label>
                    <select name="species" id="species" class="form-select">
                        <option value="">All Species</option>
                        <option value="cattle" {{ request('species') == 'cattle' ? 'selected' : '' }}>Cattle</option>
                        <option value="carabao" {{ request('species') == 'carabao' ? 'selected' : '' }}>Carabao</option>
                        <option value="swine" {{ request('species') == 'swine' ? 'selected' : '' }}>Swine</option>
                        <option value="horse" {{ request('species') == 'horse' ? 'selected' : '' }}>Horse</option>
                        <option value="goat" {{ request('species') == 'goat' ? 'selected' : '' }}>Goat</option>
                        <option value="dog" {{ request('species') == 'dog' ? 'selected' : '' }}>Dog</option>
                        <option value="pigeon" {{ request('species') == 'pigeon' ? 'selected' : '' }}>Pigeon</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="year" class="form-label">Year</label>
                    <select name="year" id="year" class="form-select">
                        <option value="">All Years</option>
                        @foreach($years as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="barangay_id" class="form-label">Barangay</label>
                    <select name="barangay_id" id="barangay_id" class="form-select">
                        <option value="">All Barangays</option>
                        @foreach($barangays as $barangay)
                            <option value="{{ $barangay->id }}" {{ request('barangay_id') == $barangay->id ? 'selected' : '' }}>{{ $barangay->barangay_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Census Table -->
    <div class="card">
        <div class="card-body">
            @if($censuses->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Year</th>
                                <th>Month</th>
                                <th>Species</th>
                                <th>No. of Heads</th>
                                <th>No. of Farmers</th>
                                <th>Barangay</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($censuses as $census)
                                <tr>
                                    <td>{{ $census->report_year }}</td>
                                    <td>{{ \Carbon\Carbon::create()->month($census->report_month)->format('F') }}</td>
                                    <td>{{ ucfirst($census->species) }}</td>
                                    <td>{{ number_format($census->no_of_heads) }}</td>
                                    <td>{{ number_format($census->no_of_farmers) }}</td>
                                    <td>{{ $census->barangay->barangay_name ?? 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('livestock-census.show', $census) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('livestock-census.edit', $census) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('livestock-census.destroy', $census) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">
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
                {{ $censuses->links() }}
            @else
                <div class="text-center py-4">
                    <i class="fas fa-paw fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No livestock census records found.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
