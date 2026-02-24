# Database Migration Plan - ERD Implementation (FIXED)

## Important Design Decisions

- **Primary Key Standard**: Using Laravel default `id` for all tables (not custom `*_id` PKs)
  - `users.id` (not user_id)
  - `roles.id` (not role_id)
  - This simplifies migrations and avoids errors

---

## Correct Migration Execution Order

⚠️ **CRITICAL**: `barangays` table MUST exist first - all other tables depend on it!

1. ✅ Verify `roles` table exists (already migrated)
2. ✅ **Verify `barangays` table exists first** (already migrated)
3. **Update `users`** - add role_id, barangay_id, status, full_name
4. **Create `clients`** 
5. **Create `animals`**
6. **Create `bite_incidents`**
7. **Create `bite_followups`**
8. **Create `impounds`**
9. **Create `meat_establishments`**
10. **Create `meat_inspections`**
11. **Update `announcements`**
12. **Update `system_logs`**

> ⚠️ **IMPORTANT**: Run `php artisan migrate:status` to verify `roles` and `barangays` tables exist before proceeding!

---

## Phase 0: Verify Foundation Tables (MUST RUN FIRST)

Before any other migrations, verify these tables exist:

```bash
php artisan migrate:status
```

### 0.1 Verify `roles` table
- Already exists: `2026_02_13_000010_create_roles_table.php`
- Run seeder to populate roles: `php artisan db:seed --class=RoleSeeder`

### 0.2 Verify `barangays` table  
- Already exists: `2026_02_12_230001_create_barangays_table.php`
- Run seeder to populate barangays: `php artisan db:seed --class=BarangaySeeder`

> ⚠️ **CRITICAL**: Both `roles` and `barangays` must exist before running Phase 1+ migrations!

---

## Phase 1: Core Tables (Foundation)

### 1.1 Update `users` table (add missing columns)

```php
// database/migrations/YYYY_MM_DD_update_users_table_for_erd.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add full_name column after name
            $table->string('full_name')->nullable()->after('name');
            
            // Add role_id foreign key
            $table->unsignedBigInteger('role_id')->nullable();
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('restrict');
            
            // Add barangay_id foreign key
            $table->unsignedBigInteger('barangay_id')->nullable();
            $table->foreign('barangay_id')
                ->references('barangay_id')
                ->on('barangays')
                ->nullOnDelete();
            
            // Add status column
            $table->enum('status', ['active', 'inactive'])->default('active');
            
            // Add indexes for common queries
            $table->index('role_id');
            $table->index('barangay_id');
            $table->index('status');
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['barangay_id']);
            $table->dropColumn(['full_name', 'role_id', 'barangay_id', 'status']);
            $table->dropIndex(['role_id']);
            $table->dropIndex(['barangay_id']);
            $table->dropIndex(['status']);
        });
    }
};
```

### 1.2 Create `clients` table

```php
// database/migrations/YYYY_MM_DD_create_clients_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id('client_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('suffix')->nullable();
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->string('house_no')->nullable();
            $table->string('street')->nullable();
            $table->string('subdivision')->nullable();
            $table->foreignId('barangay_id')
                ->nullable()
                ->constrained('barangays', 'barangay_id')
                ->nullOnDelete();
            $table->string('city')->default('Dasmariñas');
            $table->string('province')->default('Cavite');
            $table->string('password'); // Laravel convention
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->timestamps();

            // Indexes
            $table->index('barangay_id');
            $table->index('status');
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
```

### 1.3 Create `animals` table

```php
// database/migrations/YYYY_MM_DD_create_animals_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id('animal_id');
            $table->foreignId('client_id')
                ->nullable()
                ->constrained('clients', 'client_id')
                ->nullOnDelete();
            $table->string('animal_type'); // dog, cat, etc.
            $table->string('name')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('sex', ['male', 'female', 'unknown'])->nullable();
            $table->string('color')->nullable();
            $table->string('breed')->nullable();
            $table->boolean('is_stray')->default(false);
            $table->enum('status', ['active', 'impounded', 'adopted', 'deceased'])->default('active');
            $table->timestamps();

            // Indexes
            $table->index('client_id');
            $table->index('animal_type');
            $table->index('is_stray');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
```

