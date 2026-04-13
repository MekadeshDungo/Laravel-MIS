@extends('layouts.admin')

@section('title', 'Vaccination Records')

@section('header', 'Vaccination Records')

@section('content')
<div class="p-4 md:p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Vaccination Records</h1>
            <p class="text-gray-500 mt-1">Manage all rabies vaccination records</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin-staff.vaccinations.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="bi bi-plus-lg"></i>
                Encode New Vaccination
            </a>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-xl shadow-sm mb-6">
        <div class="p-6">
            <form method="GET" action="{{ route('admin-staff.vaccinations.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Patient, pet, or vaccine..." value="{{ $search }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Month</label>
                    <select name="month" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Months</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                        @endfor
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Vaccination List -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="overflow-x-auto">
            @if($vaccinations->count() > 0)
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Patient Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Pet Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Species</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Vaccine Brand</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Encoded By</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($vaccinations as $vaccination)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-gray-600">{{ $vaccination->vaccination_date->format('M d, Y') }}</td>
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $vaccination->patient_name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $vaccination->pet_name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ ucfirst($vaccination->pet_species) }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $vaccination->vaccine_brand }}</td>
                                <td class="px-6 py-4">
                                    @switch($vaccination->status)
                                        @case('completed')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Completed</span>
                                            @break
                                        @case('pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="px-6 py-4 text-gray-500 text-sm">{{ $vaccination->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin-staff.vaccinations.show', $vaccination) }}" class="p-2 text-info hover:bg-info hover:bg-opacity-10 rounded-lg transition" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $vaccinations->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="bi bi-shield-check text-5xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 mb-4">No vaccination records found.</p>
                    <a href="{{ route('admin-staff.vaccinations.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <i class="bi bi-plus-lg"></i>
                        Encode First Vaccination
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
