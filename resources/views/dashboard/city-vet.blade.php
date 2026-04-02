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

    <!-- Total Vaccinations -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Vaccinations</p>
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
            <canvas id="typeChart"></canvas>
        </div>
    </div>
</div>

<!-- Rabies Geomapping Section -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 mb-6">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-4 gap-3">
        <h3 class="text-base md:text-lg font-semibold text-gray-800">
            <i class="bi bi-geo-alt mr-2 text-purple-600"></i>Rabies Geomapping - Dasmariñas City
        </h3>
        <div class="flex items-center gap-3">
            <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                <input type="checkbox" id="spotlightToggle" checked class="sr-only peer" onchange="toggleSpotlight(this.checked)">
                <div class="relative w-10 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-purple-600"></div>
                <span class="text-sm font-medium text-gray-600">Focus Mode</span>
            </label>
            <a href="{{ route('city-vet.rabies-geomap') }}" class="inline-flex items-center px-3 py-1.5 bg-purple-100 hover:bg-purple-200 text-purple-700 rounded-lg text-sm font-medium transition-colors">
                <i class="bi bi-arrows-fullscreen mr-2"></i>View Full Map
            </a>
        </div>
    </div>
    
    <!-- Map Container Wrapper -->
    <div class="relative">
        <!-- Loading State Overlay -->
        <div id="dashboard-map-loading" class="absolute inset-0 bg-white/90 flex items-center justify-center z-10 rounded-xl" style="height: 450px;">
            <div class="text-center">
                <div class="inline-block animate-spin rounded-full h-10 w-10 border-4 border-purple-500 border-t-transparent"></div>
                <p class="mt-3 text-gray-500 font-medium">Loading map data...</p>
            </div>
        </div>
        
        <!-- Map Container -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <style>
            #dashboard-map { 
                height: 450px; 
                width: 100%; 
                border-radius: 12px; 
            }
            /* Ensure Leaflet controls are above map container */
            #dashboard-map + .leaflet-control {
                z-index: 10 !important;
            }
            /* Ensure popups appear above all other elements */
            #dashboard-map + .leaflet-popup {
                z-index: 100 !important;
            }
            .barangay-label { 
                font-size: 10px; 
                font-weight: 600; 
                color: #111827; 
                background: rgba(255,255,255,0.85); 
                padding: 1px 3px; 
                border-radius: 3px; 
                border: 1px solid #d1d5db; 
                white-space: nowrap; 
            }
            /* Dashboard map popup styling */
            #dashboard-map + .leaflet-popup-content-wrapper {
                border-radius: 12px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            }
        </style>
        <div id="dashboard-map"></div>
    </div>
    
    <!-- Legend -->
    <div class="mt-4 flex flex-wrap items-center gap-3 text-xs text-gray-600">
        <span class="font-medium text-gray-500">Legend:</span>
        <span class="flex items-center gap-1.5"><span class="w-3 h-3 bg-[#dbeafe] border border-gray-400 rounded"></span> No Cases</span>
        <span class="flex items-center gap-1.5"><span class="w-3 h-3 bg-[#86efac] border border-gray-400 rounded"></span> Low (1-2)</span>
        <span class="flex items-center gap-1.5"><span class="w-3 h-3 bg-[#fbbf24] border border-gray-400 rounded"></span> Medium (3-5)</span>
        <span class="flex items-center gap-1.5"><span class="w-3 h-3 bg-[#ef4444] border border-gray-400 rounded"></span> High (6+)</span>
    </div>
    
    <!-- Message -->
    <div id="map-message" class="mt-3 p-2 bg-gray-50 rounded-lg text-center text-sm text-gray-500">
        <i class="bi bi-info-circle mr-1"></i> Dasmariñas City boundary displayed. Map is locked to city limits.
    </div>
</div>

<!-- Recent Cases & Quick Actions Row -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6 mb-6">
    <!-- Recent Cases -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100 lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base md:text-lg font-semibold text-gray-800">Recent Rabies Cases</h3>
            <a href="{{ route('city-vet.rabies-cases.index') }}" class="text-sm text-green-600 hover:text-green-800">View All</a>
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
                <span class="text-sm font-medium text-gray-700">Vaccinations</span>
            </a>
            <a href="{{ route('city-vet.rabies-cases.index') }}" class="flex items-center gap-3 p-3 bg-orange-50 hover:bg-orange-100 rounded-xl transition group">
                <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center">
                    <i class="bi bi-exclamation-triangle text-white"></i>
                </div>
                <span class="text-sm font-medium text-gray-700">Rabies Cases</span>
            </a>
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

