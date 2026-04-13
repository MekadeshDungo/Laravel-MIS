# Map Legend Component Integration Guide

## Overview

The `<x-map-legend>` Blade component provides a clean, minimal floating legend for the Rabies Cases Heatmap. It includes collapsible behavior, responsive design, and dynamic time filter display.

## Component Location

```
resources/views/components/map-legend.blade.php
```

## Features

### ✅ Floating Legend Panel
- Positioned at bottom-right corner of the map
- Uses Tailwind-style CSS with `bg-white/90`, `backdrop-blur`, `rounded-xl`, `shadow-lg`
- Does NOT overlap Leaflet zoom controls (z-index management)

### ✅ Collapsible Behavior
- **Default state**: Collapsed (small button showing "🗺 Legend")
- **Expanded state**: Full legend panel with "Hide" button
- Smooth fade + slide animation using Alpine.js transitions

### ✅ Legend Content

#### Case Severity (Always Visible)
| Color | Severity | Case Range |
|-------|----------|------------|
| 🔴 Red | Critical | 20+ cases |
| 🟠 Orange | High | 11–19 cases |
| 🟡 Yellow | Moderate | 6–10 cases |
| 🔵 Blue | Low | 1–5 cases |
| ⚪ Gray | No Cases | 0 cases |

#### Case Type (Conditional)
Only displays if `$caseTypeData` is provided and has values:
| Color | Case Type |
|-------|-----------|
| 🔴 Red | Confirmed |
| 🟠 Orange | Suspected |
| 🟡 Yellow | Under Investigation |
| 🟢 Green | Negative |

### ✅ Time Filter Display
- Shows current filter at top: "Viewing Data: Weekly / Monthly / Yearly"
- Updates dynamically via JavaScript event

### ✅ Responsiveness
- **Desktop**: Floating card in bottom-right corner
- **Mobile**: Bottom sheet (full width, slides up from bottom)

---

## Usage

### Basic Usage (Case Severity Only)

```blade
{{-- In your geomap view --}}
<div id="geomap" class="w-full rounded-xl" style="height: 70vh; min-height: 500px;">
    {{-- Map will be rendered here by Leaflet --}}
    
    {{-- Add the legend component --}}
    <x-map-legend />
</div>
```

### With Case Type Data

```blade
{{-- In your controller --}}
public function geomap(Request $request)
{
    // ... existing code ...
    
    // Get case type counts (optional)
    $caseTypeData = RabiesCase::whereYear('incident_date', $year)
        ->selectRaw('case_type, COUNT(*) as count')
        ->groupBy('case_type')
        ->pluck('count', 'case_type')
        ->toArray();
    
    return view('dashboard.rabies-geomap', compact(
        'heatmapData', 
        'stats', 
        'caseTypeData',  // Add this
        'year', 
        'incidentType', 
        'barangays'
    ));
}
```

```blade
{{-- In your view --}}
<div id="geomap" class="w-full rounded-xl" style="height: 70vh; min-height: 500px;">
    <x-map-legend :case-type-data="$caseTypeData" />
</div>
```

### With Dynamic Time Filter

```blade
{{-- In your view --}}
<div id="geomap" class="w-full rounded-xl" style="height: 70vh; min-height: 500px;">
    <x-map-legend :time-filter="$timeFilter ?? 'Yearly'" />
</div>

{{-- Add filter buttons --}}
<div class="flex gap-2 mb-4">
    <button onclick="updateMapLegendTimeFilter('Weekly')" class="px-4 py-2 bg-purple-600 text-white rounded-lg">
        Weekly
    </button>
    <button onclick="updateMapLegendTimeFilter('Monthly')" class="px-4 py-2 bg-purple-600 text-white rounded-lg">
        Monthly
    </button>
    <button onclick="updateMapLegendTimeFilter('Yearly')" class="px-4 py-2 bg-purple-600 text-white rounded-lg">
        Yearly
    </button>
</div>
```

---

## Integration with Existing Geomap Views

### Step 1: Update `resources/views/dashboard/rabies-geomap.blade.php`

Replace the existing static legend (lines 62-86) with the component:

```blade
{{-- REMOVE THIS --}}
<div id="legend" class="mt-4">
    <div class="flex flex-wrap items-center justify-center gap-5 p-4 bg-gray-50 rounded-lg border border-gray-200">
        {{-- ... legend items ... --}}
    </div>
</div>

{{-- ADD THIS INSTEAD --}}
<div id="geomap" class="w-full rounded-xl" style="height: 70vh; min-height: 500px;" role="application" aria-label="Rabies cases geomap">
    {{-- Map will be rendered here by Leaflet --}}
    
    {{-- Add the legend component --}}
    <x-map-legend :time-filter="$timeFilter ?? 'Yearly'" />
</div>
```

### Step 2: Update Controller (Optional - for Case Type Data)

In [`app/Http/Controllers/RabiesCaseController.php`](app/Http/Controllers/RabiesCaseController.php:201), update the `geomap()` method:

