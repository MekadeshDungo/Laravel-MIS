@extends('layouts.admin')

@section('title', 'Rabies Vaccination Reports')

@section('content')
<div class="w-full">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h1 class="text-xl md:text-2xl font-bold text-gray-800">Rabies Vaccination Reports</h1>
        <a href="{{ route('assistant-vet.vaccinations.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            <i class="bi bi-plus-lg"></i> New Vaccination
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-600 text-white rounded-xl shadow-sm p-6">
            <h5 class="text-blue-100 text-sm font-medium mb-2">Total Reports</h5>
            <h2 class="text-3xl md:text-4xl font-bold">{{ $reports->total() }}</h2>
        </div>
        <div class="bg-green-500 text-white rounded-xl shadow-sm p-6">
            <h5 class="text-green-100 text-sm font-medium mb-2">This Month</h5>
            <h2 class="text-3xl md:text-4xl font-bold">{{ $reports->where('vaccination_date', '>=', now()->startOfMonth())->count() }}</h2>
        </div>
        <div class="bg-purple-500 text-white rounded-xl shadow-sm p-6">
            <h5 class="text-purple-100 text-sm font-medium mb-2">Clinics</h5>
            <h2 class="text-3xl md:text-4xl font-bold">{{ $reports->unique('clinic_name')->count() }}</h2>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($reports->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Report ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Clinic</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Vaccine</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Animals</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($reports as $report)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-800">RV-{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-800">{{ $report->clinic_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-gray-800">{{ $report->vaccine_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-gray-800">{{ $report->number_of_animals ?? 0 }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $report->vaccination_date ? \Carbon\Carbon::parse($report->vaccination_date)->format('M d, Y') : 'N/A' }}</td>
                            <td class="px-6 py-4">
                                <a href="#" class="text-blue-600 hover:text-blue-800">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $reports->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-shield-check text-green-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">No Vaccination Reports</h3>
                <p class="text-gray-500 mb-6">No records found.</p>
            </div>
        @endif
    </div>
</div>
@endsection