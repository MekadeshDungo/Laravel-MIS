@extends('layouts.admin')

@section('title', 'Edit Livestock Census')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Livestock Census Record</h1>
        <a href="{{ route('livestock-census.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('livestock-census.update', $census) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="species" class="form-label">Species *</label>
                        <select name="species" id="species" class="form-select @error('species') is-invalid @enderror" required>
                            <option value="">Select Species</option>
                            <option value="cattle" {{ old('species', $census->species) == 'cattle' ? 'selected' : '' }}>Cattle</option>
                            <option value="carabao" {{ old('species', $census->species) == 'carabao' ? 'selected' : '' }}>Carabao</option>
                            <option value="swine" {{ old('species', $census->species) == 'swine' ? 'selected' : '' }}>Swine</option>
                            <option value="horse" {{ old('species', $census->species) == 'horse' ? 'selected' : '' }}>Horse</option>
                            <option value="goat" {{ old('species', $census->species) == 'goat' ? 'selected' : '' }}>Goat</option>
                            <option value="dog" {{ old('species', $census->species) == 'dog' ? 'selected' : '' }}>Dog</option>
                            <option value="pigeon" {{ old('species', $census->species) == 'pigeon' ? 'selected' : '' }}>Pigeon</option>
                        </select>
                        @error('species')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="barangay_id" class="form-label">Barangay</label>
                        <select name="barangay_id" id="barangay_id" class="form-select @error('barangay_id') is-invalid @endreq">
                            <option value="">Select Barangay</option>
                            @foreach($barangays as $barangay)
                                <option value="{{ $barangay->id }}" {{ old('barangay_id', $census->barangay_id) == $barangay->id ? 'selected' : '' }}>{{ $barangay->barangay_name }}</option>
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
                        <select name="report_year" id="report_year" class="form-select @error('report_year') is-invalid @endreq" required>
                            @for($y = date('Y'); $y >= 2000; $y--)
                                <option value="{{ $y }}" {{ old('report_year', $census->report_year) == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                        @error('report_year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="report_month" class="form-label">Report Month *</label>
                        <select name="report_month" id="report_month" class="form-select @error('report_month') is-invalid @endreq" required>
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ old('report_month', $census->report_month) == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                            @endfor
                        </select>
                        @error('report_month')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="no_of_heads" class="form-label">Number of Heads *</label>
                        <input type="number" name="no_of_heads" id="no_of_heads" class="form-control @error('no_of_heads') is-invalid @endreq" value="{{ old('no_of_heads', $census->no_of_heads) }}" min="0" required>
                        @error('no_of_heads')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="no_of_farmers" class="form-label">Number of Farmers *</label>
                    <input type="number" name="no_of_farmers" id="no_of_farmers" class="form-control @error('no_of_farmers') is-invalid @endreq" value="{{ old('no_of_farmers', $census->no_of_farmers) }}" min="0" required>
                    @error('no_of_farmers')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
