@extends('layouts.admin')

@section('title', 'City Veterinarian Dashboard')

@section('header', 'City Veterinarian Dashboard')
@section('subheader', 'Rabies Control & Vaccination Program Overview')

@section('content')
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-red-600 to-red-800 rounded-xl shadow-lg p-4 md:p-6 mb-6 text-white">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-xl md:text-2xl font-bold mb-2">Welcome back, {{ auth()->user()->name ?? 'City Vet' }}!</h2>
            <p class="text-red-100 text-sm md:text-base">Monitor rabies cases, vaccination programs, and animal health statistics.</p>
        </div>
        <div class="flex gap-2">
            <select id="yearFilter" onchange="window.location.href='?year='+this.value" class="bg-white/20 text-white border border-white/30 rounded-lg px-3 py-2 text-sm backdrop-blur-sm">
                @for($y = date('Y'); $y >= date('Y')-5; $y--)
                    <option value="{{ $y }}" {{ ($year ?? date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
    </div>
</div>

<!-- Quick Stats from Controller -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 md:gap-6 mb-6">
    <!-- Total Rabies Cases -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Total Rabies Cases</p>
                <p class="text-xl md:text-3xl font-bold text-red-600 mt-1">{{ $stats['total_rabies_cases'] ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-red-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-exclamation-triangle text-red-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Open Cases -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Open Cases</p>
                <p class="text-xl md:text-3xl font-bold text-orange-600 mt-1">{{ $stats['open_cases'] ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-orange-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-exclamation-circle text-orange-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Confirmed Cases -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Confirmed Positive</p>
                <p class="text-xl md:text-3xl font-bold text-purple-600 mt-1">{{ $stats['confirmed_cases'] ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-virus text-purple-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Bite Reports -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Bite Reports</p>
                <p class="text-xl md:text-3xl font-bold text-green-600 mt-1">{{ $stats['total_bite_reports'] ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-file-earmark-medical text-green-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Anti-Rabies Vaccination -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Anti-Rabies Vaccination</p>
                <p class="text-xl md:text-3xl font-bold text-green-600 mt-1">{{ $stats['total_vaccinations'] ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-eyedropper text-green-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Active Impounds -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Active Impounds</p>
                <p class="text-xl md:text-3xl font-bold text-amber-600 mt-1">{{ $stats['active_impounds'] ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-amber-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-paw text-amber-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-6">
    <!-- Cases by Type Chart -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-4">Cases by Type ({{ $year ?? date('Y') }})</h3>
        <div class="h-48 md:h-64">
            <canvas id="speciesChart"></canvas>
        </div>
    </div>

    <!-- Monthly Cases Chart -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-4">Monthly Cases ({{ $year ?? date('Y') }})</h3>
        <div class="h-48 md:h-64">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>
</div>

<!-- Recent Cases & Quick Actions Row -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6 mb-6">
    <!-- Recent Cases -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100 lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base md:text-lg font-semibold text-gray-800">Recent Rabies Cases</h3>
            <!-- <a href="{{ route('city-vet.rabies-cases.index') }}" class="text-sm text-green-600 hover:text-green-800">View All</a> -->
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Case #</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Species</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($recentCases ?? [] as $case)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-gray-900 font-medium">{{ $case->case_number }}</td>
                        <td class="px-3 py-2">
                            <span class="px-2 py-1 text-xs rounded-full @if($case->case_type == 'positive') bg-red-100 text-red-800 @elseif($case->case_type == 'probable') bg-orange-100 text-orange-800 @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($case->case_type) }}
                            </span>
                        </td>
                        <td class="px-3 py-2 text-gray-600">{{ ucfirst($case->species) }}</td>
                        <td class="px-3 py-2">
                            <span class="px-2 py-1 text-xs rounded-full @if($case->status == 'open') bg-red-100 text-red-800 @elseif($case->status == 'under_investigation') bg-yellow-100 text-yellow-800 @else bg-green-100 text-green-800 @endif">
                                {{ str_replace('_', ' ', ucfirst($case->status)) }}
                            </span>
                        </td>
                        <td class="px-3 py-2 text-gray-500">{{ $case->incident_date?->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-3 py-4 text-center text-gray-500">No recent cases</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
        <div class="space-y-3">
            <a href="{{ route('city-vet.vaccination-reports.index') }}" class="flex items-center gap-3 p-3 bg-red-50 hover:bg-red-100 rounded-xl transition group">
                <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center">
                    <i class="bi bi-eyedropper text-white"></i>
                </div>
                <span class="text-sm font-medium text-gray-700">Anti-Rabies Vaccination</span>
            </a>
            <!-- <a href="{{ route('city-vet.rabies-cases.index') }}" class="flex items-center gap-3 p-3 bg-orange-50 hover:bg-orange-100 rounded-xl transition group">
                <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center">
                    <i class="bi bi-exclamation-triangle text-white"></i>
                </div>
                <span class="text-sm font-medium text-gray-700">Rabies Cases</span>
            </a> -->
            <a href="{{ route('city-vet.bite-reports.index') }}" class="flex items-center gap-3 p-3 bg-yellow-50 hover:bg-yellow-100 rounded-xl transition group">
                <div class="w-10 h-10 bg-yellow-600 rounded-lg flex items-center justify-center">
                    <i class="bi bi-file-earmark-medical text-white"></i>
                </div>
                <span class="text-sm font-medium text-gray-700">Bite Reports</span>
            </a>
            <a href="{{ route('city-vet.impound.index') }}" class="flex items-center gap-3 p-3 bg-amber-50 hover:bg-amber-100 rounded-xl transition group">
                <div class="w-10 h-10 bg-amber-600 rounded-lg flex items-center justify-center">
                    <i class="bi bi-paw text-white"></i>
                </div>
                <span class="text-sm font-medium text-gray-700">Impound Monitoring</span>
            </a>
            <a href="{{ route('city-vet.all-reports') }}" class="flex items-center gap-3 p-3 bg-green-50 hover:bg-green-100 rounded-xl transition group">
                <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                    <i class="bi bi-file-earmark-bar-graph text-white"></i>
                </div>
                <span class="text-sm font-medium text-gray-700">Analytics</span>
            </a>
            <a href="{{ route('city-vet.rabies-geomap') }}" class="flex items-center gap-3 p-3 bg-purple-50 hover:bg-purple-100 rounded-xl transition group">
                <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                    <i class="bi bi-geo-alt-fill text-white"></i>
                </div>
                <span class="text-sm font-medium text-gray-700">Geomap (Heatmap)</span>
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cases by Type Chart
    const casesByType = @json($casesByType ?? []);
    const typeLabels = Object.keys(casesByType).map(k => k.charAt(0).toUpperCase() + k.slice(1));
    const typeData = Object.values(casesByType);
    
    const speciesCtx = document.getElementById('speciesChart').getContext('2d');
    new Chart(speciesCtx, {
        type: 'bar',
        data: {
            labels: typeLabels,
            datasets: [{
                label: 'Cases',
                data: typeData,
                backgroundColor: ['#ef4444', '#f97316', '#eab308', '#22c55e'],
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    // Monthly Cases Chart
    const monthlyCases = @json($monthlyCases ?? []);
    const monthLabels = Array.from({length: 12}, (_, i) => {
        const date = new Date({{ $year ?? date('Y') }}, i, 1);
        return date.toLocaleString('default', { month: 'short' });
    });
    const monthlyData = monthLabels.map((_, i) => monthlyCases[i + 1] || 0);
    
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'Cases',
                data: monthlyData,
                borderColor: '#ef4444',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
});
</script>
@endpush