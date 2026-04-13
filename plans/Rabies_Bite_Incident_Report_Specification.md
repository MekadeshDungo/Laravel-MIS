# Rabies Bite Incident Report Form - Technical Specification

## 1. Project Overview

**Module Name:** Rabies Bite Incident Report System
**Type:** Public-facing form for reporting rabies-related animal bite incidents
**Target Users:** 
- Registered Veterinary Clinics
- Animal Bite Centers (ABCs)
- Hospitals
- General Public (Citizens)
**Access Level:** Public (no authentication required)

---

## 2. Database Design

### 2.1 Table: `rabies_reports`

| Column | Type | Description |
|--------|------|-------------|
| `id` | BIGINT (PK) | Auto-increment primary key |
| `report_number` | VARCHAR(50) | Unique case ID (auto-generated: RBI-YYYYMMDD-XXXX) |
| `status` | ENUM | 'Pending Review', 'Under Review', 'Resolved', 'Closed' - Default: 'Pending Review' |
| `assigned_to_role` | VARCHAR(50) | Target role assignment - Default: 'assistant_vet' |
| `created_at` | TIMESTAMP | Submission timestamp |
| `updated_at` | TIMESTAMP | Last update timestamp |

### SECTION I: Source of Report
| Column | Type | Constraints |
|--------|------|-------------|
| `reporting_facility` | VARCHAR(100) | Required - Dropdown selection |
| `facility_name` | VARCHAR(200) | Optional - If "Others" selected |
| `date_reported` | DATE | Required - Default: Current date |

### SECTION II: Patient (Human) Information
| Column | Type | Constraints |
|--------|------|-------------|
| `patient_name` | VARCHAR(200) | Required - "Last Name, First Name, Middle Name" |
| `patient_age` | INT | Required - Positive integer |
| `patient_gender` | ENUM | Required - 'Male', 'Female' |
| `patient_barangay_id` | BIGINT | FK to barangays - Required |
| `patient_contact` | VARCHAR(20) | Required - Exactly 11 digits |

### SECTION III: Incident Details
| Column | Type | Constraints |
|--------|------|-------------|
| `incident_date` | DATE | Required |
| `nature_of_incident` | ENUM | Required - 'Bitten', 'Scratched', 'Licked (Open Wound)' |
| `bite_site` | ENUM | Required - 'Head/Neck', 'Upper Extremities', 'Trunk', 'Lower Extremities' |
| `exposure_category` | ENUM | Required - 'Category I (Lick)', 'Category II (Scratch)', 'Category III (Bite / Deep)' |

### SECTION IV: Animal Information
| Column | Type | Constraints |
|--------|------|-------------|
| `animal_species` | ENUM | Required - 'Dog', 'Cat', 'Others' |
| `animal_status` | ENUM | Required - 'Stray', 'Owned', 'Wild' |
| `animal_owner_name` | VARCHAR(200) | Conditional - If 'Owned' |
| `animal_vaccination_status` | ENUM | Required - 'Vaccinated', 'Unvaccinated', 'Unknown' |
| `animal_current_condition` | ENUM | Required - 'Healthy / Alive', 'Dead', 'Missing / Escaped', 'Euthanized' |

### SECTION V: Clinical Action
| Column | Type | Constraints |
|--------|------|-------------|
| `wound_management` | JSON | Array of: 'Washed with Soap', 'Antiseptic Applied', 'None' |
| `post_exposure_prophylaxis` | ENUM | Required - 'Yes', 'No' |

### Relationship Fields
| Column | Type | Description |
|--------|------|-------------|
| `barangay_id` | BIGINT (FK) | FK to barangays - where incident occurred |
| `reported_by_user_id` | BIGINT (FK) | FK to users - who submitted (nullable for public) |

---

## 3. Route Structure

```
GET  /rabies-bite-report          -> Show public form
POST /rabies-bite-report          -> Submit form (store data)
GET  /rabies-bite-report/success  -> Show success message
```

---

## 4. UI/UX Specification

### 4.1 Layout Structure
- **Container:** max-w-4xl, centered, with adequate padding
- **Page Layout:** Vertical flow with 5 distinct card sections
- **Responsive:** Desktop (1024px+) and Tablet (768px+)

### 4.2 Section Cards
Each section displayed as a white card with:
- Light gray border (border-gray-200)
- Rounded corners (rounded-lg)
- Section header with icon and title
- Internal padding (p-6 or p-8)

### 4.3 Form Controls
| Control Type | Implementation |
|--------------|----------------|
| Dropdown | `<select>` with Tailwind styling, proper option groups |
| Date Picker | `<input type="date">` with default current date |
| Radio Button | Custom styled radio with primary color |
| Checkbox | Custom styled checkboxes for multi-select |
| Text Input | Full-width with proper placeholder text |
| Number Input | Numeric input with min/max validation |