---

## Phase 2: Bite Incidents & Rabies

### 2.1 Create `bite_incidents` table

```php
// database/migrations/YYYY_MM_DD_create_bite_incidents_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bite_incidents', function (Blueprint $table) {
            $table->id('incident_id');
            $table->foreignId('reported_by_user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('barangay_id')
                ->nullable()
                ->constrained('barangays', 'barangay_id')
                ->nullOnDelete();
            $table->date('incident_date');
            $table->text('location_details');
            $table->string('victim_name');
            $table->integer('victim_age')->nullable();
            $table->enum('victim_sex', ['male', 'female', 'other'])->nullable();
            $table->text('victim_address_text')->nullable();
            $table->foreignId('biting_animal_id')
                ->nullable()
                ->constrained('animals', 'animal_id')
                ->nullOnDelete();
            $table->text('animal_description')->nullable();
            $table->enum('severity_level', ['minor', 'moderate', 'severe'])->nullable();
            $table->enum('status', ['open', 'under_observation', 'closed'])->default('open');
            $table->text('remarks')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('barangay_id');
            $table->index('incident_date');
            $table->index('status');
            $table->index('reported_by_user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bite_incidents');
    }
};
```

### 2.2 Create `bite_followups` table

```php
// database/migrations/YYYY_MM_DD_create_bite_followups_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bite_followups', function (Blueprint $table) {
            $table->id('followup_id');
            $table->foreignId('incident_id')
                ->constrained('bite_incidents', 'incident_id')
                ->cascadeOnDelete();
            $table->date('followup_date');
            $table->text('action_taken');
            $table->text('outcome')->nullable();
            $table->foreignId('handled_by_user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->timestamps();

            // Indexes
            $table->index('incident_id');
            $table->index('followup_date');
            $table->index('handled_by_user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bite_followups');
    }
};
```

---

## Phase 3: Impound

### 3.1 Create `impounds` table

```php
// database/migrations/YYYY_MM_DD_create_impounds_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('impounds', function (Blueprint $table) {
            $table->id('impound_id');
            $table->foreignId('animal_id')
                ->constrained('animals', 'animal_id')
                ->cascadeOnDelete();
            $table->date('impound_date');
            $table->text('impound_reason')->nullable();
            $table->text('capture_location_text');
            $table->foreignId('captured_by_user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->enum('status', ['in_pound', 'released', 'adopted', 'euthanized'])->default('in_pound');
            $table->date('release_date')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('animal_id');
            $table->index('impound_date');
            $table->index('status');
            $table->index('captured_by_user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('impounds');
    }
};
```

---

## Phase 4: Meat Inspection

### 4.1 Create `meat_establishments` table

```php
// database/migrations/YYYY_MM_DD_create_meat_establishments_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meat_establishments', function (Blueprint $table) {
            $table->id('establishment_id');
            $table->string('establishment_name');
            $table->string('owner_name')->nullable();
            $table->text('address_text');
            $table->string('permit_no')->nullable();
            $table->foreignId('registered_by_user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->timestamps();

            // Indexes
            $table->index('registered_by_user_id');
            $table->unique('establishment_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meat_establishments');
    }
};
```

### 4.2 Create `meat_inspections` table

```php
// database/migrations/YYYY_MM_DD_create_meat_inspections_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meat_inspections', function (Blueprint $table) {
            $table->id('inspection_id');
            $table->foreignId('establishment_id')
                ->constrained('meat_establishments', 'establishment_id')
                ->cascadeOnDelete();
            $table->foreignId('inspector_user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->date('inspection_date');
            $table->text('findings')->nullable();
            $table->enum('status', ['passed', 'failed', 'conditional'])->default('passed');
            $table->text('remarks')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('establishment_id');
            $table->index('inspector_user_id');
            $table->index('inspection_date');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meat_inspections');
    }
};
```