<!-- Leaflet CSS & JS for Dashboard Map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cases by Type Chart (Bar)
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

    // Monthly Cases Chart (Line)
    const monthlyCases = @json($monthlyCases ?? []);
    const monthLabels = Array.from({length: 12}, (_, i) => {
        const date = new Date({{ $year ?? date('Y') }}, i, 1);
        return date.toLocaleString('default', { month: 'short' });
    });
    const monthlyData = monthLabels.map((_, i) => monthlyCases[i + 1] || 0);
    
    const typeCtx = document.getElementById('typeChart').getContext('2d');
    new Chart(typeCtx, {
        type: 'line',
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'Cases',
                data: monthlyData,
                borderColor: '#f97316',
                backgroundColor: 'rgba(249, 115, 22, 0.1)',
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
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    // =============================================
    // RABIES GEOMAP - Dasmariñas City, Cavite
    // =============================================
    
    // Pass heatmap data from controller
    const heatmapData = @json($heatmapData ?? []);
    
    // Convert to lookup by barangay name
    const barangayCaseData = {};
    let totalCases = 0;
    heatmapData.forEach(item => {
        const name = (item.barangay || item.name || '').toLowerCase().trim();
        barangayCaseData[name] = item.count || 0;
        totalCases += item.count || 0;
    });
    console.log('Dashboard heatmap data loaded:', Object.keys(barangayCaseData).length, 'barangays');
    
    // Initialize Leaflet Map - Dasmariñas City Center
    const mapCenter = [14.3270, 120.9370]; // Dasmariñas City Center
    
    const map = L.map('dashboard-map', {
        zoomControl: true,
        minZoom: 10,
        maxZoom: 18
    }).setView(mapCenter, 12);
    
    // Add OpenStreetMap tile layer - reliable and shows roads/labels clearly
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 19
    }).addTo(map);
    
    // GLOBAL VARIABLES
    let barangayLayer = null;
    let barangayPolygons = null;
    let selectedBarangayLayer = null;  // Currently selected barangay highlight
    let selectedBarangayName = null;  // Track selected barangay
    let spotlightEnabled = true;  // Enable/disable spotlight effect
    let cityBoundaryGeoJSON = null;  // Store city boundary for mask creation
    let outsideMaskLayer = null;  // Mask layer for outside barangay area
    
    // Loading state management
    const loadingEl = document.getElementById('dashboard-map-loading');
    const mapEl = document.getElementById('dashboard-map');
    
    function hideMapLoading() {
        if (loadingEl) {
            loadingEl.style.opacity = '0';
            setTimeout(() => {
                loadingEl.style.display = 'none';
            }, 300);
        }
    }
    
    // Create outside mask - dark overlay outside city boundary
    // Hides everything OUTSIDE the main Dasmariñas city border
    function createOutsideMask() {
        if (!cityBoundaryGeoJSON) {
            console.log('Cannot create mask: missing city boundary data');
            return;
        }

        // Remove existing mask if any
        if (outsideMaskLayer) {
            map.removeLayer(outsideMaskLayer);
        }

        try {
            const cityFeatures = cityBoundaryGeoJSON.features;
            if (!cityFeatures || cityFeatures.length === 0) {
                console.log('No city boundary features found');
                return;
            }

            // Extract city boundary as hole (reversed)
            const cityHoles = [];
            cityFeatures.forEach(feature => {
                const geomType = feature.geometry.type;
                const coords = feature.geometry.coordinates;

                if (geomType === 'Polygon') {
                    const outerRing = coords[0].slice().reverse();
                    cityHoles.push(outerRing);
                } else if (geomType === 'MultiPolygon') {
                    coords.forEach(polygon => {
                        const outerRing = polygon[0].slice().reverse();
                        cityHoles.push(outerRing);
                    });
                }
            });

            if (cityHoles.length === 0) {
                console.log('No city boundary for mask');
                return;
            }

            // Create large outer rectangle covering everything outside city
            const bounds = map.getBounds();
            const south = bounds.getSouth();
            const north = bounds.getNorth();
            const west = bounds.getWest();
            const east = bounds.getEast();

            const outerPadding = 10;
            const outerRing = [
                [south - outerPadding, west - outerPadding],
                [south - outerPadding, east + outerPadding],
                [north + outerPadding, east + outerPadding],
                [north + outerPadding, west - outerPadding],
                [south - outerPadding, west - outerPadding]
            ];

            // Mask: outer ring with city boundary as hole
            // This hides everything OUTSIDE the city
            const maskFeature = {
                type: 'Feature',
                geometry: {
                    type: 'Polygon',
                    coordinates: [outerRing, ...cityHoles]
                }
            };

            // Add dark mask layer
            outsideMaskLayer = L.geoJSON(maskFeature, {
                fillColor: '#1f2937',
                fillOpacity: 0.2,
                color: 'transparent',
                weight: 0,
                interactive: false
            }).addTo(map);

            // Layer ordering: Tiles -> Mask -> Barangays
            map.eachLayer(function(layer) {
                if (layer instanceof L.TileLayer) {
                    layer.bringToBack();
                }
            });
            outsideMaskLayer.bringToBack();
            if (barangayLayer) {
                barangayLayer.bringToFront();
            }

            console.log('Outside mask created - hides areas outside city boundary');
        } catch (error) {
            console.error('Error creating outside mask:', error);
        }
    }
    
    // Color function
    function getFillColor(cases) {
        if (cases === 0) return '#dbeafe';
        if (cases <= 2) return '#86efac';
        if (cases <= 5) return '#fbbf24';
        return '#ef4444';
    }
    
    // Style function - lightweight focus effect using border weight and opacity
    function style(feature) {
        const cases = barangayCaseData[(feature.properties.name || '').toLowerCase().trim()] || 0;
        return {
            fillColor: getFillColor(cases),
            fillOpacity: spotlightEnabled ? 0.35 : 0.25,
            color: '#64748b',   // Slate border color
            weight: spotlightEnabled ? 2.5 : 1.5,        // Thicker borders for better clickability
            opacity: spotlightEnabled ? 0.9 : 0.6,
            fill: true,
            stroke: true,
            interactive: true  // Ensure fill area is clickable
        };
    }
    
    // Hover style - light highlight
    function hoverStyle(feature) {
        return {
            fillOpacity: 0.4,
            weight: 1.5,
            color: '#64748b'
        };
    }
    
    // Toggle spotlight effect - lightweight focus using styling
    function toggleSpotlight(enabled) {
        spotlightEnabled = enabled;
        
        // Recreate barangay layer with new styling
        if (barangayLayer && barangayPolygons) {
            map.removeLayer(barangayLayer);
            
            barangayLayer = L.geoJSON(barangayPolygons, {
                style: style,
                onEachFeature: function(feature, layer) {
                    layer.on({
                        mouseover: function(e) {
                            var layer = e.target;
                            layer.setStyle(hoverStyle(feature));
                        },
                        mouseout: function(e) {
                            var layer = e.target;
                            layer.setStyle(style(feature));
                        },
                        click: function(e) {
                            map.fitBounds(e.target.getBounds());
                        }
                    });
                    
                    // Add popup
                    if (feature.properties && feature.properties.name) {
                        layer.bindPopup(createPopupContent(feature));
                    }
                }
            }).addTo(map);
            
            // Bring barangay layer to below heatmap but above tiles
            barangayLayer.bringToBack();
            
            // Ensure tile layer stays at the bottom
            map.eachLayer(function(layer) {
                if (layer instanceof L.TileLayer) {
                    layer.bringToBack();
                }
            });
        }
    }
    
    // Popup content
    function createPopupContent(feature) {
        const name = feature.properties.name || 'Unknown';
        const cases = barangayCaseData[name.toLowerCase().trim()] || 0;
        const status = cases === 0 ? 'Clear' : (cases <= 2 ? 'Low' : (cases <= 5 ? 'Medium' : 'High'));
        const statusColor = cases === 0 ? '#16a34a' : (cases <= 2 ? '#16a34a' : (cases <= 5 ? '#d97706' : '#dc2626'));
        
        return `
            <div style="min-width: 160px; font-family: system-ui, sans-serif;">
                <h3 style="margin: 0 0 10px 0; color: #1e40af; font-size: 15px; font-weight: 600; padding-bottom: 8px; border-bottom: 1px solid #e5e7eb;">
                    <i class="bi bi-geo-alt mr-1"></i>${name}
                </h3>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="color: #6b7280; font-size: 13px;">Rabies Cases:</span>
                    <span style="color: ${statusColor}; font-weight: 700; font-size: 18px;">${cases}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 6px;">
                    <span style="color: #6b7280; font-size: 13px;">Status:</span>
                    <span style="color: ${statusColor}; font-weight: 600; font-size: 13px;">${status}</span>
                </div>
            </div>
        `;
    }
    
    // On each feature - add popup, hover effects, and click-to-focus
    function onEachFeature(feature, layer) {
        layer.bindPopup(createPopupContent(feature));
        
        // Add click handler for auto-focus
        layer.on({
            click: function(e) {
                // Stop event propagation
                e.originalEvent.stopPropagation();
                
                // Get the clicked layer
                const clickedLayer = e.target;
                const featureName = feature.properties.name || 'Unknown';
                
                // If clicking the same barangay, just show popup
                if (selectedBarangayName === featureName) {
                    return;
                }
                
                // Clear previous selection
                clearBarangaySelection();
                
                // Store selected barangay name
                selectedBarangayName = featureName;
                
                // Highlight the selected barangay with strong border
                clickedLayer.setStyle({
                    fillOpacity: 0.6,
                    weight: 3,
                    color: '#6366f1',
                    opacity: 1
                });
                
                // Bring to front
                clickedLayer.bringToFront();
                
                // Store reference
                selectedBarangayLayer = clickedLayer;
                
                // Dim all other features
                window.dashboardBarangayLayer.eachLayer(function(l) {
                    if (l !== clickedLayer) {
                        l.setStyle({
                            fillOpacity: 0.08,
                            weight: 0.5,
                            opacity: 0.2
                        });
                    }
                });
                
                // Smooth zoom to the clicked barangay
                const bounds = clickedLayer.getBounds();
                map.fitBounds(bounds, {
                    padding: [50, 50],
                    maxZoom: 15,
                    animate: true,
                    duration: 0.8
                });
            }
        });
        
        // Add hover effects - focus on this barangay, dim others
        layer.on({
            mouseover: function(e) {
                // Skip if this is the selected barangay
                if (selectedBarangayName === feature.properties.name) return;
                
                const targetLayer = e.target;
                
                // Bring the hovered layer to front
                targetLayer.bringToFront();
                
                // Apply highlight style to this feature
                targetLayer.setStyle({
                    fillOpacity: 0.5,
                    weight: 2,
                    color: '#1e40af',
                    opacity: 1
                });
                
                // Dim all other features (but not selected)
                window.dashboardBarangayLayer.eachLayer(function(l) {
                    const layerName = l.feature ? (l.feature.properties.name || '') : '';
                    if (l !== targetLayer && layerName !== selectedBarangayName) {
                        l.setStyle({
                            fillOpacity: 0.1,
                            weight: 0.5,
                            opacity: 0.3
                        });
                    }
                });
            },
            mouseout: function(e) {
                if (window.dashboardBarangayLayer) {
                    // Skip reset if this is the selected barangay
                    if (selectedBarangayName === feature.properties.name) return;
                    
                    window.dashboardBarangayLayer.resetStyle(e.target);
                    
                    // Restore all layers to normal (except selected)
                    window.dashboardBarangayLayer.eachLayer(function(l) {
                        const layerName = l.feature ? (l.feature.properties.name || '') : '';
                        if (layerName !== selectedBarangayName) {
                            l.setStyle({
                                fillOpacity: spotlightEnabled ? 0.35 : 0.25,
                                weight: spotlightEnabled ? 2 : 1,
                                opacity: spotlightEnabled ? 0.9 : 0.6
                            });
                        }
                    });
                }
            }
        });
    }
    
    // Clear barangay selection
    function clearBarangaySelection() {
        if (selectedBarangayLayer && window.dashboardBarangayLayer) {
            // Reset the previously selected layer
            window.dashboardBarangayLayer.resetStyle(selectedBarangayLayer);
            selectedBarangayLayer = null;
        }
        selectedBarangayName = null;
        
        // Restore all layers to normal
        if (window.dashboardBarangayLayer) {
            window.dashboardBarangayLayer.eachLayer(function(layer) {
                layer.setStyle({
                    fillOpacity: spotlightEnabled ? 0.35 : 0.25,
                    weight: spotlightEnabled ? 2 : 1,
                    opacity: spotlightEnabled ? 0.9 : 0.6
                });
            });
        }
    }
    
    // Click on map to clear selection
    map.on('click', function() {
        clearBarangaySelection();
    });
    
    // Load city boundary
    fetch('/geojson/dasmarinas-city-boundary.geojson')
        .then(res => {
            if (!res.ok) throw new Error('City boundary GeoJSON not found');
            return res.json();
        })
        .then(boundary => {
            // Get city bounds
            const cityGeo = L.geoJSON(boundary);
            const bounds = cityGeo.getBounds();
            map.fitBounds(bounds, { padding: [30, 30] });
            
            // Store city boundary GeoJSON for mask creation
            cityBoundaryGeoJSON = {
                type: 'FeatureCollection',
                features: boundary.features ? boundary.features.filter(f => 
                    f.geometry.type === 'Polygon' || f.geometry.type === 'MultiPolygon'
                ) : []
            };
            
            // Add city boundary as subtle background - very transparent
            const cityBoundaryPolys = {
                type: 'FeatureCollection',
                features: boundary.features ? boundary.features.filter(f => 
                    f.geometry.type === 'Polygon' || f.geometry.type === 'MultiPolygon'
                ) : []
            };
            L.geoJSON(cityBoundaryPolys, {
                fillColor: '#e5e7eb',
                fillOpacity: 0.15,
                color: '#cbd5e1',
                weight: 1,
                opacity: 0.4
            }).addTo(map);
        })
        .catch(err => {
            console.log('Error loading city boundary:', err);
            hideMapLoading();
        });
    
    // Load barangay boundaries
    fetch('/geojson/barangays/dasmarinas-barangays.geojson')
        .then(res => {
            if (!res.ok) throw new Error('Barangay GeoJSON not found');
            return res.json();
        })
        .then(geojson => {
            // Filter to only Polygon and MultiPolygon
            const polygons = {
                type: 'FeatureCollection',
                features: geojson.features.filter(f => {
                    const type = f.geometry.type;
                    return type === 'Polygon' || type === 'MultiPolygon';
                })
            };
            
            // Store polygons globally for spotlight toggle
            barangayPolygons = polygons;
            
            // Add barangays to map with proper layer ordering
            // Filter to only Polygon and MultiPolygon - exclude Points to remove markers
            var polyOnly = {
                type: 'FeatureCollection',
                features: polygons.features.filter(function(f) {
                    return f.geometry.type === 'Polygon' || f.geometry.type === 'MultiPolygon';
                })
            };
            
            barangayLayer = L.geoJSON(polyOnly, {
                style: style,
                onEachFeature: onEachFeature,
                pointToLayer: function(feature, latlng) {
                    return null; // Don't create markers for point geometries
                }
            }).addTo(map);
            
            // Also store in window for compatibility
            window.dashboardBarangayLayer = barangayLayer;
            
            // CRITICAL: Push GeoJSON to back so tile layer (roads/labels) stays on top
            window.dashboardBarangayLayer.bringToBack();
            
            // Re-add tile layer to ensure it's on top
            map.eachLayer(function(layer) {
                if (layer instanceof L.TileLayer) {
                    layer.bringToFront();
                }
            });
            
            // Hide loading, show map
            hideMapLoading();
            
            // Create outside mask to hide areas outside city boundary
            createOutsideMask();
        })
        .catch(err => {
            console.log('Error loading barangay GeoJSON:', err);
            hideMapLoading();
        });
    
    // Add zoom control
    L.control.zoom({ position: 'topright' }).addTo(map);
});
</script>
@endpush
@endsection
