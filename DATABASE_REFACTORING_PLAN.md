# Vet MIS Database Refactoring Plan
## Modular, Thesis-Level Design

---

## 1. CURRENT STATE ANALYSIS

### Issues Identified:
1. **Duplicate Address Fields**: `pet_owners` has `barangay`, `city`, `province` but `barangays` table already has city/province
2. **Redundant Gender/Sex**: `pets` table has both `sex` and `gender` columns
3. **Missing FK Relationships**: `missing_pets`, `adoption_pets` have no FK to centralized tables
4. **Role System Conflict**: Custom `role` enum in `admin_users` + Spatie permissions both exist
5. **Duplicate Report Tables**: Potential overlap between stray_reports, missing_pets, bite_rabies_reports
6. **Duplicate Inventory Tables**: `inventory_items`, `inventory_controls`, `stock_movements` - some redundancy
7. **Duplicate Establishment Tables**: `establishments`, `meat_establishments` - potential consolidation needed

---

## 2. PROPOSED MODULAR ARCHITECTURE

### Module 1: ADMIN / SYSTEM CORE
| Table | Purpose |
|-------|---------|
| admin_users | Authentication only (name, email, password, status) |
| model_has_roles | Spatie role mapping |
| model_has_permissions | Spatie permission mapping |
| permissions | Spatie permissions |
| roles | Spatie roles |
| role_has_permissions | Spatie role-permission mapping |
| personal_access_tokens | Laravel Sanctum tokens |
| barangays | **CENTRALIZED** - Only one barangays table |

### Module 2: ANIMAL MANAGEMENT
| Table | Purpose |
|-------|---------|
| pets | Central pet registry (consolidated from adoption_pets, missing source tracking) |
| pet_owners | Pet owner information |
| vaccinations | Pet vaccination records |
| pet_traits | Pet characteristic traits (adoption traits) |
| pet_trait_types | Trait categories |

### Module 3: VETERINARY / MEDICAL
| Table | Purpose |
|-------|---------|
| medical_records | Pet medical history |
| clinical_actions | Clinical cases/treatments |
| rabies_vaccination_reports | Rabies vaccination reporting |

### Module 4: ANIMAL CONTROL & REPORTS
| Table | Purpose |
|-------|---------|
| stray_reports | Found/stray animal reports |
| missing_pets | Lost pet reports |
| bite_rabies_reports | Bite/rabies incident reports |
| impounds | Impounded animals |

### Module 5: GIS / BARANGAY MAPPING
| Table | Purpose |
|-------|---------|
| barangays | **CENTRALIZED** - All location data |

### Module 6: ESTABLISHMENTS / INSPECTIONS
| Table | Purpose |
|-------|---------|
| establishments | General establishments |
| meat_inspections | Meat establishment inspections |
| meat_establishments | Meat-specific establishments |

### Module 7: INVENTORY SYSTEM
| Table | Purpose |
|-------|---------|
| inventory_items | Central inventory items |
| stock_movements | Stock movements |

### Module 8: OTHER UTILITIES
| Table | Purpose |
|-------|---------|
| notifications | User notifications |
| announcements | System announcements |
| system_logs | Audit logging |
| form_submissions | Citizen form submissions |
| service_forms | Available service forms |
| device_tokens | Mobile push tokens |
| attachments | File attachments |
| livestock | Livestock records |

---

