@extends('layouts.admin')

@section('title', 'Meat Inspection Reports')

@section('header', 'Meat Inspection Reports')
@section('subheader', 'Track and manage meat inspection records')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Inspections</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ \App\Models\MeatInspectionReport::count() }}</p>
            </div>
            <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-clipboard-check text-red-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Passed</p>
                <p class="text-3xl font-bold text-green-600 mt-1">{{ \App\Models\MeatInspectionReport::where('compliance_status', 'compliant')->count() }}</p>
            </div>
            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-check-circle text-green-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Condemned</p>
                <p class="text-3xl font-bold text-red-600 mt-1">{{ \App\Models\MeatInspectionReport::where('compliance_status', 'non_compliant')->count() }}</p>
            </div>
            <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-x-circle text-red-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">This Month</p>
                <p class="text-3xl font-bold text-blue-600 mt-1">{{ \App\Models\MeatInspectionReport::whereMonth('inspection_date', now()->month)->count() }}</p>
            </div>
            <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-calendar-check text-blue-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-8">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
            <span class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-lightning text-red-600"></i>
            </span>
            Quick Actions
        </h3>
        <a href="{{ route('meat-inspection.reports.create') }}" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition shadow-md hover:shadow-lg flex items-center gap-2">
            <i class="bi bi-plus-lg"></i> New Record
        </a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('meat-inspection.reports.create') }}" class="flex flex-col items-center p-5 bg-red-50 hover:bg-red-100 rounded-xl transition group border border-red-100">
            <div class="w-14 h-14 bg-red-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition shadow-md">
                <i class="bi bi-plus-circle text-white text-xl"></i>
            </div>
            <span class="text-sm font-semibold text-gray-700">New Record</span>
        </a>

        <a href="{{ route('meat-inspection.reports.index') }}" class="flex flex-col items-center p-5 bg-blue-50 hover:bg-blue-100 rounded-xl transition group border border-blue-100">
            <div class="w-14 h-14 bg-blue-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition shadow-md">
                <i class="bi bi-list text-white text-xl"></i>
            </div>
            <span class="text-sm font-semibold text-gray-700">All Records</span>
        </a>

        <a href="#" class="flex flex-col items-center p-5 bg-green-50 hover:bg-green-100 rounded-xl transition group border border-green-100">
            <div class="w-14 h-14 bg-green-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition shadow-md">
                <i class="bi bi-file-earmark-bar-graph text-white text-xl"></i>
            </div>
            <span class="text-sm font-semibold text-gray-700">Summary</span>
        </a>

        <a href="#" class="flex flex-col items-center p-5 bg-purple-50 hover:bg-purple-100 rounded-xl transition group border border-purple-100">
            <div class="w-14 h-14 bg-purple-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition shadow-md">
                <i class="bi bi-printer text-white text-xl"></i>
            </div>
            <span class="text-sm font-semibold text-gray-700">Print</span>
        </a>
    </div>
</div>

<!-- Inspection Records Table -->
<div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
            <span class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-list-ul text-red-600"></i>
            </span>
            Recent Inspection Records
        </h3>
        <a href="{{ route('meat-inspection.reports.index') }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1 font-medium">
            View All <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Certificate No.</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Establishment</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Animal</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Result</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse(\App\Models\MeatInspectionReport::latest()->take(5)->get() as $report)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-bold text-blue-600">{{ $report->certificate_number }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $report->establishment_name }}</p>
                                <p class="text-xs text-gray-500 capitalize">{{ str_replace('_', ' ', $report->establishment_type) }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 capitalize">{{ $report->animal_type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $report->quantity }} {{ $report->quantity_unit }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($report->inspection_date)->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($report->compliance_status == 'compliant')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Passed</span>
                            @elseif($report->compliance_status == 'non_compliant')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Condemned</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('meat-inspection.reports.show', $report) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <button type="button" class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition" title="Print" onclick="printCertificate({{ $report->id }})">
                                    <i class="bi bi-printer"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="bi bi-clipboard-check text-5xl mb-3 text-gray-300"></i>
                                <p class="text-lg font-medium text-gray-700">No inspection records yet</p>
                                <p class="text-sm text-gray-500 mt-1">Create your first inspection record to get started</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
function printCertificate(id) {
    window.open('/meat-inspection/reports/' + id, '_blank');
}
</script>
@endpush
@endsection
