# Services & Controllers - Feature-Based Reorganization Plan

## Target Folder Structure (Confirmed)

### Controllers
```
app/Http/Controllers/
├── Auth/
│   ├── AuthController.php
│   └── DeviceTokenController.php
├── Chat/
│   └── ChatController.php
├── Notifications/
│   └── NotificationController.php
├── Reports/
│   ├── AdminController.php
│   ├── RecordsController.php
│   ├── SystemLogController.php
│   └── CertificateController.php
├── Users/
│   ├── UserController.php
│   ├── AdminStaffController.php
│   └── SuperAdminController.php
├── Announcements/
│   └── AnnouncementController.php
├── Inventory/
│   └── InventoryController.php
├── Establishments/
│   ├── EstablishmentController.php
│   └── MeatInspectionController.php
├── Animals/
│   ├── BarangayController.php
│   ├── ClinicController.php
│   ├── SpayNeuterController.php
│   ├── RabiesCaseController.php
│   └── DiseaseControlController.php
├── Settings/
│   ├── CityVetController.php
│   ├── CityPoundController.php
│   └── ViewerController.php
└── Legacy/
    ├── LivestockCensusController.php
    └── ServiceFormController.php
```

### Services
```
app/Services/
├── Chat/
│   └── AiChatService.php
├── Notifications/
│   ├── PushNotificationService.php
│   └── SmsNotificationService.php
├── Reports/
│   └── ReportApiService.php
└── Base/
    └── BaseService.php
```

---

## Implementation Steps

### Step 1: Create Folder Structure
Create the following directories:
- `app/Http/Controllers/Auth/`
- `app/Http/Controllers/Chat/`
- `app/Http/Controllers/Notifications/`
- `app/Http/Controllers/Reports/`
- `app/Http/Controllers/Users/`
- `app/Http/Controllers/Announcements/`
- `app/Http/Controllers/Inventory/`
- `app/Http/Controllers/Establishments/`
- `app/Http/Controllers/Animals/`
- `app/Http/Controllers/Settings/`
- `app/Http/Controllers/Legacy/`
- `app/Services/Chat/`
- `app/Services/Notifications/`
- `app/Services/Reports/`
- `app/Services/Base/`

### Step 2: Fix Base Controller First
Create `app/Http/Controllers/Controller.php` with common methods:
- `isAdmin()` - Check if user is admin/super_admin
- `getCurrentBarangayUser()` - Get barangay user info
- `respond()` - JSON response helper

### Step 3: Move Existing Controllers to Folders

| Current Location | New Location |
|------------------|--------------|
| AuthController.php | Auth/AuthController.php |
| DeviceTokenController.php | Auth/DeviceTokenController.php |
| AdminController.php | Reports/AdminController.php |
| RecordsController.php | Reports/RecordsController.php |
| SystemLogController.php | Reports/SystemLogController.php |
| CertificateController.php | Reports/CertificateController.php |
| UserController.php | Users/UserController.php |
| AdminStaffController.php | Users/AdminStaffController.php |
| SuperAdminController.php | Users/SuperAdminController.php |
| AnnouncementController.php | Announcements/AnnouncementController.php |
| InventoryController.php | Inventory/InventoryController.php |
| EstablishmentController.php | Establishments/EstablishmentController.php |
| MeatInspectionController.php | Establishments/MeatInspectionController.php |
| BarangayController.php | Animals/BarangayController.php |
| ClinicController.php | Animals/ClinicController.php |
| SpayNeuterController.php | Animals/SpayNeuterController.php |
| RabiesCaseController.php | Animals/RabiesCaseController.php |
| DiseaseControlController.php | Animals/DiseaseControlController.php |
| CityVetController.php | Settings/CityVetController.php |
| CityPoundController.php | Settings/CityPoundController.php |
| ViewerController.php | Settings/ViewerController.php |
| LivestockCensusController.php | Legacy/LivestockCensusController.php |
| ServiceFormController.php | Legacy/ServiceFormController.php |

### Step 4: Create New Files

#### Chat/AiChatService.php
- AI chat functionality for veterinary queries

#### Notifications/SmsNotificationService.php
- SMS notifications for appointments, alerts

#### Reports/ReportApiService.php
- External report API integration

#### Chat/ChatController.php
- Handle AI chat functionality

#### Notifications/NotificationController.php
- Unified notification management

#### Services/Base/BaseService.php
- Common service methods

### Step 5: Update Namespaces
Update all `namespace` declarations in moved files

### Step 6: Update Route Files
Update routes to use new controller paths

---

## Priority Fixes

### 1. Fix empty Controller.php (Base)
- Add common helper methods before moving files

### 2. Split RecordsController.php
- Currently 354 lines handling: pets, owners, vaccinations, search
- Consider splitting into separate controllers after reorganization

### 3. Fix code duplication in BarangayController
- Repeated `BarangayUser::where('user_id', $user->id)->first()` queries
- Use new base controller helper after fix
