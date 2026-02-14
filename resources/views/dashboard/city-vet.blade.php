@extends('layouts.admin')

@section('title', 'City Veterinarian Dashboard')

@section('header', 'City Veterinarian Dashboard')
@section('subheader', 'Rabies Control & Vaccination Program Overview')

@section('content')
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-red-600 to-red-800 rounded-xl shadow-lg p-4 md:p-6 mb-6 text-white">
    <h2 class="text-xl md:text-2xl font-bold mb-2">Welcome back, {{ auth()->user()->name ?? 'City Vet' }}!</h2>
    <p class="text-red-100 text-sm md:text-base">Monitor rabies cases, vaccination programs, and animal health statistics.</p>
</div>

<!-- Quick Stats -->
@php
$totalVaccinations = \App\Models\RabiesVaccinationReport::count();
$dogsVaccinated = \App\Models\RabiesVaccinationReport::where('pet_species', 'dog')->count();
$catsVaccinated = \App\Models\RabiesVaccinationReport::where('pet_species', 'cat')->count();
$thisMonth = \App\Models\RabiesVaccinationReport::whereMonth('vaccination_date', now()->month)->whereYear('vaccination_date', now()->year)->count();
$boosterShots = \App\Models\RabiesVaccinationReport::where('vaccination_type', 'booster')->count();
$primaryShots = \App\Models\RabiesVaccinationReport::where('vaccination_type', 'primary')->count();
$totalCases = \App\Models\RabiesCase::count();
$openCases = \App\Models\RabiesCase::where('status', 'open')->count();
$resolvedCases = \App\Models\RabiesCase::where('status', 'resolved')->count();

// Get last 6 months data for chart
$monthlyLabels = [];
$monthlyData = [];
for ($i = 5; $i >= 0; $i--) {
    $date = now()->subMonths($i);
    $monthlyLabels[] = $date->format('M');
    $monthlyData[] = \App\Models\RabiesVaccinationReport::whereMonth('vaccination_date', $date->month)
        ->whereYear('vaccination_date', $date->year)
        ->count();
}
@endphp

<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6 mb-6">
    <!-- Total Vaccinations -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Total</p>
                <p class="text-xl md:text-3xl font-bold text-red-600 mt-1">{{ $totalVaccinations }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-red-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-eyedropper text-red-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Dogs Vaccinated -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Dogs</p>
                <p class="text-xl md:text-3xl font-bold text-green-600 mt-1">{{ $dogsVaccinated }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-hearts text-green-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Cats Vaccinated -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Cats</p>
                <p class="text-xl md:text-3xl font-bold text-purple-600 mt-1">{{ $catsVaccinated }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-gem text-purple-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- This Month -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">This Month</p>
                <p class="text-xl md:text-3xl font-bold text-blue-600 mt-1">{{ $thisMonth }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-calendar3 text-blue-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-6">
    <!-- Species Distribution Chart -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-4">Vaccination by Species</h3>
        <div class="h-48 md:h-64">
            <canvas id="speciesChart"></canvas>
        </div>
    </div>

    <!-- Vaccination Type Chart -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-4">Primary vs Booster</h3>
        <div class="h-48 md:h-64">
            <canvas id="typeChart"></canvas>
        </div>
    </div>
</div>

<!-- Monthly Trend & Cases Row -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6 mb-6">
    <!-- Monthly Trend Chart -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100 lg:col-span-2">
        <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-4">Monthly Trend</h3>
        <div class="h-48 md:h-64">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>

    <!-- Rabies Cases Summary -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-4">Rabies Cases</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <i class="bi bi-exclamation-triangle text-red-600"></i>
                    <span class="text-sm text-gray-700">Total</span>
                </div>
                <span class="font-semibold text-gray-800">{{ $totalCases }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <i class="bi bi-exclamation-circle text-orange-600"></i>
                    <span class="text-sm text-gray-700">Open</span>
                </div>
                <span class="font-semibold text-gray-800">{{ $openCases }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <i class="bi bi-check-circle text-green-600"></i>
                    <span class="text-sm text-gray-700">Resolved</span>
                </div>
                <span class="font-semibold text-gray-800">{{ $resolvedCases }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <i class="bi bi-hand-thumbs-up text-yellow-600"></i>
                    <span class="text-sm text-gray-700">Booster</span>
                </div>
                <span class="font-semibold text-gray-800">{{ $boosterShots }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <i class="bi bi-shield-check text-blue-600"></i>
                    <span class="text-sm text-gray-700">Primary</span>
                </div>
                <span class="font-semibold text-gray-800">{{ $primaryShots }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 mb-6">
    <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
        <a href="{{ route('city-vet.vaccination-reports.index') }}" class="flex flex-col items-center p-3 md:p-4 bg-red-50 hover:bg-red-100 rounded-xl transition group">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-red-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-eyedropper text-white text-lg md:text-xl"></i>
            </div>
            <span class="text-xs md:text-sm font-medium text-gray-700 text-center">Vaccinations</span>
        </a>
        <a href="{{ route('city-vet.rabies-cases.index') }}" class="flex flex-col items-center p-3 md:p-4 bg-orange-50 hover:bg-orange-100 rounded-xl transition group">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-orange-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-exclamation-triangle text-white text-lg md:text-xl"></i>
            </div>
            <span class="text-xs md:text-sm font-medium text-gray-700 text-center">Rabies Cases</span>
        </a>
        <a href="{{ route('city-vet.bite-reports.index') }}" class="flex flex-col items-center p-3 md:p-4 bg-yellow-50 hover:bg-yellow-100 rounded-xl transition group">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-yellow-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-file-earmark-medical text-white text-lg md:text-xl"></i>
            </div>
            <span class="text-xs md:text-sm font-medium text-gray-700 text-center">Bite Reports</span>
        </a>
        <a href="{{ route('city-vet.all-reports') }}" class="flex flex-col items-center p-3 md:p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition group">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-file-earmark-bar-graph text-white text-lg md:text-xl"></i>
            </div>
            <span class="text-xs md:text-sm font-medium text-gray-700 text-center">Analytics</span>
        </a>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Species Distribution Chart (Doughnut)
    const speciesCtx = document.getElementById('speciesChart').getContext('2d');
    new Chart(speciesCtx, {
        type: 'doughnut',
        data: {
            labels: ['Dogs', 'Cats', 'Other'],
            datasets: [{
                data: [{{ $dogsVaccinated }}, {{ $catsVaccinated }}, {{ max(0, $totalVaccinations - $dogsVaccinated - $catsVaccinated) }}],
                backgroundColor: ['#22c55e', '#a855f7', '#6b7280'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Vaccination Type Chart (Pie)
    const typeCtx = document.getElementById('typeChart').getContext('2d');
    new Chart(typeCtx, {
        type: 'pie',
        data: {
            labels: ['Primary', 'Booster'],
            datasets: [{
                data: [{{ $primaryShots }}, {{ $boosterShots }}],
                backgroundColor: ['#3b82f6', '#f59e0b'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Monthly Trend Chart (Line)
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyLabels) !!},
            datasets: [{
                label: 'Vaccinations',
                data: {!! json_encode($monthlyData) !!},
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
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection
