@extends('layouts.admin')

@section('title', 'Exposure Case Map')
@section('header', 'Exposure Case Distribution Map')
@section('subheader', 'Dasmariñas City Disease Surveillance')

@php
    $currentYear = 2026;
    $selectedYear = (int) ($year ?? $currentYear);
    $years = range($currentYear, $currentYear - 5);
    $months = [
        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
    ];
@endphp

@section('content')
<div class="relative w-full" style="height: calc(100vh - 64px);">
    <div id="geomap" class="w-full h-full" style="z-index: 1; position: relative !important;" role="application" aria-label="Exposure cases geomap">
        <div class="h-full flex items-center justify-center bg-slate-100">
            <div class="text-center">
                <div class="inline-block animate-pulse w-10 h-10 bg-slate-200 rounded-full mb-3"></div>
                <p class="text-sm text-slate-400">Initializing map...</p>
            </div>
        </div>
    </div>

    <div class="absolute top-3 left-3 z-[1000] flex items-center gap-2 backdrop-blur bg-white/90 rounded-lg px-3 py-2 shadow-sm border border-slate-200/60">
        <div class="flex items-center gap-2 pr-4 border-r border-slate-200/60">
            <div class="w-8 h-8 bg-green-50 rounded-md flex items-center justify-center">
                <i class="bi bi-map text-green-600 text-sm"></i>
            </div>
            <div class="hidden sm:block min-w-[120px]">
                <p class="text-xs font-semibold text-slate-700 leading-tight">Geographic Distribution</p>
                <p class="text-[10px] text-green-600 font-bold leading-tight" id="mapSubtitle">{{ $selectedYear }}</p>
            </div>
        </div>
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.away="open = false" class="filter-btn" id="yearFilterBtn">
                <i class="bi bi-calendar3 text-[10px]"></i>
                <span id="yearLabel">{{ $selectedYear }}</span>
                <i class="bi bi-chevron-down text-[8px] opacity-40"></i>
            </button>
            <div x-show="open" x-transition class="filter-menu">
                @foreach($years as $y)
                <button onclick="setFilter('year', {{ $y }})" class="filter-menu-item {{ $y == $selectedYear ? 'active' : '' }}">{{ $y }}</button>
                @endforeach
            </div>
        </div>
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.away="open = false" class="filter-btn" id="monthFilterBtn">
                <i class="bi bi-calendar-range text-[10px]"></i>
                <span id="monthLabel">All Months</span>
                <i class="bi bi-chevron-down text-[8px] opacity-40"></i>
            </button>
            <div x-show="open" x-transition class="filter-menu">
                <button onclick="setFilter('month', null)" class="filter-menu-item active" data-month="all">All Months</button>
                @foreach($months as $num => $name)
                <button onclick="setFilter('month', {{ $num }})" class="filter-menu-item" data-month="{{ $num }}">{{ $name }}</button>
                @endforeach
            </div>
        </div>
        <div class="w-px h-5 bg-slate-200/60"></div>
        <button id="resetViewBtn" class="inline-flex items-center gap-1 px-2.5 py-1.5 text-[11px] font-medium text-slate-500 hover:text-slate-700 hover:bg-slate-100/80 rounded-md transition">
            <i class="bi bi-arrows-fullscreen text-[10px]"></i> Reset
        </button>
    </div>

    <div class="absolute top-3 right-3 z-[1000] flex items-center gap-2 map-ui-layer">
        <div class="backdrop-blur bg-white/90 rounded-lg px-3 py-2 shadow-sm border border-slate-200/60 flex items-center gap-3">
            <div class="flex items-center gap-1.5">
                <div class="w-2 h-2 rounded-full bg-yellow-500"></div>
                <span class="text-[10px] text-slate-400 font-medium">Bite</span>
                <span class="text-sm font-bold text-slate-800" id="statBite">0</span>
            </div>
            <div class="w-px h-4 bg-slate-200"></div>
            <div class="flex items-center gap-1.5">
                <div class="w-2 h-2 rounded-full bg-orange-500"></div>
                <span class="text-[10px] text-slate-400 font-medium">Suspected</span>
                <span class="text-sm font-bold text-orange-600" id="statSuspected">0</span>
            </div>
            <div class="w-px h-4 bg-slate-200"></div>
            <div class="flex items-center gap-1.5">
                <div class="w-2 h-2 rounded-full bg-red-500"></div>
                <span class="text-[10px] text-slate-400 font-medium">Confirmed</span>
                <span class="text-sm font-bold text-red-600" id="statConfirmed">0</span>
            </div>
        </div>
    </div>

    <div class="absolute bottom-3 right-3 z-[1000] backdrop-blur bg-white/90 rounded-lg px-3 py-2 shadow-sm border border-slate-200/60">
        <div class="flex items-center gap-4 text-xs">
            <div class="flex items-center gap-1.5">
                <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                <span class="text-slate-600">Bite</span>
            </div>
            <div class="flex items-center gap-1.5">
                <div class="w-3 h-3 rounded-full bg-orange-500"></div>
                <span class="text-slate-600">Suspected</span>
            </div>
            <div class="flex items-center gap-1.5">
                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                <span class="text-slate-600">Confirmed</span>
            </div>
        </div>
    </div>

    <div id="mapLoading" class="absolute inset-0 bg-white/90 flex items-center justify-center z-[1004]" style="display: none;">
        <div class="text-center">
            <div class="inline-block animate-spin rounded-full h-10 w-10 border-[3px] border-indigo-500 border-t-transparent"></div>
            <p class="mt-3 text-sm text-slate-500 font-medium">Loading map data...</p>
        </div>
    </div>

    <div id="mapError" class="hidden absolute top-16 left-1/2 -translate-x-1/2 z-[60]">
        <div class="backdrop-blur bg-red-50/95 border border-red-200 rounded-lg px-4 py-3 shadow-sm flex items-center gap-3">
            <i class="bi bi-exclamation-triangle text-red-500"></i>
            <div>
                <p class="text-sm font-medium text-red-800" id="errorTitle">Error loading map</p>
                <p class="text-xs text-red-600" id="errorMessage">Please refresh the page.</p>
            </div>
            <button onclick="location.reload()" class="px-2.5 py-1 bg-red-100 hover:bg-red-200 text-red-700 rounded-md text-xs font-medium transition">Retry</button>
        </div>
    </div>