### 4.4 Validation Indicators
- Required fields: Red asterisk (*) after label
- Inline error messages: Red text below input
- Error state: Red border on invalid inputs
- Success state: Green checkmark for valid inputs

### 4.5 Form Submission
- Submit button: Primary green color, prominent placement
- Loading state: Disabled button with spinner
- Success: Redirect to thank-you page with report number

### 4.6 Design Tokens (Tailwind)
- **Primary Color:** #066D33 (green)
- **Primary Light:** #077a40
- **Primary Dark:** #055a29
- **Font:** Inter (Google Fonts)
- **Background:** bg-gray-50

---

## 5. Business Logic

### 5.1 Report Number Generation
Format: `RBI-YYYYMMDD-XXXX`
- YYYYMMDD = Current date
- XXXX = Random 4-digit sequence

### 5.2 Auto-Assignment Logic
1. On successful submission:
   - Set `status` = 'Pending Review'
   - Set `assigned_to_role` = 'assistant_vet'
   - Log `created_at` timestamp

### 5.3 Data Flow
1. User fills public form → Submit → Validate
2. If valid → Generate report number → Store in database
3. Redirect to success page with report number
4. Report automatically available in assistant_vet queue

---

## 6. Dropdown Options Reference

### Reporting Facility Options
1. Registered Veterinary Clinics
2. Animal Bite Centers (ABCs)
3. Hospitals
4. Others

### Nature of Incident Options
1. Bitten
2. Scratched
3. Licked (Open Wound)

### Bite Site (Body Part) Options
1. Head/Neck
2. Upper Extremities
3. Trunk
4. Lower Extremities

### Exposure Category Options
1. Category I (Lick)
2. Category II (Scratch)
3. Category III (Bite / Deep)

### Animal Species Options
1. Dog
2. Cat
3. Others

### Animal Status Options
1. Stray
2. Owned
3. Wild

### Vaccination Status Options
1. Vaccinated
2. Unvaccinated
3. Unknown

### Current Condition Options
1. Healthy / Alive
2. Dead
3. Missing / Escaped
4. Euthanized

### Wound Management Options (Multi-select Checkboxes)
1. Washed with Soap
2. Antiseptic Applied
3. None

---

## 7. Validation Rules Summary

| Field | Validation |
|-------|------------|
| patient_name | Required, min 2 chars |
| patient_age | Required, integer, min 0, max 150 |
| patient_gender | Required, enum |
| patient_barangay_id | Required, exists in barangays |
| patient_contact | Required, exactly 11 digits, numeric |
| incident_date | Required, date, not future |
| nature_of_incident | Required, enum |
| bite_site | Required, enum |
| exposure_category | Required, enum |
| animal_species | Required, enum |
| animal_status | Required, enum |
| animal_vaccination_status | Required, enum |
| animal_current_condition | Required, enum |
| post_exposure_prophylaxis | Required, enum |

---

## 8. Acceptance Criteria

### Must Have
- [ ] Public form accessible without login
- [ ] All 5 sections with proper grouping
- [ ] All required field validations working
- [ ] Dropdowns, date pickers, radio buttons, checkboxes as specified
- [ ] Contact number validates exactly 11 digits
- [ ] Auto-generates report number on submission
- [ ] Stores data in rabies_reports table
- [ ] Auto-assigns to assistant_vet role queue
- [ ] Success message displayed after submission
- [ ] Card-based UI with proper spacing

### Should Have
- [ ] Responsive design (desktop + tablet)
- [ ] Inline validation errors
- [ ] Highlighted required fields
- [ ] Clean, modern Tailwind styling

### Optional
- [ ] Auto-generate Case ID if not provided
- [ ] Barangay search/filter dropdown
- [ ] Tooltip explanation for Exposure Categories
- [ ] Save as Draft feature

---

## 9. File Structure

```
database/migrations/
  └── YYYY_MM_DD_create_rabies_reports_table.php

app/Models/
  └── RabiesReport.php

app/Http/Controllers/
  └── RabiesReportController.php

routes/web.php
  └── Add public routes for rabies-bite-report

resources/views/Client/
  ├── rabies_bite_report_form.blade.php
  └── rabies_bite_report_success.blade.php
```

---

## 10. Integration Points

- **Barangay Model:** Uses existing `Barangay` model for dropdown
- **Establishment Model:** For facility type lookup (if needed)
- **User Model:** Track submission by authenticated users (optional)
- **DiseaseControlController:** Assistant vet can view/manage these reports

---

*Document Version: 1.0*
*Created: 2026-04-01*
