@extends('layouts.admin')

@section('title', 'Edit Business Profile')
@section('header', 'Edit Business Profile')
@section('subheader', 'Update the selected establishment profile.')

@section('content')
<div class="mx-auto max-w-4xl rounded-3xl border border-green-100 bg-white p-8 shadow-sm">
    <div class="mb-8 flex items-start justify-between gap-4">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-green-700">Business Profiling</p>
            <h1 class="mt-2 text-2xl font-bold text-slate-900">Edit Business Profile</h1>
        </div>
        <a href="{{ route('establishments.index') }}" class="rounded-xl border border-slate-300 px-4 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Back to list</a>
    </div>

    <form action="{{ route('establishments.update', $establishment) }}" method="POST">
        @csrf
        @method('PUT')
        @include('establishments._form', ['submitLabel' => 'Update Business Profile'])
    </form>
</div>
@endsection