## 3. CLEAN ERD STRUCTURE

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                           ADMIN / SYSTEM CORE                                │
├─────────────────────────────────────────────────────────────────────────────┤
│ admin_users                                                                 │
│ ├── id (PK)                                                                 │
│ ├── name                                                                   │
│ ├── email (UNIQUE)                                                         │
│ ├── password                                                               │
│ ├── status (active/inactive/suspended)                                    │
│ ├── remember_token                                                        │
│ ├── created_at                                                             │
│ └── updated_at                                                             │
│                                                                             │
│ barangays (CENTRALIZED)                                                    │
│ ├── barangay_id (PK)                                                       │
│ ├── barangay_name                                                          │
│ ├── city (default: Dasmariñas)                                            │
│ ├── province (default: Cavite)                                            │
│ ├── contact_number                                                         │
│ ├── office_email                                                           │
│ ├── latitude                                                               │
│ ├── longitude                                                              │
│ ├── status                                                                 │
│ ├── created_at                                                             │
│ └── updated_at                                                             │
│                                                                             │
│ [Spatie: roles, permissions, model_has_roles, model_has_permissions,     │
│  role_has_permissions, personal_access_tokens]                             │
└─────────────────────────────────────────────────────────────────────────────┘
                                    │
            ┌───────────────────────┼───────────────────────┐
            │                       │                       │
            ▼                       ▼                       ▼
┌───────────────────┐   ┌───────────────────┐   ┌───────────────────┐
│ ANIMAL MANAGEMENT │   │ ANIMAL CONTROL    │   │    INVENTORY      │
├───────────────────┤   ├───────────────────┤   ├───────────────────┤
│ pets              │   │ stray_reports     │   │ inventory_items   │
│ ├── pet_id (PK)   │   │ ├── id (PK)       │   │ ├── id (PK)       │
│ ├── owner_id (FK) │   │ ├── barangay_id   │   │ ├── item_name     │
│ ├── barangay_id   │   │ ├── reported_by   │   │ ├── category      │
│ ├── pet_name      │   │ ├── report_type   │   │ ├── quantity      │
│ ├── species       │   │ ├── species       │   │ ├── unit          │
│ ├── breed         │   │ ├── location      │   │ └── min_stock     │
│ ├── sex           │   │ ├── status        │   │                   │
│ ├── age           │   │ └── urgency       │   │ stock_movements   │
│ ├── color         │   │                   │   │ ├── id (PK)       │
│ ├── weight        │   │ missing_pets      │   │ ├── item_id (FK)  │
│ └── ...           │   │ ├── id (PK)       │   │ ├── user_id (FK)  │
│                   │   │ ├── pet_name      │   │ ├── movement_type │
│ pet_owners        │   │ ├── species       │   │ ├── quantity      │
│ ├── owner_id (PK) │   │ ├── missing_since │   │ └── movement_date │
│ ├── user_id (FK)  │   │ ├── last_seen_loc │   │                   │
│ ├── barangay_id   │   │ └── contact_info  │   └───────────────────┘
│ ├── first_name    │   │                   │
│ ├── last_name     │   │ bite_rabies_reports│
│ ├── phone_number  │   │ ├── id (PK)        │
│ ├── house_no      │   │ ├── patient_name  │
│ ├── street        │   │ ├── barangay_id   │
│ └── barangay_id   │   │ ├── incident_date │
│                   │   │ ├── animal_type   │
│ vaccinations      │   │ ├── category      │
│ ├── id (PK)       │   │ └── status       │
│ ├── pet_id (FK)   │   │                   │
│ ├── vaccine_type  │   │ impounds          │
│ ├── vax_date      │   │ ├── id (PK)       │
│ └── vaccinated_by │   │ ├── stray_report  │
│                   │   │ ├── intake_date   │
│ pet_traits        │   │ └── status        │
│ ├── id (PK)       │   └───────────────────┘
│ ├── pet_id (FK)   │
│ ├── trait_id (FK) │
│                   │
│ trait_types       │
│ ├── id (PK)       │
│ └── name          │
└───────────────────┘
                                    │
                                    ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│                         VETERINARY / MEDICAL                                │
