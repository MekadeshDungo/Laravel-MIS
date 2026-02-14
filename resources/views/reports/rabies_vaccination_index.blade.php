@extends('layouts.admin')

@section('title', 'Rabies Vaccination Reports')

@section('header', 'Rabies Vaccination Reports')
@section('subheader', 'Track and manage rabies vaccination records')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Vaccinations</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ \App\Models\RabiesVaccinationReport::count() }}</p>
            </div>
            <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-eyedropper text-red-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">This Month</p>
                <p class="text-3xl font-bold text-blue-600 mt-1">{{ \App\Models\RabiesVaccinationReport::whereMonth('vaccination_date', now()->month)->count() }}</p>
            </div>
            <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-calendar-check text-blue-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Dogs Vaccinated</p>
                <p class="text-3xl font-bold text-green-600 mt-1">{{ \App\Models\RabiesVaccinationReport::where('pet_species', 'dog')->count() }}</p>
            </div>
            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-hearts text-green-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Cats Vaccinated</p>
                <p class="text-3xl font-bold text-purple-600 mt-1">{{ \App\Models\RabiesVaccinationReport::where('pet_species', 'cat')->count() }}</p>
            </div>
            <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-gem text-purple-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Quick Actions</h3>
        <a href="{{ route('admin.vaccination-reports.index') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2">
            <i class="bi bi-plus-lg"></i> New Record
        </a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.vaccination-reports.index') }}" class="flex flex-col items-center p-4 bg-red-50 hover:bg-red-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-plus-circle text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">New Record</span>
        </a>

        <a href="{{ route('admin.vaccination-reports.index') }}" class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-list text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">All Records</span>
        </a>

        <a href="#" class="flex flex-col items-center p-4 bg-green-50 hover:bg-green-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-file-earmark-bar-graph text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Summary</span>
        </a>

        <a href="#" class="flex flex-col items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-printer text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Print</span>
        </a>
    </div>
</div>

<!-- Vaccination Records Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800">Recent Vaccination Records</h3>
        <a href="{{ route('admin.vaccination-reports.index') }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1">
            View All <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Certificate No.</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Animal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vaccine</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse(\App\Models\RabiesVaccinationReport::latest()->take(5)->get() as $record)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-blue-600">{{ $record->certificate_number }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $record->owner_name }}</p>
                                <p class="text-xs text-gray-500">{{ $record->contact_number }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center mr-2 
                                    @if($record->pet_species == 'dog') bg-green-100 @else bg-purple-100 @endif">
                                    <i class="bi @if($record->pet_species == 'dog') bi-hearts @else bi-gem @endif 
                                        @if($record->pet_species == 'dog') text-green-600 @else text-purple-600 @endif text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-700 capitalize">{{ $record->pet_species }}</p>
                                    <p class="text-xs text-gray-500">{{ $record->pet_breed }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record->vaccine_brand }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record->vaccination_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.vaccination-reports.show', $record) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.vaccination-reports.edit', $record) }}" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition" title="Print" onclick="printCertificate({{ $record->id }})">
                                    <i class="bi bi-printer"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <i class="bi bi-eyedropper text-4xl mb-2 block"></i>
                            No vaccination records yet
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
    window.open('/admin/vaccination-reports/' + id + '/print', '_blank');
}
</script>
@endpush
@endsection
