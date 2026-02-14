@extends('layouts.admin')

@section('title', 'All Reports - City-wide View')

@section('content')
<div class="w-full">
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-1">
            <i class="bi bi-file-earmark-text me-2"></i>City-wide Reports
        </h2>
        <p class="text-gray-500 text-sm">View all reports submitted across all barangays, clinics, and inspection units.</p>
    </div>

    <!-- Report Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-red-500 text-white rounded-xl shadow-sm p-6">
            <div class="text-center">
                <i class="bi bi-exclamation-triangle text-4xl md:text-5xl mb-3 block"></i>
                <h4 class="text-3xl md:text-4xl font-bold mb-1">{{ \App\Models\AnimalBiteReport::count() }}</h4>
                <small class="text-red-100">Animal Bite Reports</small>
                <div class="mt-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white text-red-600">
                        <i class="bi bi-geo-alt me-1"></i> Barangay
                    </span>
                </div>
            </div>
        </div>
        <div class="bg-green-500 text-white rounded-xl shadow-sm p-6">
            <div class="text-center">
                <i class="bi bi-shield-check text-4xl md:text-5xl mb-3 block"></i>
                <h4 class="text-3xl md:text-4xl font-bold mb-1">{{ \App\Models\RabiesVaccinationReport::count() }}</h4>
                <small class="text-green-100">Vaccination Reports</small>
                <div class="mt-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white text-green-600">
                        <i class="bi bi-hospital me-1"></i> Clinics
                    </span>
                </div>
            </div>
        </div>
        <div class="bg-yellow-500 text-dark rounded-xl shadow-sm p-6">
            <div class="text-center">
                <i class="bi bi-search text-4xl md:text-5xl mb-3 block"></i>
                <h4 class="text-3xl md:text-4xl font-bold mb-1">{{ \App\Models\MeatInspectionReport::count() }}</h4>
                <small class="text-yellow-700">Meat Inspection Reports</small>
                <div class="mt-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white text-yellow-600">
                        <i class="bi bi-clipboard-check me-1"></i> Inspection
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="border-b border-gray-200 mb-6">
        <div class="flex gap-4 -mb-px overflow-x-auto">
            <button onclick="switchTab('bite')" class="tab-btn active px-4 py-3 border-b-2 border-red-500 text-red-600 font-medium text-sm whitespace-nowrap" id="bite-tab-btn">
                <i class="bi bi-exclamation-triangle me-2"></i>Animal Bites
            </button>
            <button onclick="switchTab('vaccine')" class="tab-btn px-4 py-3 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm whitespace-nowrap" id="vaccine-tab-btn">
                <i class="bi bi-shield-check me-2"></i>Vaccinations
            </button>
            <button onclick="switchTab('inspection')" class="tab-btn px-4 py-3 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm whitespace-nowrap" id="inspection-tab-btn">
                <i class="bi bi-search me-2"></i>Meat Inspection
            </button>
        </div>
    </div>

    <!-- Tab Content -->
    <div id="tab-content">
        <!-- Animal Bite Reports Tab -->
        <div id="bite-content" class="tab-pane">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-red-500 text-white px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <h5 class="font-semibold text-lg">
                        <i class="bi bi-exclamation-triangle me-2"></i>Animal Bite Incident Reports
                    </h5>
                    <button class="inline-flex items-center px-3 py-2 bg-white text-red-600 rounded-lg text-sm font-medium hover:bg-red-50 transition">
                        <i class="bi bi-file-earmark-pdf me-1"></i>Export PDF
                    </button>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="w-full min-w-[800px]">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reporter</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Barangay</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Victim</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Severity</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($biteReports as $report)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm font-medium">#{{ $report->id }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($report->incident_date)->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-sm">{{ $report->reporter_name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $report->barangay }}</td>
                                <td class="px-4 py-3 text-sm">{{ $report->victim_name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ ucfirst($report->animal_type) }}</td>
                                <td class="px-4 py-3">
                                    @if($report->bite_severity == 'minor')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Minor</span>
                                    @elseif($report->bite_severity == 'moderate')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Moderate</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Severe</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($report->status == 'pending')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                    @elseif($report->status == 'investigating')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Investigating</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Resolved</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                                    <i class="bi bi-inbox text-3xl mb-2 block"></i>
                                    No animal bite reports found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Vaccination Reports Tab -->
        <div id="vaccine-content" class="tab-pane hidden">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-green-500 text-white px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <h5 class="font-semibold text-lg">
                        <i class="bi bi-shield-check me-2"></i>Anti-Rabies Vaccination Reports
                    </h5>
                    <button class="inline-flex items-center px-3 py-2 bg-white text-green-600 rounded-lg text-sm font-medium hover:bg-green-50 transition">
                        <i class="bi bi-file-earmark-pdf me-1"></i>Export PDF
                    </button>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="w-full min-w-[800px]">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Clinic</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pet</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Species</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Brand</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($vaccinationReports as $report)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm font-medium">#{{ $report->id }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($report->vaccination_date)->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-sm">{{ $report->clinic_name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $report->patient_name }}</td>
                                <td class="px-4 py-3 text-sm">{{ $report->pet_name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ ucfirst($report->pet_species) }}</td>
                                <td class="px-4 py-3 text-sm">{{ $report->vaccine_brand }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $report->vaccination_type == 'primary' ? 'bg-blue-100 text-blue-800' : 'bg-cyan-100 text-cyan-800' }}">
                                        {{ ucfirst($report->vaccination_type) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                                    <i class="bi bi-inbox text-3xl mb-2 block"></i>
                                    No vaccination reports found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Meat Inspection Reports Tab -->
        <div id="inspection-content" class="tab-pane hidden">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-yellow-500 text-dark px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <h5 class="font-semibold text-lg">
                        <i class="bi bi-search me-2"></i>Meat Inspection Reports
                    </h5>
                    <button class="inline-flex items-center px-3 py-2 bg-gray-800 text-white rounded-lg text-sm font-medium hover:bg-gray-700 transition">
                        <i class="bi bi-file-earmark-pdf me-1"></i>Export PDF
                    </button>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="w-full min-w-[700px]">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Establishment</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Inspector</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($inspectionReports as $report)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm font-medium">#{{ $report->id }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($report->inspection_date)->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-sm">{{ $report->establishment_name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ ucfirst(str_replace('_', ' ', $report->establishment_type)) }}</td>
                                <td class="px-4 py-3 text-sm">{{ $report->inspector_name }}</td>
                                <td class="px-4 py-3">
                                    @switch($report->overall_rating)
                                        @case('excellent')
                                        @case('good')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">{{ ucfirst($report->overall_rating) }}</span>
                                            @break
                                        @case('satisfactory')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">{{ ucfirst($report->overall_rating) }}</span>
                                            @break
                                        @case('poor')
                                        @case('failed')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">{{ ucfirst($report->overall_rating) }}</span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="px-4 py-3">
                                    <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                    <i class="bi bi-inbox text-3xl mb-2 block"></i>
                                    No meat inspection reports found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(tab) {
    // Hide all tab content
    document.querySelectorAll('.tab-pane').forEach(pane => {
        pane.classList.add('hidden');
    });
    
    // Reset all tab buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('border-red-500', 'text-red-600');
        btn.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById(tab + '-content').classList.remove('hidden');
    
    // Highlight selected tab button
    const activeBtn = document.getElementById(tab + '-tab-btn');
    activeBtn.classList.remove('border-transparent', 'text-gray-500');
    activeBtn.classList.add('border-red-500', 'text-red-600');
}
</script>
@endsection