```php
public function geomap(Request $request)
{
    // ... existing code ...
    
    // Get case type counts (optional - remove if not needed)
    $caseTypeData = RabiesCase::whereYear('incident_date', $year)
        ->selectRaw('case_type, COUNT(*) as count')
        ->groupBy('case_type')
        ->pluck('count', 'case_type')
        ->toArray();
    
    return view('dashboard.rabies-geomap', compact(
        'heatmapData', 
        'stats', 
        'caseTypeData',  // Add this
        'year', 
        'incidentType', 
        'barangays'
    ));
}
```

### Step 3: Update View to Pass Case Type Data

```blade
<x-map-legend :case-type-data="$caseTypeData ?? null" :time-filter="$timeFilter ?? 'Yearly'" />
```

---

## JavaScript API

### Update Time Filter Programmatically

```javascript
// Update the time filter label from anywhere in your JS
window.updateMapLegendTimeFilter('Weekly');
window.updateMapLegendTimeFilter('Monthly');
window.updateMapLegendTimeFilter('Yearly');
```

### Example: Update on Filter Change

```javascript
// When user changes a filter dropdown
document.getElementById('timeFilterSelect').addEventListener('change', function(e) {
    const filter = e.target.value; // 'Weekly', 'Monthly', 'Yearly'
    window.updateMapLegendTimeFilter(filter);
});
```

---

## CSS Customization

The component uses scoped CSS classes. To customize, override these classes:

```css
/* Container position */
.map-legend-container {
    bottom: 80px;  /* Adjust distance from bottom */
    right: 10px;   /* Adjust distance from right */
}

/* Toggle button */
.map-legend-toggle-btn {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 12px;
}

/* Expanded panel */
.map-legend-panel {
    background: rgba(255, 255, 255, 0.92);
    border-radius: 16px;
    min-width: 220px;
    max-width: 280px;
}

/* Legend color squares */
.map-legend-color {
    width: 16px;
    height: 16px;
    border-radius: 4px;
}
```

---

## Props Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `case-type-data` | `array\|null` | `null` | Case type counts. If provided and sum > 0, shows Case Type section |
| `time-filter` | `string` | `'Yearly'` | Current time filter label to display |

---

## Browser Support

- ✅ Chrome/Edge (latest)
- ✅ Firefox (latest)
- ✅ Safari (latest)
- ✅ Mobile browsers (iOS Safari, Chrome Mobile)

---

## Dependencies

- **Alpine.js** (already included in admin layout)
- **Tailwind CSS** (via CDN in admin layout)
- **Leaflet.js** (already included in geomap views)

No additional dependencies required.

---

## Troubleshooting

### Legend not appearing
- Ensure the component is placed **inside** the `#geomap` div
- Check that Alpine.js is loaded (included in admin layout)
- Verify z-index: Legend uses `z-index: 1000`, Leaflet controls use `z-index: 1001`

### Legend overlapping zoom controls
- The component includes CSS to ensure Leaflet zoom controls have higher z-index
- If issues persist, check for conflicting CSS in your custom styles

### Time filter not updating
- Ensure you're calling `window.updateMapLegendTimeFilter(filter)` with correct string
- Check browser console for JavaScript errors

### Case Type section not showing
- Verify `$caseTypeData` is passed to the component
- Ensure the array has at least one value > 0
- Check that `case_type` field exists in your RabiesCase records

---

## Example: Complete Integration

```blade
{{-- resources/views/dashboard/rabies-geomap.blade.php --}}
@extends('layouts.admin')

@section('title', 'Rabies Geomap - Dasmariñas City')
@section('header', 'Rabies Cases Heatmap')
@section('subheader', 'Dasmariñas City Disease Surveillance')

@section('content')
<div class="container-fluid p-4">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        {{-- Header with filter buttons --}}
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="bi bi-geo-alt text-purple-600 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Rabies Cases Distribution</h2>
                    <p class="text-sm text-gray-500">Dasmariñas City - Interactive Map</p>
                </div>
            </div>
            
            {{-- Time filter buttons --}}
            <div class="flex items-center gap-2">
                <button onclick="updateMapLegendTimeFilter('Weekly')" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm">
                    Weekly
                </button>
                <button onclick="updateMapLegendTimeFilter('Monthly')" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm">
                    Monthly
                </button>
                <button onclick="updateMapLegendTimeFilter('Yearly')" class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm">
                    Yearly
                </button>
            </div>
        </div>
        
        {{-- Map container with legend --}}
        <div id="geomap" class="w-full rounded-xl" style="height: 70vh; min-height: 500px;" role="application" aria-label="Rabies cases geomap">
            {{-- Leaflet map renders here --}}
            
            {{-- Floating legend --}}
            <x-map-legend 
                :case-type-data="$caseTypeData ?? null" 
                :time-filter="$timeFilter ?? 'Yearly'" 
            />
        </div>
    </div>
</div>

{{-- Include Leaflet CSS/JS --}}
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endpush

{{-- Your existing map initialization script --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ... your existing Leaflet map code ...
});
</script>
@endpush
@endsection
```

---

## Summary

The `<x-map-legend>` component provides a professional, accessible, and responsive legend for your Rabies Cases Heatmap. It integrates seamlessly with your existing Leaflet map and requires minimal configuration.

For questions or issues, refer to the troubleshooting section above.
