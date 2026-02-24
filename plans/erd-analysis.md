# ERD Specification vs Current Database Implementation Analysis

## Executive Summary

This document compares the ERD specification provided with the current database structure in the Laravel project. There are **significant discrepancies** between the intended design and current implementation that need to be addressed.

---

## 1. Roles & Staff Accounts

### ERD Specification
| Table | Fields |
|-------|--------|
| `roles` | role_id (PK), role_name (unique) |
| `users` | user_id (PK), full_name, email (unique), password_hash, role_id (FK → roles), barangay_id (FK, nullable), status (active/inactive), created_at, updated_at |

### Current Implementation
- `roles` table exists with: id, role_name, description, timestamps
- `users` table: id, name, email, password, **role (enum)**, barangay, clinic_name, division, contact_number, address, timestamps

### Issues Found
1. ❌ Users still uses **enum** for role instead of foreign key to `roles` table
2. ❌ Missing `role_id` foreign key column
3. ❌ Missing `barangay_id` foreign key column  
4. ❌ Missing `status` field (active/inactive)
5. ❌ Uses `name` instead of `full_name`

> **Note**: Laravel default PK (`id`) is used instead of custom `user_id`

---

## 2. Barangays (Masterlist)

### ERD Specification
| Table | Fields |
|-------|--------|
| `barangays` | barangay_id (PK), barangay_name (unique) |

### Current Implementation
- `barangays` table: barangay_id, barangay_name, city, province, contact_number, office_email, status, timestamps

### Status: ✅ **Aligned** (Additional fields are acceptable)

---

## 3. Client Portal (Citizens / Pet Owners)

### ERD Specification
| Table | Fields |
|-------|--------|
| `clients` | client_id (PK), first_name, last_name, middle_name (nullable), suffix (nullable), email (unique), phone_number, house_no, street, subdivision, barangay_id (FK), city (default: Dasmariñas), province (default: Cavite), password_hash, status (active/inactive/suspended), created_at, updated_at |

### Current Implementation
- **No `clients` table exists**
- Pets are linked directly to `users` table via `owner_id`

### Issues Found
1. ❌ **No dedicated clients table** - Critical missing table
2. ❌ Pets tied to `users` instead of separate client records

---

## 4. Animals (Pets / Strays)

### ERD Specification
| Table | Fields |
|-------|--------|
| `animals` | animal_id (PK), client_id (FK, nullable), animal_type, name (nullable), remarks (nullable), sex (nullable), color (nullable), breed (nullable), is_stray (boolean), status (active/impounded/adopted/deceased), created_at, updated_at |

**Rule:** If is_stray = true → client_id = NULL

### Current Implementation
- Table named `pets` with: id, owner_id, name, species, breed, age, gender, color, weight, vaccination_status, vaccination_date, next_vaccination_date, license_number, license_expiry, microchip_number, health_status, medical_history, notes, photo_url, timestamps

### Issues Found
1. ❌ Table named `pets` instead of `animals`
2. ❌ Missing `client_id` foreign key (has `owner_id` pointing to users)
3. ❌ Missing `is_stray` boolean field
4. ❌ Missing proper `status` (uses health_status)
5. ⚠️ Uses `species` instead of `animal_type`

---

## 5. Bite Incidents / Rabies Monitoring

### ERD Specification
| Table | Fields |
|-------|--------|
| `bite_incidents` | incident_id (PK), reported_by_user_id (FK), barangay_id (FK), incident_date, location_details, victim_name, victim_age, victim_sex, victim_address_text, biting_animal_id (FK), animal_description (nullable), severity_level (nullable), status (open/under_observation/closed), remarks, created_at, updated_at |
| `bite_followups` | followup_id (PK), incident_id (FK), followup_date, action_taken, outcome (nullable), handled_by_user_id (FK), created_at, updated_at |

### Current Implementation
- `animal_bite_reports` table: user_id, reporter_name, reporter_contact, victim_name, victim_age, victim_gender, victim_address, animal_type, animal_owner_name, animal_owner_address, bite_location, bite_description, bite_severity, bite_category, animal_vaccination_status, bite_date, bite_time, status, action_taken, notes
- `rabies_cases` table: id, barangay_id, user_id, case_number, case_type, species, animal_name, owner_name, owner_contact, address, incident_date, incident_location, status, date_submitted, findings, actions_taken, remarks

### Issues Found
1. ❌ **No dedicated `bite_followups` table**
2. ❌ Schema doesn't align with specification (different field names)
3. ⚠️ Overlap between `animal_bite_reports` and `rabies_cases` tables
4. ❌ Missing foreign keys to `animals` table

---

## 6. Impound

### ERD Specification
| Table | Fields |
|-------|--------|
| `impounds` | impound_id (PK), animal_id (FK), impound_date, impound_reason (nullable), capture_location_text, captured_by_user_id (FK), status (in_pound/released/adopted/euthanized), release_date (nullable), created_at, updated_at |

### Current Implementation
- `impound_records` table: impound_id, stray_report_id, animal_tag_code, intake_condition, intake_location, intake_date, current_disposition, timestamps

### Issues Found
1. ❌ Missing `animal_id` foreign key
2. ❌ Missing `impound_date`, `impound_reason`, `capture_location_text` fields
3. ❌ Missing `captured_by_user_id` foreign key
4. ❌ Status values don't match specification
5. ❌ Missing `release_date` field

---

## 7. Meat Inspection

### ERD Specification
| Table | Fields |
|-------|--------|
| `meat_establishments` | establishment_id (PK), establishment_name, owner_name (nullable), address_text, permit_no (nullable), registered_by_user_id (FK), created_at, updated_at |
| `meat_inspections` | inspection_id (PK), establishment_id (FK), inspector_user_id (FK), inspection_date, findings (nullable), status (passed/failed/conditional), remarks (nullable), created_at, updated_at |

### Current Implementation
- `establishments` table: id, barangay_id, user_id, name, type, permit_no, address, contact_number, owner_name, status, timestamps (generic - serves multiple establishment types)
- `meat_inspection_reports` table: id, user_id, establishment_name, establishment_type, establishment_address, owner_name, owner_contact, inspection_date, inspection_time, inspector_name, inspection_type, overall_rating, findings, observations, recommendations, compliance_status, penalty_imposed, next_inspection_date, attachments, notes, timestamps

### Issues Found
1. ❌ No dedicated `meat_establishments` table
2. ❌ `meat_inspection_reports` duplicates establishment data instead of linking to separate table
3. ❌ Missing foreign keys to proper establishment and user tables

---

## 8. Announcements

### ERD Specification
| Table | Fields |
|-------|--------|
| `announcements` | announcement_id (PK), title, body, image_path (nullable), posted_by_user_id (FK), target_role_id (FK, nullable - NULL = visible to all), is_active, created_at, updated_at |

### Current Implementation
- `announcements` table: id, user_id, title, description, photo_path, event_date, event_time, location, contact_number, organized_by, is_active, timestamps

### Issues Found
1. ❌ **Missing `target_role_id`** - Important feature for role-based visibility
2. ⚠️ Uses `description` instead of `body`
3. ⚠️ Uses `photo_path` instead of `image_path`

---

## 9. System Logs (Audit Trail)

### ERD Specification
| Table | Fields |
|-------|--------|
| `system_logs` | log_id (PK), user_id (FK, nullable), action (CREATE/UPDATE/DELETE/LOGIN/EXPORT), module, record_id (nullable), ip_address, user_agent, created_at |

### Current Implementation
- `system_logs` table: log_id, user_id, role, action, module, record_id, description, ip_address, status, timestamps

### Issues Found
1. ❌ Missing `user_agent` field
2. ⚠️ Has extra fields: role, description, status

---

## Summary of Critical Gaps

| # | Component | Status | Priority |
|---|-----------|--------|----------|
| 1 | Clients table (pet owners) | ❌ Missing | HIGH |
| 2 | Animals table with is_stray logic | ❌ Needs rename/refactor | HIGH |
| 3 | Bite followups table | ❌ Missing | HIGH |
| 4 | Proper users with FK to roles | ❌ Needs refactor | HIGH |
| 5 | Impounds with animal FK | ❌ Needs refactor | MEDIUM |
| 6 | Meat establishments table | ❌ Missing | MEDIUM |
| 7 | Announcements target_role_id | ❌ Missing | LOW |

---

## Design Convention Notes

- **Primary Keys**: Using Laravel default `id` for all tables (not custom `*_id` PKs like `user_id`, `role_id`)
- **Foreign Keys**: Using `foreignId()->constrained()` pattern for cleaner code
- **Password**: Using `password` column (Laravel convention) instead of `password_hash`

---

## Recommended Actions

1. **Phase 1 - Core Restructure:**
   - Create `clients` table
   - Rename/refactor `pets` to `animals` with proper structure
   - Update `users` table to use role_id FK and add status field

2. **Phase 2 - Business Logic:**
   - Create `bite_followups` table
   - Refactor `impound_records` to `impounds` with proper FKs
   - Create `meat_establishments` table

3. **Phase 3 - Features:**
   - Add `target_role_id` to announcements
   - Add `user_agent` to system_logs