</div>

<style>
    .leaflet-container { height: 100% !important; width: 100% !important; font-family: 'Inter', system-ui, sans-serif; }
    .leaflet-control { z-index: 1001 !important; }
    .leaflet-popup { z-index: 1003 !important; }
    .leaflet-tooltip { z-index: 1003 !important; }
    .leaflet-popup-content-wrapper { border-radius: 10px; box-shadow: 0 4px 16px rgba(0,0,0,0.12); }
    .leaflet-popup-content { margin: 14px; font-family: 'Inter', system-ui, sans-serif; }

    @keyframes spin { to { transform: rotate(360deg); } }
    .animate-spin { animation: spin 0.8s linear infinite; }

    .filter-btn {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 4px 8px; background: transparent; border: 1px solid #e2e8f0;
        border-radius: 6px; font-size: 11px; color: #475569; font-weight: 500;
        cursor: pointer; transition: all 0.15s; white-space: nowrap;
    }
    .filter-btn:hover { background: #f8fafc; border-color: #cbd5e1; }
    .filter-btn.active { background: #eef2ff; border-color: #a5b4fc; color: #4338ca; }

    .filter-menu {
        position: absolute; top: calc(100% + 4px); left: 0;
        background: #fff; border: 1px solid #e2e8f0; border-radius: 8px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.1); padding: 3px;
        min-width: 120px; max-height: 280px; overflow-y: auto; z-index: 1005;
    }
    .filter-menu-item {
        display: block; width: 100%; padding: 5px 9px; text-align: left;
        font-size: 11px; color: #475569; border-radius: 5px; border: none;
        background: none; cursor: pointer; transition: all 0.1s;
    }
    .filter-menu-item:hover { background: #f1f5f9; }
    .filter-menu-item.active { background: #eef2ff; color: #4338ca; font-weight: 600; }

    .map-ui-layer { pointer-events: auto; }
    .map-ui-layer * { pointer-events: auto; }
</style>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var filters = { year: {{ $selectedYear }}, month: null };
    var map, barangayLayer, cityBounds, geojsonData;
    var markers = [];

    map = L.map('geomap', {
        zoomControl: true, minZoom: 12, maxZoom: 18, zoomSnap: 0.5, worldCopyJump: false
    }).setView([14.3270, 120.9370], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap', maxZoom: 19
    }).addTo(map);

    var fallback = document.querySelector('#geomap > div');
    if (fallback) fallback.style.display = 'none';
    setTimeout(function() { map.invalidateSize(); }, 100);

    function getColor(type, count) {
        if (count === 0) return '#cbd5e1';
        switch(type) {
            case 'confirmed': return '#dc2626';
            case 'suspected': return '#f97316';
            case 'bite': return '#eab308';
            default: return '#22c55e';
        }
    }

    function createMarker(lat, lng, data) {
        var total = data.bite_count + data.suspected_count + data.confirmed_count;
        var color = '#3b82f6';
        var label = 'Bite Cases';
        
        if (data.confirmed_count > 0) {
            color = '#dc2626';
            label = 'Confirmed Rabies';
        } else if (data.suspected_count > 0) {
            color = '#f97316';
            label = 'Suspected Rabies';
        } else if (data.bite_count > 0) {
            color = '#eab308';
            label = 'Bite Cases';
        }

        var marker = L.circleMarker([lat, lng], {
            radius: Math.max(6, Math.min(20, total * 2)),
            fillColor: color,
            color: '#fff',
            weight: 2,
            opacity: 1,
            fillOpacity: 0.8
        });

        marker.bindTooltip(
            '<div style="font-family:Inter,system-ui;min-width:140px;">' +
            '<div style="font-size:13px;font-weight:600;color:#1e293b;margin-bottom:4px;">' + data.barangay + '</div>' +
            '<div style="display:flex;justify-content:space-between;margin:2px 0;"><span style="color:#eab308;">● Bite</span><span style="font-weight:600;">' + data.bite_count + '</span></div>' +
            '<div style="display:flex;justify-content:space-between;margin:2px 0;"><span style="color:#f97316;">● Suspected</span><span style="font-weight:600;">' + data.suspected_count + '</span></div>' +
            '<div style="display:flex;justify-content:space-between;margin:2px 0;"><span style="color:#dc2626;">● Confirmed</span><span style="font-weight:600;">' + data.confirmed_count + '</span></div>' +
            '<div style="font-size:11px;color:#64748b;margin-top:4px;padding-top:4px;border-top:1px solid #e2e8f0;">Total: ' + total + ' cases</div>' +
            '</div>',
            { direction: 'center', className: '', offset: [0, 0], pane: 'popupPane' }
        );

        return marker;
    }

    fetch('/geojson/dasmarinas-city-boundary.geojson')
        .then(function(r) { return r.json(); })
        .then(function(boundary) {
            var polys = { type: 'FeatureCollection', features: boundary.features.filter(function(f) { return f.geometry.type === 'Polygon' || f.geometry.type === 'MultiPolygon'; }) };
            L.geoJSON(polys, { fillColor: 'transparent', color: '#334155', weight: 2.5, opacity: 1 }).addTo(map);
            cityBounds = L.geoJSON(polys).getBounds();
            map.setMaxBounds(cityBounds);
            map.fitBounds(cityBounds);
            map.on('drag', function() { map.panInsideBounds(cityBounds, { animate: false }); });
        });

    fetch('/geojson/barangays/dasmarinas-barangays.geojson')
        .then(function(r) { return r.json(); })
        .then(function(geojson) { geojsonData = geojson; fetchFilteredData(); })
        .catch(function(err) {
            console.error('GeoJSON Error:', err);
            document.getElementById('mapError').classList.remove('hidden');
        });

    function fetchFilteredData() {
        showLoading(true);
        var params = new URLSearchParams();
        params.append('year', filters.year);
        if (filters.month) params.append('month', filters.month);

        fetch('/exposure-map/data?' + params.toString())
            .then(function(r) { return r.json(); })
            .then(function(data) {
                updateMap(data.heatmapData);
                updateStats(data.stats);
                document.getElementById('mapSubtitle').textContent = data.filterLabel;
                showLoading(false);
            })
            .catch(function(err) {
                console.error('Data Error:', err);
                showLoading(false);
                document.getElementById('mapError').classList.remove('hidden');
            });
    }

    function updateMap(heatmapData) {
        markers.forEach(function(m) { map.removeLayer(m); });
        markers = [];

        heatmapData.forEach(function(data) {
            if (data.count > 0) {
                var marker = createMarker(data.latitude, data.longitude, data);
                marker.addTo(map);
                markers.push(marker);
            }
        });
    }

    function updateStats(stats) {
        document.getElementById('statBite').textContent = stats.bites;
        document.getElementById('statSuspected').textContent = stats.suspected;
        document.getElementById('statConfirmed').textContent = stats.confirmed;
    }

    function showLoading(show) {
        var el = document.getElementById('mapLoading');
        if (el) el.style.display = show ? 'flex' : 'none';
    }

    window.setFilter = function(type, value) {
        filters[type] = value;
        if (type === 'year') {
            document.getElementById('yearLabel').textContent = value;
            document.getElementById('yearFilterBtn').classList.add('active');
        }
        if (type === 'month') {
            var m = ['','January','February','March','April','May','June','July','August','September','October','November','December'];
            document.getElementById('monthLabel').textContent = value ? m[value] : 'All Months';
            document.getElementById('monthFilterBtn').classList.toggle('active', !!value);
        }
        updateDropdownActiveStates();
        fetchFilteredData();
    };

    function updateDropdownActiveStates() {
        document.querySelectorAll('[data-month]').forEach(function(el) {
            el.classList.toggle('active', filters.month === null ? el.dataset.month === 'all' : parseInt(el.dataset.month) === filters.month);
        });
    }

    document.getElementById('resetViewBtn').addEventListener('click', function() {
        if (cityBounds) map.fitBounds(cityBounds);
    });

    document.getElementById('yearFilterBtn').classList.add('active');
});
</script>
@endsection