├─────────────────────────────────────────────────────────────────────────────┤
│ medical_records                                                            │
│ ├── id (PK)                                                                 │
│ ├── pet_id (FK)                                                             │
│ ├── barangay_id (FK)                                                        │
│ ├── veterinarian_id (FK)                                                    │
│ ├── record_type                                                             │
│ ├── diagnosis                                                               │
│ ├── treatment                                                               │
│ └── record_date                                                             │
│                                                                             │
│ clinical_actions                                                            │
│ ├── id (PK)                                                                 │
│ ├── pet_id (FK) nullable                                                    │
│ ├── barangay_id (FK)                                                        │
│ ├── veterinarian_id (FK)                                                    │
│ ├── case_title                                                              │
│ ├── action_type                                                             │
│ ├── status                                                                  │
│ └── action_date                                                             │
│                                                                             │
│ rabies_vaccination_reports                                                   │
│ ├── id (PK)                                                                 │
│ ├── barangay_id (FK)                                                        │
│ ├── report_date                                                             │
│ ├── total_vaccinated                                                        │
│ └── created_by                                                              │
└─────────────────────────────────────────────────────────────────────────────┘
                                    │
                                    ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│                     ESTABLISHMENTS / INSPECTIONS                            │
├─────────────────────────────────────────────────────────────────────────────┤
│ establishments                                                              │
│ ├── id (PK)                                                                 │
│ ├── barangay_id (FK)                                                        │
│ ├── user_id (FK)                                                            │
│ ├── name                                                                    │
│ ├── type (enum)                                                             │
│ ├── permit_no                                                               │
│ ├── address                                                                 │
│ └── status                                                                  │
│                                                                             │
│ meat_establishments                                                        │
│ ├── id (PK)                                                                 │
│ ├── barangay_id (FK)                                                        │
│ ├── establishment_name                                                      │
│ ├── establishment_type                                                      │
│ ├── owner_name                                                              │
│ ├── contact_number                                                          │
│ └── permit_no                                                               │
│                                                                             │
│ meat_inspections                                                            │
│ ├── id (PK)                                                                 │
│ ├── establishment_id (FK)                                                  │
│ ├── inspection_date                                                         │
│ ├── inspector_id (FK)                                                       │
│ └── status                                                                  │
└─────────────────────────────────────────────────────────────────────────────┘
                                    │
                                    ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│                              OTHER UTILITIES                                │
├─────────────────────────────────────────────────────────────────────────────┤
│ notifications    │ announcements    │ system_logs      │ form_submissions │
│ ├── user_id (FK) │ ├── title        │ ├── user_id (FK) │ ├── form_id (FK) │
│ ├── title        │ ├── content      │ ├── action       │ ├── citizen_name │
│ ├── message      │ ├── event_date   │ ├── module       │ ├── payload_json │
│ ├── is_read      │ ├── location     │ ├── description  │ └── status      │
│ └── priority     │ └── created_by   │ └── status       │                  │
│                  │                  │                  │ service_forms   │
│ attachments      │ livestock        │ device_tokens    │ ├── form_type    │
│ ├── id (PK)      │ ├── owner_id (FK)│ ├── user_id (FK) │ └── title       │
│ ├── file_path    │ ├── barangay_id  │ ├── token        │                  │
│ ├── file_type    │ ├── species      │ └── created_at   │                  │
│ └── record_id    │ └── status       │                  │                  │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## 4. FOREIGN KEY RELATIONSHIPS (FINAL)

| Child Table | Foreign Key | Parent Table | On Delete |
|-------------|-------------|--------------|-----------|
| pets | owner_id | pet_owners | SET NULL |
| pets | barangay_id | barangays | SET NULL |
| pet_owners | user_id | admin_users | CASCADE |
| pet_owners | barangay_id | barangays | SET NULL |
| vaccinations | pet_id | pets | CASCADE |
| vaccinations | vaccinated_by | admin_users | CASCADE |
| pet_traits | pet_id | pets | CASCADE |
| pet_traits | trait_id | trait_types | CASCADE |
| medical_records | pet_id | pets | SET NULL |
| medical_records | barangay_id | barangays | SET NULL |
| medical_records | veterinarian_id | admin_users | SET NULL |
| clinical_actions | pet_id | pets | SET NULL |
| clinical_actions | barangay_id | barangays | SET NULL |
| clinical_actions | veterinarian_id | admin_users | SET NULL |
| stray_reports | barangay_id | barangays | CASCADE |
| stray_reports | reported_by_user_id | admin_users | SET NULL |
| missing_pets | barangay_id | barangays | SET NULL |
| bite_rabies_reports | barangay_id | barangays | SET NULL |
| bite_rabies_reports | reported_by | admin_users | SET NULL |
| impounds | stray_report_id | stray_reports | SET NULL |
| impounds | captured_by_user_id | admin_users | CASCADE |
| establishments | barangay_id | barangays | SET NULL |
| establishments | user_id | admin_users | SET NULL |
| meat_establishments | barangay_id | barangays | SET NULL |
| meat_establishments | registered_by_user_id | admin_users | CASCADE |
| meat_inspections | establishment_id | meat_establishments | CASCADE |
| meat_inspections | inspector_id | admin_users | SET NULL |
| inventory_items | user_id | admin_users | CASCADE |
| stock_movements | inventory_item_id | inventory_items | CASCADE |
| stock_movements | user_id | admin_users | CASCADE |
| notifications | user_id | admin_users | CASCADE |
| announcements | created_by | admin_users | SET NULL |
| system_logs | user_id | admin_users | SET NULL |
| form_submissions | form_id | service_forms | CASCADE |
| form_submissions | submitted_by_user_id | admin_users | SET NULL |
| form_submissions | reviewed_by | admin_users | SET NULL |
| service_forms | created_by | admin_users | SET NULL |
| attachments | user_id | admin_users | SET NULL |
| livestock | owner_id | pet_owners | SET NULL |
| livestock | barangay_id | barangays | SET NULL |
| livestock | recorded_by | admin_users | SET NULL |
| device_tokens | user_id | admin_users | CASCADE |
| rabies_vaccination_reports | barangay_id | barangays | SET NULL |
| rabies_vaccination_reports | created_by | admin_users | SET NULL |

---

## 5. MIGRATION ADJUSTMENT PLAN

### Phase 1: Core Cleanup (Must do first)
1. **Add barangay_id to pet_owners** - Remove duplicate city/province fields
2. **Make pets.sex the single gender field** - Drop pets.gender column
3. **Add source tracking fields to missing_pets** - Add source_module, source_module_id for tracking origin

### Phase 2: Role System Cleanup
1. **Keep only Spatie roles** - Remove role enum column from admin_users
2. **Run seeder to populate Spatie roles** - Map old roles to new permissions

### Phase 3: Relationship Fixes
1. **Add FK to missing_pets** - Add barangay_id FK
2. **Add FK to adoption_pets** - Add barangay_id FK (or consolidate to pets)
3. **Consolidate meat_establishments** - Either merge into establishments or keep separate with proper FK

### Phase 4: Remove Redundant Tables (Careful!)
- DO NOT DELETE - only restructure:
  - `inventory_controls` → migrate to `inventory_items`
  - `inventory_movements` → migrate to `stock_movements`

---

## 6. IMPLEMENTATION COMMANDS

```bash
# After making migrations, run:
php artisan migrate

# Seed roles and permissions:
php artisan db:seed --class=RolePermissionSeeder

# Clear cache:
php artisan cache:clear
php artisan config:clear
php artisan permission:cache:reset
```

---

## 7. NOTES FOR THESIS

### Key Design Principles:
1. **3NF Compliance**: No transitive dependencies, atomic values
2. **Centralized Location**: All barangay data in one table
3. **Clear Module Separation**: Each module has distinct purpose
4. **Proper FK Relationships**: All relationships use ON DELETE SET NULL or CASCADE
5. **Spatie for Roles**: Role management via packages, not custom columns

### Defense Points:
- Modular architecture allows independent scaling
- Centralized barangay system prevents data duplication
- Spatie provides granular permission control
- Clear separation between stray/missing/bite reports
- All tables have proper indexes for performance