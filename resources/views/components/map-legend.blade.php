{{--
    Map Legend Component for Rabies Cases Heatmap
    Positioned bottom-right of the map wrapper
--}}

@props([
    'caseTypeData' => null,
    'timeFilter' => 'Yearly',
])

@php
    $showCaseType = !empty($caseTypeData) && is_array($caseTypeData) && collect($caseTypeData)->sum() > 0;
@endphp

<div 
    id="mapLegend" 
    x-data="{ 
        isOpen: true,
        timeFilter: '{{ $timeFilter }}',
        toggle() { this.isOpen = !this.isOpen; },
        updateTimeFilter(filter) { this.timeFilter = filter; }
    }"
    x-init="
        window.addEventListener('map-time-filter-updated', (e) => { updateTimeFilter(e.detail.filter); });
    "
    class="map-legend-wrap"
>
    {{-- Collapsed Toggle --}}
    <button 
        x-show="!isOpen"
        @click="toggle()"
        class="legend-toggle"
        aria-label="Show legend"
    >
        <i class="bi bi-layer text-sm"></i>
        <span class="text-[11px] font-semibold">Legend</span>
    </button>

    {{-- Expanded Panel --}}
    <div 
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="legend-card"
    >
        {{-- Header --}}
        <div class="legend-header">
            <div class="flex items-center gap-2">
                <i class="bi bi-layer text-indigo-500 text-sm"></i>
                <span class="text-xs font-bold text-slate-700">Legend</span>
            </div>
            <button @click="toggle()" class="legend-close" aria-label="Hide">
                <i class="bi bi-x text-sm"></i>
            </button>
        </div>

        {{-- Period Badge --}}
        <div class="legend-period">
            <i class="bi bi-calendar3 text-[10px] text-indigo-400"></i>
            <span class="text-[10px] font-medium text-slate-500" x-text="timeFilter"></span>
        </div>

        {{-- Severity Levels --}}
        <div class="legend-section">
            <p class="legend-section-title">Case Severity</p>
            <div class="space-y-1.5">
                <div class="legend-item">
                    <span class="legend-dot" style="background: linear-gradient(135deg, #ef4444, #dc2626);"></span>
                    <div>
                        <span class="legend-label">Critical</span>
                        <span class="legend-sub">20+ cases</span>
                    </div>
                </div>
                <div class="legend-item">
                    <span class="legend-dot" style="background: linear-gradient(135deg, #f97316, #ea580c);"></span>
                    <div>
                        <span class="legend-label">High</span>
                        <span class="legend-sub">11 - 19</span>
                    </div>
                </div>
                <div class="legend-item">
                    <span class="legend-dot" style="background: linear-gradient(135deg, #facc15, #eab308);"></span>
                    <div>
                        <span class="legend-label">Moderate</span>
                        <span class="legend-sub">6 - 10</span>
                    </div>
                </div>
                <div class="legend-item">
                    <span class="legend-dot" style="background: linear-gradient(135deg, #60a5fa, #3b82f6);"></span>
                    <div>
                        <span class="legend-label">Low</span>
                        <span class="legend-sub">1 - 5</span>
                    </div>
                </div>
                <div class="legend-item">
                    <span class="legend-dot" style="background: linear-gradient(135deg, #94a3b8, #cbd5e1);"></span>
                    <div>
                        <span class="legend-label">No Cases</span>
                        <span class="legend-sub">0 reported</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Case Type (conditional) --}}
        @if($showCaseType)
        <div class="legend-section">
            <p class="legend-section-title">Case Type</p>
            <div class="space-y-1.5">
                <div class="legend-item">
                    <span class="legend-dot" style="background: #dc2626;"></span>
                    <span class="legend-label">Confirmed</span>
                </div>
                <div class="legend-item">
                    <span class="legend-dot" style="background: #f97316;"></span>
                    <span class="legend-label">Suspected</span>
                </div>
                <div class="legend-item">
                    <span class="legend-dot" style="background: #eab308;"></span>
                    <span class="legend-label">Under Investigation</span>
                </div>
                <div class="legend-item">
                    <span class="legend-dot" style="background: #22c55e;"></span>
                    <span class="legend-label">Negative</span>
                </div>
            </div>
        </div>
        @endif

        <p class="text-[9px] text-slate-300 text-center mt-2 pt-2 border-t border-slate-100">Hover barangay for details</p>
    </div>
</div>

<style>
    .map-legend-wrap {
        position: absolute;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .legend-toggle {
        display: flex; align-items: center; gap: 5px;
        padding: 6px 12px; background: rgba(255,255,255,0.95);
        backdrop-filter: blur(8px);
        border: 1px solid #e2e8f0;
        border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        cursor: pointer; color: #475569; transition: all 0.15s;
    }
    .legend-toggle:hover { background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }

    .legend-card {
        background: rgba(255,255,255,0.97);
        backdrop-filter: blur(12px);
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 12px;
        width: 160px;
    }

    .legend-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 8px; padding-bottom: 8px; border-bottom: 1px solid #f1f5f9;
    }

    .legend-close {
        display: flex; align-items: center; justify-content: center;
        width: 22px; height: 22px; background: #f1f5f9; border: none;
        border-radius: 6px; color: #94a3b8; cursor: pointer; transition: all 0.15s;
    }
    .legend-close:hover { background: #e2e8f0; color: #475569; }

    .legend-period {
        display: flex; align-items: center; gap: 5px;
        padding: 5px 8px; background: #f8fafc; border: 1px solid #f1f5f9;
        border-radius: 6px; margin-bottom: 10px;
    }

    .legend-section { margin-bottom: 8px; }
    .legend-section:last-of-type { margin-bottom: 0; }

    .legend-section-title {
        font-size: 9px; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.06em; color: #94a3b8; margin-bottom: 6px;
    }

    .legend-item {
        display: flex; align-items: center; gap: 8px;
        padding: 3px 6px; border-radius: 5px; transition: background 0.1s;
    }
    .legend-item:hover { background: #f8fafc; }

    .legend-dot {
        width: 10px; height: 10px; border-radius: 3px; flex-shrink: 0;
        box-shadow: inset 0 -1px 2px rgba(0,0,0,0.15);
    }

    .legend-label {
        font-size: 11px; font-weight: 600; color: #334155; line-height: 1.2;
        display: block;
    }
    .legend-sub {
        font-size: 9px; color: #94a3b8; font-weight: 500; display: block;
    }

    @media (max-width: 768px) {
        .map-legend-wrap {
            bottom: 12px; right: 12px; left: auto;
        }
        .legend-card { width: 140px; padding: 10px; }
        .legend-toggle { padding: 5px 10px; }
        .legend-toggle span { display: none; }
    }

    .leaflet-control-zoom { z-index: 1001 !important; }
    .leaflet-popup { z-index: 1002 !important; }
    .leaflet-tooltip { z-index: 1002 !important; }
</style>

<script>
    window.updateMapLegendTimeFilter = function(filter) {
        window.dispatchEvent(new CustomEvent('map-time-filter-updated', { detail: { filter: filter } }));
    };
</script>
