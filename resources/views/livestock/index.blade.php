@extends('layouts.admin')

@section('title', 'Livestock Records')
@section('header', 'Livestock Records')
@section('subheader', 'Manage poultry and livestock census entries by barangay and animal type.')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-6 xl:grid-cols-[2fr,1fr]">
        <div class="rounded-3xl bg-gradient-to-br from-green-700 via-green-600 to-emerald-500 p-6 text-white shadow-lg">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-green-100">Poultry & Livestock Management</p>
                    <h1 class="mt-2 text-3xl font-bold">Livestock Census Records</h1>
                    <p class="mt-2 max-w-2xl text-sm text-green-50">Track ownership, farm sites, and animal population counts across barangays with a simple green-themed admin workflow.</p>
                </div>
                <a href="{{ route('livestock.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-green-700 shadow-sm transition hover:bg-green-50">
                    <i class="bi bi-plus-circle mr-2"></i>Add record
                </a>
            </div>
        </div>

        <div class="rounded-3xl border border-green-100 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-green-700">Barangay Totals</p>
            <div class="mt-4 space-y-3">
                @forelse($barangayTotals as $total)
                    <div class="flex items-center justify-between rounded-2xl bg-green-50 px-4 py-3">
                        <span class="text-sm font-medium text-slate-700">{{ $total->barangay->barangay_name ?? 'Unassigned' }}</span>
                        <span class="text-lg font-bold text-green-700">{{ number_format($total->total_quantity) }}</span>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">No barangay totals available.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="rounded-3xl border border-green-100 bg-white p-6 shadow-sm">
        <form method="GET" action="{{ route('livestock.index') }}" class="grid gap-4 md:grid-cols-4">
            <div>
                <label for="barangay_id" class="mb-2 block text-sm font-semibold text-slate-700">Barangay</label>
                <select name="barangay_id" id="barangay_id" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200">
                    <option value="">All barangays</option>
                    @foreach($barangays as $barangay)
                        <option value="{{ $barangay->barangay_id }}" @selected((string) request('barangay_id') === (string) $barangay->barangay_id)>{{ $barangay->barangay_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="animal_type" class="mb-2 block text-sm font-semibold text-slate-700">Animal Type</label>
                <select name="animal_type" id="animal_type" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200">
                    <option value="">All animal types</option>
                    @foreach($animalTypes as $animalType)
                        <option value="{{ $animalType }}" @selected(request('animal_type') === $animalType)>{{ ucfirst($animalType) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Quick Count</label>
                <div class="rounded-xl border border-green-100 bg-green-50 px-4 py-3 text-sm text-green-800">
                    {{ number_format($livestock->total()) }} record(s) found
                </div>
            </div>
            <div class="flex items-end gap-3">
                <button type="submit" class="flex-1 rounded-xl bg-green-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-green-700">Apply Filters</button>
                <a href="{{ route('livestock.index') }}" class="rounded-xl border border-slate-300 px-4 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Reset</a>
            </div>
        </form>
    </div>

    <div class="overflow-hidden rounded-3xl border border-green-100 bg-white shadow-sm">
        <div class="border-b border-green-100 px-6 py-4">
            <h2 class="text-lg font-semibold text-slate-800">Livestock Records</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-green-100">
                <thead class="bg-green-50 text-left text-xs font-semibold uppercase tracking-[0.2em] text-green-800">
                    <tr>
                        <th class="px-6 py-4">Owner</th>
                        <th class="px-6 py-4">Farm</th>
                        <th class="px-6 py-4">Animal</th>
                        <th class="px-6 py-4">Quantity</th>
                        <th class="px-6 py-4">Barangay</th>
                        <th class="px-6 py-4">Recorded By</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($livestock as $record)
                        <tr class="hover:bg-green-50/40">
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $record->owner_name }}</td>
                            <td class="px-6 py-4">{{ $record->farm_name ?: 'N/A' }}</td>
                            <td class="px-6 py-4">
                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-green-800">{{ $record->animal_type }}</span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-green-700">{{ number_format($record->quantity) }}</td>
                            <td class="px-6 py-4">{{ $record->barangay->barangay_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $record->recordedBy->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('livestock.edit', $record) }}" class="rounded-lg bg-amber-100 px-3 py-2 text-xs font-semibold text-amber-700 transition hover:bg-amber-200">Edit</a>
                                    <form action="{{ route('livestock.destroy', $record) }}" method="POST" onsubmit="return confirm('Delete this livestock record?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg bg-red-100 px-3 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-200">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-sm text-slate-500">No livestock records matched the current filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 px-6 py-4">
            {{ $livestock->links() }}
        </div>
    </div>
</div>
@endsection
