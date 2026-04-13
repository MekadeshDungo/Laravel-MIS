@extends('layouts.admin')

@section('title', 'Add Livestock Census')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add Livestock Census Record</h1>
        <a href="{{ route('livestock-census.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('livestock-census.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="species" class="form-label">Species *</label>
                        <select name="species" id="species" class="form-select @error('species') is-invalid @enderror" required>
                            <option value="">Select Species</option>
                            <option value="cattle" {{ old('species') == 'cattle' ? 'selected' : '' }}>Cattle</option>
                            <option value="carabao" {{ old('species') == 'carabao' ? 'selected' : '' }}>Carabao</option>
                            <option value="swine" {{ old('species') == 'swine' ? 'selected' : '' }}>Swine</option>
                            <option value="horse" {{ old('species') == 'horse' ? 'selected' : '' }}>Horse</option>
                            <option value="goat" {{ old('species') == 'goat' ? 'selected' : '' }}>Goat</option>
                            <option value="dog" {{ old('species') == 'dog' ? 'selected' : '' }}>Dog</option>
                            <option value="pigeon" {{ old('species') == 'pigeon' ? 'selected' : '' }}>Pigeon</option>
                        </select>
                        @error('species')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="barangay_id" class="form-label">Barangay</label>
                        <select name="barangay_id" id="barangay_id" class="form-select @error('barangay_id') is-invalid @enderror">
                            <option value="">Select Barangay</option>
                            @foreach($barangays as $id => $name)
                                <option value="{{ $id }}" {{ old('barangay_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('barangay_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="report_year" class="form-label">Report Year *</label>
                        <select name="report_year" id="report_year" class="form-select @error('report_year') is-invalid @enderror" required>
                            @for($y = date('Y'); $y >= 2000; $y--)
                                <option value="{{ $y }}" {{ old('report_year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                        @error('report_year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="report_month" class="form-label">Report Month *</label>
                        <select name="report_month" id="report_month" class="form-select @error('report_month') is-invalid @enderror" required>
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ old('report_month', date('n')) == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                            @endfor
                        </select>
                        @error('report_month')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="no_of_heads" class="form-label">Number of Heads *</label>
                        <input type="number" name="no_of_heads" id="no_of_heads" class="form-control @error('no_of_heads') is-invalid @enderror" value="{{ old('no_of_heads', 0) }}" min="0" required>
                        @error('no_of_heads')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="no_of_farmers" class="form-label">Number of Farmers *</label>
                    <input type="number" name="no_of_farmers" id="no_of_farmers" class="form-control @error('no_of_farmers') is-invalid @enderror" value="{{ old('no_of_farmers', 0) }}" min="0" required>
                    @error('no_of_farmers')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