---

## Phase 5: Announcements Enhancement

### 5.1 Update `announcements` table

```php
// database/migrations/YYYY_MM_DD_update_announcements_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            // Rename columns to match ERD
            $table->renameColumn('description', 'body');
            $table->renameColumn('photo_path', 'image_path');
            
            // Add target_role_id after posted_by_user_id
            // Note: assumes user_id column exists as posted_by_user_id alternative
            // If user_id doesn't exist, add it first
            if (!Schema::hasColumn('announcements', 'posted_by_user_id')) {
                $table->foreignId('user_id')
                    ->constrained('users')
                    ->cascadeOnDelete()
                    ->after('id');
            }
            
            $table->foreignId('target_role_id')
                ->nullable()
                ->constrained('roles', 'id')
                ->nullOnDelete()
                ->after('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->renameColumn('body', 'description');
            $table->renameColumn('image_path', 'photo_path');
            $table->dropForeign(['target_role_id']);
            
            if (Schema::hasColumn('announcements', 'target_role_id')) {
                $table->dropColumn('target_role_id');
            }
        });
    }
};
```

---

## Phase 6: System Logs Enhancement

### 6.1 Update `system_logs` table

```php
// database/migrations/YYYY_MM_DD_update_system_logs_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('system_logs', function (Blueprint $table) {
            // Add user_agent if not exists
            if (!Schema::hasColumn('system_logs', 'user_agent')) {
                $table->text('user_agent')->nullable()->after('ip_address');
            }
            
            // Add index on created_at for sorting
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::table('system_logs', function (Blueprint $table) {
            if (Schema::hasColumn('system_logs', 'user_agent')) {
                $table->dropColumn('user_agent');
            }
            $table->dropIndex(['created_at']);
        });
    }
};
```

---

## Summary of Changes

| Phase | Migration File | Action | Tables Affected |
|-------|---------------|--------|-----------------|
| 1 | `update_users_table_for_erd` | Modify | `users` |
| 1 | `create_clients_table` | Create | `clients` |
| 1 | `create_animals_table` | Create | `animals` |
| 2 | `create_bite_incidents_table` | Create | `bite_incidents` |
| 2 | `create_bite_followups_table` | Create | `bite_followups` |
| 3 | `create_impounds_table` | Create | `impounds` |
| 4 | `create_meat_establishments_table` | Create | `meat_establishments` |
| 4 | `create_meat_inspections_table` | Create | `meat_inspections` |
| 5 | `update_announcements_table` | Modify | `announcements` |
| 6 | `update_system_logs_table` | Modify | `system_logs` |

---

## Design Standards Applied

1. **Primary Keys**: Using Laravel default `id` for all tables
2. **Foreign Keys**: Using `foreignId()->constrained()` pattern
3. **Null Handling**: Using `nullOnDelete()` for optional FKs
4. **Indexes**: Added on frequently queried columns
5. **Password**: Using `password` column (Laravel convention)
6. **Column Naming**: Matching ERD exactly (`body`, `image_path`, etc.)

---

## Pre-requisites Check

Before running migrations:
- ✅ `roles` table exists
- ✅ `barangays` table exists  
- ✅ `users` table exists (will be modified)
- ✅ `announcements` table exists (will be modified)
- ✅ `system_logs` table exists (will be modified)

---

## Data Migration Notes

After creating new tables, you'll need to migrate data from old tables:

1. **Pets → Animals**: Map existing `pets` records to `animals`
2. **Animal Bite Reports → Bite Incidents**: Map existing `animal_bite_reports` to `bite_incidents`
3. **Meat Inspection Reports → Meat Inspections**: Map existing reports

These data migrations should be done as separate seeder/command files after schema migrations complete.
