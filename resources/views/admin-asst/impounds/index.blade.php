@extends('layouts.admin')

@section('title', 'Impounded Animals')
@section('header', 'Impounded Animals')
@section('subheader', 'Manage impounded animals in the city pound')

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800"><i class="bi bi-archive me-2"></i>Impounded Animals</h2>
            <p class="text-gray-500 text-sm">Manage impounded animals in the city pound</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-list text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalCount }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-clock text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Impounded</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $impoundedCount }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-person-check text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Claimed</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $claimedCount }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-heart text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Adopted</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $adoptedCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" name="search" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Tag code or location..." value="{{ request('search') }}">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Disposition</label>
                <select name="disposition" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <option value="">All Status</option>
                    <option value="impounded" {{ request('disposition') == 'impounded' ? 'selected' : '' }}>Impounded</option>
                    <option value="claimed" {{ request('disposition') == 'claimed' ? 'selected' : '' }}>Claimed</option>
                    <option value="adopted" {{ request('disposition') == 'adopted' ? 'selected' : '' }}>Adopted</option>
                    <option value="transferred" {{ request('disposition') == 'transferred' ? 'selected' : '' }}>Transferred</option>
                    <option value="euthanized" {{ request('disposition') == 'euthanized' ? 'selected' : '' }}>Euthanized</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Barangay</label>
                <select name="barangay_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <option value="">All Barangays</option>
                    @foreach($barangays as $barangay)
                        <option value="{{ $barangay->barangay_id }}" {{ request('barangay_id') == $barangay->barangay_id ? 'selected' : '' }}>
                            {{ $barangay->barangay_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-2 flex items-end gap-2">
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
                <a href="{{ route('admin-asst.impounds.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Impounds List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tag Code</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Intake Condition</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Intake Location</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Intake Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Disposition</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($impounds as $impound)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3"><strong>#{{ $impound->impound_id }}</strong></td>
                        <td class="px-4 py-3">{{ $impound->animal_tag_code ?? 'Not assigned' }}</td>
                        <td class="px-4 py-3">{{ ucfirst($impound->intake_condition ?? 'Unknown') }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ Str::limit($impound->intake_location ?? 'N/A', 30) }}</td>
                        <td class="px-4 py-3">{{ $impound->intake_date ? $impound->intake_date->format('M d, Y') : 'N/A' }}</td>
                        <td class="px-4 py-3">
                            @php
                                $badgeClass = match($impound->current_disposition) {
                                    'impounded' => 'bg-yellow-100 text-yellow-800',
                                    'adopted' => 'bg-green-100 text-green-800',
                                    'claimed' => 'bg-blue-100 text-blue-800',
                                    'euthanized' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                            @endphp
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $badgeClass }}">
                                {{ ucfirst($impound->current_disposition) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin-asst.impounds.show', $impound) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                                <i class="bi bi-eye me-1"></i>View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                            <i class="bi bi-inbox text-4xl mb-2 block"></i>
                            <p>No impound records found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $impounds->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection