# Bite Reports Geomap Implementation Plan

## Overview
Add interactive geographic mapping to visualize bite incidents on the Disease Control dashboard for rabies monitoring and spatial analysis.

---

## 1. Database Changes

### 1.1 Add Coordinates to Bite Incidents
```php
// database/migrations/2026_02_21_000011_add_coordinates_to_bite_incidents.php
Schema::table('bite_incidents', function (Blueprint $table) {
    $table->decimal('latitude', 10, 8)->nullable()->after('location_details');
    $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
    
    // Add index for spatial queries
    $table->index(['latitude', 'longitude']);
});
```

---

## 2. Backend Changes

### 2.1 Update BiteIncident Model
- Add `latitude` and `longitude` to `$fillable` array
- Add accessor/mutator if needed

### 2.2 Update BiteIncidentController
- Add coordinate input validation
- Store lat/lng when creating/updating bite incidents
- Add API endpoint to fetch incidents with coordinates

---

## 3. Frontend Changes

### 3.1 Add Leaflet.js (Free, No API Key Required)
```html
<!-- In layouts -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
```

### 3.2 Create Map Component
```javascript
// resources/js/components/BiteIncidentMap.vue
// or plain JS for Blade
```

### 3.3 Dashboard Page
- Add map section to Disease Control dashboard
- Display markers with severity colors:
  - 🔴 Severe
  - 🟠 Moderate  
  - 🟢 Minor

---

## 4. Features

### 4.1 Map Display
- [ ] Show all bite incidents as markers
- [ ] Color-code by severity level
- [ ] Click marker to show incident details
- [ ] Cluster markers when zoomed out

### 4.2 Filters
- [ ] Filter by date range
- [ ] Filter by barangay
- [ ] Filter by status (open/under_observation/closed)
- [ ] Filter by severity

### 4.3 Data Entry
- [ ] Add location picker on create/edit form
- [ ] Option to use current GPS location
- [ ] Manual address entry with lat/lng lookup

### 4.4 Statistics
- [ ] Show bite hot spots
- [ ] Count by barangay overlay
- [ ] Trend over time

---

## 5. File Structure

```
resources/
├── js/
│   └── components/
│       └── BiteIncidentMap.vue    # Map component
views/
├── dashboard/
│   └── disease-control.blade.php # Add map here
├── bite-incidents/
│   ├── create.blade.php          # Add location picker
│   └── edit.blade.php            # Add location picker
```

---

## 6. Implementation Steps

### Step 1: Database
- [ ] Create migration for lat/lng columns

### Step 2: Backend
- [ ] Update BiteIncident model
- [ ] Update controller for coordinate handling

### Step 3: Frontend - Map Display
- [ ] Include Leaflet.js
- [ ] Create map component
- [ ] Add to disease control dashboard

### Step 4: Frontend - Data Entry
- [ ] Add location picker to forms
- [ ] Integrate geocoding (optional)

---

## 7. Technology Stack

| Component | Technology |
|-----------|------------|
| Maps | Leaflet.js (free) |
| Map Tiles | OpenStreetMap (free) |
| Location Picker | Leaflet Control Geocoder |
| Vue.js | If using SPA, or plain JS for Blade |

---

## 8. Cost Estimate
- **Free**: Leaflet.js + OpenStreetMap
- **Paid (optional)**: Google Maps API or Mapbox for better accuracy

---

## 9. Dashboard Integration

The map will appear on the Disease Control dashboard as a main feature:

```
┌─────────────────────────────────────────────────┐
│  Disease Control - Bite Incident Monitor       │
├─────────────────────────────────────────────────┤
│  [Filters: Date | Barangay | Status | Severity]│
├─────────────────────────────────────────────────┤
│                                                 │
│              🗺️ Interactive Map                │
│         (Shows bite incidents by location)      │
│                                                 │
│    🔴 🟠 🟢 = Severity levels                  │
│                                                 │
├─────────────────────────────────────────────────┤
│  [Legend]  🔴 Severe  🟠 Moderate  🟢 Minor    │
└─────────────────────────────────────────────────┘
```

---

## Ready to Implement?

Let me know if you want me to proceed with the implementation!
