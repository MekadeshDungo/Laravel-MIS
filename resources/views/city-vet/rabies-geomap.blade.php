@extends('layouts.admin')

@section('title', 'Rabies Geomap')
@section('header', '')
@section('subheader', '')

@php
    $currentYear = date('Y');
    $selectedYear = (int) ($year ?? $currentYear);
    $years = range($currentYear, $currentYear - 5);
    $months = [
        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
    ];

    $totalCases = collect($heatmapData)->sum('count');
    $activeBarangays = collect($heatmapData)->where('count', '>', 0)->count();
    $criticalCount = collect($heatmapData)->where('count', '>', 20)->count();
@endphp

@section('content')
{{-- Full-bleed map container --}}
<div class="relative w-full" style="height: calc(100vh - 64px);">

    {{-- Map --}}
    <div id="geomap" class="w-full h-full" style="z-index: 1; position: relative !important;" role="application" aria-label="Rabies cases geomap">
        <div class="h-full flex items-center justify-center bg-slate-100">
            <div class="text-center">
                <div class="inline-block animate-pulse w-10 h-10 bg-slate-200 rounded-full mb-3"></div>
                <p class="text-sm text-slate-400">Initializing map...</p>
            </div>
        </div>
    </div>

    {{-- Filter Bar (centered, below header) --}}
    <div class="absolute top-16 left-1/2 -translate-x-1/2 z-[1000] map-ui-layer">
        <div class="flex items-center gap-3 backdrop-blur-xl bg-white/95 rounded-2xl px-5 py-2.5 shadow-lg border border-slate-200/60">
            <div class="flex items-center gap-2 pr-4 border-r border-slate-200/60">
                <div class="w-9 h-9 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center shadow-sm">
                    <i class="bi bi-map text-white text-sm"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-700 leading-tight">Distribution</p>
                    <p class="text-[10px] text-green-600 font-bold leading-tight" id="mapSubtitle">{{ $selectedYear }}</p>
                </div>
            </div>

            {{-- Year --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" @click.away="open = false" class="filter-btn" id="yearFilterBtn">
                    <i class="bi bi-calendar3 text-[10px] text-green-600"></i>
                    <span id="yearLabel">{{ $selectedYear }}</span>
                    <i class="bi bi-chevron-down text-[8px] opacity-40"></i>
                </button>
                <div x-show="open" x-transition class="filter-menu">
                    @foreach($years as $y)
                    <button onclick="setFilter('year', {{ $y }})" class="filter-menu-item {{ $y == $selectedYear ? 'active' : '' }}">{{ $y }}</button>
                    @endforeach
                </div>
            </div>

            {{-- Month --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" @click.away="open = false" class="filter-btn" id="monthFilterBtn">
                    <i class="bi bi-calendar-range text-[10px] text-blue-500"></i>
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

            {{-- Week --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" @click.away="open = false" class="filter-btn" id="weekFilterBtn">
                    <i class="bi bi-clock-history text-[10px] text-purple-500"></i>
                    <span id="weekLabel">All Weeks</span>
                    <i class="bi bi-chevron-down text-[8px] opacity-40"></i>
                </button>
                <div x-show="open" x-transition class="filter-menu max-h-[260px]">
                    <button onclick="setFilter('week', null)" class="filter-menu-item active" data-week="all">All Weeks</button>
                    @for($w = 1; $w <= 53; $w++)
                    <button onclick="setFilter('week', {{ $w }})" class="filter-menu-item" data-week="{{ $w }}">Week {{ $w }}</button>
                    @endfor
                </div>
            </div>

            <div class="w-px h-5 bg-slate-200/60"></div>

            {{-- Date From --}}
            <div>
                <input type="date" id="dateFrom" class="filter-btn px-3 py-1.5 text-[11px] bg-slate-50" placeholder="From">
            </div>

            {{-- Date To --}}
            <div>
                <input type="date" id="dateTo" class="filter-btn px-3 py-1.5 text-[11px] bg-slate-50" placeholder="To">
            </div>

            <button onclick="applyDateFilter()" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[11px] font-medium bg-green-500 text-white hover:bg-green-600 rounded-lg shadow-sm transition">
                <i class="bi bi-funnel text-[10px]"></i> Filter
            </button>

            <button id="resetViewBtn" class="inline-flex items-center gap-1 px-2.5 py-1.5 text-[11px] font-medium text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-md transition">
                <i class="bi bi-arrow-counterclockwise text-[10px]"></i>
            </button>
        </div>

        {{-- Active Filter Tags (below bar) --}}
        <div id="filterSummary" class="hidden mt-2">
            <div class="backdrop-blur bg-white/90 rounded-lg px-3 py-1.5 shadow-sm border border-slate-200/60 flex items-center gap-1.5">
                <div id="filterTags" class="flex items-center gap-1.5"></div>
                <button onclick="clearAllFilters()" class="text-[10px] text-indigo-600 hover:text-indigo-800 font-medium ml-1">Clear</button>
            </div>
        </div>
    </div>

    {{-- Floating: Stats Pills (top-right) --}}
    <div class="absolute top-16 right-4 z-[1000] flex items-center gap-2 map-ui-layer">
        <div class="backdrop-blur bg-white/90 rounded-lg px-3 py-2 shadow-sm border border-slate-200/60 flex items-center gap-3">
            <div class="flex items-center gap-1.5">
                <div class="w-2 h-2 rounded-full bg-red-500"></div>
                <span class="text-[10px] text-slate-400 font-medium">Total</span>
                <span class="text-sm font-bold text-slate-800" id="statTotalCases">{{ $totalCases }}</span>
            </div>
            <div class="w-px h-4 bg-slate-200"></div>
            <div class="flex items-center gap-1.5">
                <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                <span class="text-[10px] text-slate-400 font-medium">Affected</span>
                <span class="text-sm font-bold text-amber-600" id="statAffected">{{ $activeBarangays }}</span>
            </div>
            <div class="w-px h-4 bg-slate-200"></div>
            <div class="flex items-center gap-1.5">
                <div class="w-2 h-2 rounded-full bg-rose-500"></div>
                <span class="text-[10px] text-slate-400 font-medium">Critical</span>
                <span class="text-sm font-bold text-rose-600" id="statCritical">{{ $criticalCount }}</span>
            </div>
        </div>
    </div>

    {{-- Floating: Legend (bottom-right) --}}
    <x-map-legend :time-filter="'Yearly'" />

    {{-- Loading Overlay --}}
    <div id="mapLoading" class="absolute inset-0 bg-white/90 flex items-center justify-center z-[1004]" style="display: none;">
        <div class="text-center">
            <div class="inline-block animate-spin rounded-full h-10 w-10 border-[3px] border-indigo-500 border-t-transparent"></div>
            <p class="mt-3 text-sm text-slate-500 font-medium">Loading map data...</p>
        </div>
    </div>

    {{-- Error --}}
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

{{-- Styles --}}
<style>
    .leaflet-container { height: 100% !important; width: 100% !important; font-family: 'Inter', system-ui, sans-serif; }
    .leaflet-control { z-index: 1001 !important; }
    .leaflet-popup { z-index: 1003 !important; }
    .leaflet-tooltip { z-index: 1003 !important; }
    .leaflet-popup-content-wrapper { border-radius: 10px; box-shadow: 0 4px 16px rgba(0,0,0,0.12); }
    .leaflet-popup-content { margin: 14px; font-family: 'Inter', system-ui, sans-serif; }
    .leaflet-tooltip-wrap { z-index: 1003 !important; }

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

    .filter-tag {
        display: inline-flex; align-items: center; gap: 3px;
        padding: 1px 7px; background: #eef2ff; color: #4338ca;
        border-radius: 10px; font-size: 10px; font-weight: 600;
    }
    .filter-tag button {
        display: flex; align-items: center; justify-content: center;
        width: 12px; height: 12px; background: rgba(67,56,202,0.12);
        border: none; border-radius: 50%; color: #4338ca;
        cursor: pointer; font-size: 8px; line-height: 1;
    }
    .filter-tag button:hover { background: rgba(67,56,202,0.25); }

    .map-ui-layer { pointer-events: auto; }
    .map-ui-layer * { pointer-events: auto; }
    .map-ui-layer button, .map-ui-layer a { pointer-events: auto; }

    @media (max-width: 768px) {
        .leaflet-control-zoom { display: none; }
    }
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
    var filters = { year: {{ $selectedYear }}, month: null, week: null };
    var map, barangayLayer, outsideMaskLayer, cityBounds, geojsonData;

    map = L.map('geomap', {
        zoomControl: true, minZoom: 12, maxZoom: 18, zoomSnap: 0.5, worldCopyJump: false
    }).setView([14.3270, 120.9370], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap', maxZoom: 19
    }).addTo(map);

    var fallback = document.querySelector('#geomap > div');
    if (fallback) fallback.style.display = 'none';
    setTimeout(function() { map.invalidateSize(); }, 100);

    function getColor(cases) {
        return cases > 20 ? '#dc2626' : cases > 10 ? '#ea580c' : cases > 5 ? '#eab308' : cases > 0 ? '#3b82f6' : '#cbd5e1';
    }
    function getBorderColor(cases) { return cases > 0 ? '#1e293b' : '#94a3b8'; }

    function style(feature) {
        var c = feature.properties.cases || 0;
        return { fillColor: getColor(c), weight: c > 0 ? 2.5 : 1.5, color: getBorderColor(c), fillOpacity: c > 0 ? 0.8 : 0.45, opacity: 1 };
    }

    function highlightFeature(e) {
        e.target.setStyle({ weight: 4, color: '#4338ca', fillOpacity: 0.55 });
        e.target.bringToFront();
    }
    function resetHighlight(e) {
        var c = e.target.feature.properties.cases || 0;
        e.target.setStyle({ weight: c > 0 ? 2.5 : 1.5, color: getBorderColor(c), fillOpacity: c > 0 ? 0.8 : 0.45 });
    }

    function onEachFeature(feature, layer) {
        var name = feature.properties.name || 'Unknown';
        var cases = feature.properties.cases || 0;
        var status = cases > 20 ? 'Critical' : cases > 10 ? 'High' : cases > 5 ? 'Moderate' : cases > 0 ? 'Low' : 'No Cases';

        layer.bindTooltip(
            '<div style="font-family:Inter,system-ui;min-width:110px;">' +
            '<div style="font-size:13px;font-weight:600;color:#1e293b;margin-bottom:2px;">' + name + '</div>' +
            '<div style="font-size:20px;font-weight:700;color:' + getColor(cases) + ';">' + cases + '</div>' +
            '<div style="font-size:10px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;margin-top:1px;">' + status + '</div>' +
            '</div>',
            { direction: 'center', className: '', offset: [0, 0], pane: 'popupPane' }
        );
        layer.on({ mouseover: highlightFeature, mouseout: resetHighlight });
    }

    function createOutsideMask(bounds) {
        var s = bounds.getSouth(), n = bounds.getNorth(), e = bounds.getEast(), w = bounds.getWest();
        return L.polygon([
            [[s-10,w-10],[s-10,e+10],[n+10,e+10],[n+10,w-10],[s-10,w-10]],
            [[s,e],[n,e],[n,w],[s,w],[s,e]]
        ], { fillColor: '#f1f5f9', fillOpacity: 0.7, color: 'transparent', weight: 0 });
    }

    fetch('/geojson/dasmarinas-city-boundary.geojson')
        .then(function(r) { return r.json(); })
        .then(function(boundary) {
            var polys = { type: 'FeatureCollection', features: boundary.features.filter(function(f) { return f.geometry.type === 'Polygon' || f.geometry.type === 'MultiPolygon'; }) };
            L.geoJSON(polys, { fillColor: 'transparent', color: '#334155', weight: 2.5, opacity: 1 }).addTo(map);
            cityBounds = L.geoJSON(polys).getBounds();
            outsideMaskLayer = createOutsideMask(cityBounds).addTo(map);
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
        if (filters.week) params.append('week', filters.week);
        if (document.getElementById('dateFrom').value) params.append('date_from', document.getElementById('dateFrom').value);
        if (document.getElementById('dateTo').value) params.append('date_to', document.getElementById('dateTo').value);

        var baseUrl = window.location.pathname.replace(/\/$/, '');
        console.log('Fetching from:', baseUrl + '/data?' + params.toString());
        
        fetch(baseUrl + '/data?' + params.toString())
            .then(function(r) { return r.json(); })
            .then(function(data) {
                console.log('API Response:', data);
                updateMap(data.heatmapData);
                updateStats(data);
                updateFilterSummary();
                updateLegendFilter(data.filterLabel);
                updateSubtitle(data);
                showLoading(false);
            })
            .catch(function(err) {
                console.error('Data Error:', err);
                showLoading(false);
                document.getElementById('mapError').classList.remove('hidden');
            });
    }

    function applyDateFilter() {
        fetchFilteredData();
    }

    function clearDateFilter() {
        document.getElementById('dateFrom').value = '';
        document.getElementById('dateTo').value = '';
        fetchFilteredData();
    }

    function normalizeBarangayName(name) {
        // Normalize to match both API and GeoJSON names
        // API uses "II", GeoJSON may use "2" - normalize both to just the number
        var n = name.toLowerCase()
            .replace(/\s+/g, '')
            .replace(/\(.*\)/, '');
        
        // Replace roman numerals with numbers
        n = n.replace(/iii$/, '3');
        n = n.replace(/ii$/, '2');
        n = n.replace(/iv$/, '4');
        n = n.replace(/v$/, '5');
        n = n.replace(/i$/, '1');
        
        return n;
    }

    function updateMap(heatmapData) {
        console.log('heatmapData:', heatmapData);
        
        var caseData = {};
        heatmapData.forEach(function(item) {
            var normalizedName = normalizeBarangayName(item.name);
            caseData[normalizedName] = item.count;
            console.log('API Item:', item.name, '-> normalized:', normalizedName, 'count:', item.count);
        });

        if (!geojsonData || !geojsonData.features) {
            console.error('GeoJSON not loaded');
            return;
        }
        
        console.log('GeoJSON features count:', geojsonData.features.length);
        
        // Debug: Show some GeoJSON names
        geojsonData.features.slice(0, 5).forEach(function(f) {
            console.log('GeoJSON sample:', f.properties.name, '-> normalized:', normalizeBarangayName(f.properties.name || ''));
        });
        
        var copy = JSON.parse(JSON.stringify(geojsonData));
        copy.features.forEach(function(f) {
            var name = normalizeBarangayName(f.properties.name || '');
            f.properties.cases = caseData[name] || 0;
        });

        var polygons = { type: 'FeatureCollection', features: copy.features.filter(function(f) { return f.geometry.type === 'Polygon' || f.geometry.type === 'MultiPolygon'; }) };

        if (barangayLayer) map.removeLayer(barangayLayer);
        barangayLayer = L.geoJSON(polygons, { style: style, onEachFeature: onEachFeature, pointToLayer: function() { return null; } }).addTo(map);
        barangayLayer.bringToFront();
        map.eachLayer(function(l) { if (l instanceof L.TileLayer) l.bringToBack(); });
    }

    function updateStats(data) {
        var total = 0, affected = 0, critical = 0;
        data.heatmapData.forEach(function(item) {
            total += item.count;
            if (item.count > 0) affected++;
            if (item.count > 20) critical++;
        });
        document.getElementById('statTotalCases').textContent = total;
        document.getElementById('statAffected').textContent = affected;
        document.getElementById('statCritical').textContent = critical;
    }

    function showLoading(show) {
        var el = document.getElementById('mapLoading');
        if (el) el.style.display = show ? 'flex' : 'none';
    }

    function updateSubtitle(data) {
        var monthNames = ['','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        var text = data.month && data.week ? 'Wk ' + data.week + ', ' + monthNames[data.month] + ' ' + data.year
                 : data.month ? monthNames[data.month] + ' ' + data.year
                 : '' + data.year;
        document.getElementById('mapSubtitle').textContent = text;
    }

    function updateLegendFilter(label) {
        window.dispatchEvent(new CustomEvent('map-time-filter-updated', { detail: { filter: label } }));
    }

    function updateFilterSummary() {
        var summary = document.getElementById('filterSummary');
        var tags = document.getElementById('filterTags');
        var html = '';
        var hasExtra = false;
        var m = ['','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        if (filters.month) { hasExtra = true; html += '<span class="filter-tag">' + m[filters.month] + ' <button onclick="setFilter(\'month\', null)">×</button></span>'; }
        if (filters.week) { hasExtra = true; html += '<span class="filter-tag">Wk ' + filters.week + ' <button onclick="setFilter(\'week\', null)">×</button></span>'; }
        tags.innerHTML = html;
        summary.classList.toggle('hidden', !hasExtra);
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
        if (type === 'week') {
            document.getElementById('weekLabel').textContent = value ? 'Week ' + value : 'All Weeks';
            document.getElementById('weekFilterBtn').classList.toggle('active', !!value);
        }
        updateDropdownActiveStates();
        fetchFilteredData();
    };

    window.clearAllFilters = function() {
        filters.month = null; filters.week = null;
        document.getElementById('monthLabel').textContent = 'All Months';
        document.getElementById('weekLabel').textContent = 'All Weeks';
        document.getElementById('monthFilterBtn').classList.remove('active');
        document.getElementById('weekFilterBtn').classList.remove('active');
        updateDropdownActiveStates();
        fetchFilteredData();
    };

    function updateDropdownActiveStates() {
        document.querySelectorAll('[data-month]').forEach(function(el) {
            el.classList.toggle('active', filters.month === null ? el.dataset.month === 'all' : parseInt(el.dataset.month) === filters.month);
        });
        document.querySelectorAll('[data-week]').forEach(function(el) {
            el.classList.toggle('active', filters.week === null ? el.dataset.week === 'all' : parseInt(el.dataset.week) === filters.week);
        });
    }

    document.getElementById('resetViewBtn').addEventListener('click', function() {
        if (cityBounds) map.fitBounds(cityBounds);
        else map.setView([14.3270, 120.9370], 12);
    });

    document.getElementById('yearFilterBtn').classList.add('active');
});
</script>
@endsection
