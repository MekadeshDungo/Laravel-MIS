@extends('layouts.admin')

@section('title', 'Business Profiling')
@section('header', 'Business Profiling')
@section('subheader', 'Register and maintain livestock inspector business profiles across barangays.')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-3xl bg-gradient-to-r from-green-700 via-green-600 to-emerald-500 p-6 text-white shadow-lg">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-green-100">Business Profiling</p>
                <h1 class="mt-2 text-3xl font-bold">Establishment Directory</h1>
                <p class="mt-2 max-w-2xl text-sm text-green-50">Track veterinary clinics, pet shops, and grooming businesses with searchable, barangay-based profiling records.</p>
            </div>
            <a href="{{ route('establishments.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-green-700 shadow-sm transition hover:bg-green-50">
                <i class="bi bi-plus-circle mr-2"></i>Add business
            </a>
        </div>
    </div>

    <div class="rounded-3xl border border-green-100 bg-white p-6 shadow-sm">
        <form method="GET" action="{{ route('establishments.index') }}" class="grid gap-4 md:grid-cols-4">
            <div>
                <label for="search" class="mb-2 block text-sm font-semibold text-slate-700">Search Name</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Business name" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200">
            </div>
            <div>
                <label for="type" class="mb-2 block text-sm font-semibold text-slate-700">Type</label>
                <select name="type" id="type" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200">
                    <option value="">All types</option>
                    <option value="clinic" @selected(request('type') === 'clinic')>Clinic</option>
                    <option value="pet_shop" @selected(request('type') === 'pet_shop')>Pet Shop</option>
                    <option value="grooming" @selected(request('type') === 'grooming')>Grooming</option>
                </select>
            </div>
            <div>
                <label for="barangay_id" class="mb-2 block text-sm font-semibold text-slate-700">Barangay</label>
                <select name="barangay_id" id="barangay_id" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200">
                    <option value="">All barangays</option>
                    @foreach($barangays as $barangay)
                        <option value="{{ $barangay->barangay_id }}" @selected((string) request('barangay_id') === (string) $barangay->barangay_id)>{{ $barangay->barangay_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-3">
                <button type="submit" class="flex-1 rounded-xl bg-green-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-green-700">Apply Filters</button>
                <a href="{{ route('establishments.index') }}" class="rounded-xl border border-slate-300 px-4 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Reset</a>
            </div>
        </form>
    </div>

    <div class="overflow-hidden rounded-3xl border border-green-100 bg-white shadow-sm">
        <div class="border-b border-green-100 px-6 py-4">
            <h2 class="text-lg font-semibold text-slate-800">Business Profiles</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-green-100">
                <thead class="bg-green-50 text-left text-xs font-semibold uppercase tracking-[0.2em] text-green-800">
                    <tr>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Owner</th>
                        <th class="px-6 py-4">Contact</th>
                        <th class="px-6 py-4">Barangay</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($establishments as $establishment)
                        <tr class="hover:bg-green-50/40">
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $establishment->name }}</td>
                            <td class="px-6 py-4">
                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">{{ $establishment->type_label }}</span>
                            </td>
                            <td class="px-6 py-4">{{ $establishment->owner_name }}</td>
                            <td class="px-6 py-4">{{ $establishment->contact_number }}</td>
                            <td class="px-6 py-4">{{ $establishment->barangay->barangay_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $establishment->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-700' }}">{{ ucfirst($establishment->status) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('establishments.edit', $establishment) }}" class="rounded-lg bg-amber-100 px-3 py-2 text-xs font-semibold text-amber-700 transition hover:bg-amber-200">Edit</a>
                                    <form action="{{ route('establishments.destroy', $establishment) }}" method="POST" onsubmit="return confirm('Delete this business profile?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg bg-red-100 px-3 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-200">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-sm text-slate-500">No business profiles matched the current filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 px-6 py-4">
            {{ $establishments->links() }}
        </div>
    </div>
</div>
@endsection
