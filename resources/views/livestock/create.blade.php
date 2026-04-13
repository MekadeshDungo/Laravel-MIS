@extends('layouts.admin')

@section('title', 'Add Livestock Record')
@section('header', 'Add Livestock Record')
@section('subheader', 'Capture barangay-based poultry and livestock census entries.')

@section('content')
<div class="mx-auto max-w-4xl rounded-3xl border border-green-100 bg-white p-8 shadow-sm">
    <div class="mb-8 flex items-start justify-between gap-4">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-green-700">Livestock Census</p>
            <h1 class="mt-2 text-2xl font-bold text-slate-900">Create Livestock Record</h1>
        </div>
        <a href="{{ route('livestock.index') }}" class="rounded-xl border border-slate-300 px-4 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Back to list</a>
    </div>

    <form action="{{ route('livestock.store') }}" method="POST">
        @csrf
        @include('livestock._form', ['submitLabel' => 'Save Record'])
    </form>
</div>
@endsection
