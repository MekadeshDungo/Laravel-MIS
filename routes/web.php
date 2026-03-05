<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CityVetController;
use App\Http\Controllers\AdminStaffController;
use App\Http\Controllers\DiseaseControlController;
use App\Http\Controllers\MeatInspectionController;
use App\Http\Controllers\BarangayController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\SpayNeuterController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\LivestockCensusController;
use App\Http\Controllers\RabiesCaseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ViewerController;
use App\Http\Controllers\CityPoundController;
use App\Http\Controllers\RecordsController;
use App\Http\Controllers\SystemLogController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\OtpController;
use App\Http\Controllers\Client\PetRegistrationController;
use App\Http\Controllers\Client\PetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Veterinary Services Office Management Information System
| 7 User Roles from Thesis Paper:
| 1. Super Administrator
| 2. Administrator
| 3. City Veterinarian
| 4. Administrative Staff
| 5. Disease Control Personnel
| 6. City Pound Personnel
| 7. Meat Inspection Officer
|
*/


Route::get('/', function () {
    // If user is authenticated, redirect to their role-based dashboard
    if (Auth::check()) {
        $user = Auth::user();
        switch ($user->role) {
            case 'super_admin':
                return redirect()->route('super-admin.dashboard');
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'city_vet':
                return redirect()->route('city-vet.dashboard');
            case 'records_staff':
                return redirect()->route('records-staff.dashboard');
            case 'disease_control':
                return redirect()->route('disease-control.dashboard');
            case 'meat_inspector':
                return redirect()->route('meat-inspection.dashboard');
            case 'inventory_staff':
                return redirect()->route('inventory.dashboard');
            case 'barangay_encoder':
            case 'barangay':
                return redirect()->route('barangay.dashboard');
            case 'clinic':
                return redirect()->route('clinic.dashboard');
            case 'viewer':
                return redirect()->route('viewer.dashboard');
            case 'citizen':
                return redirect()->to('/client');
            default:
                // Unknown role - log out and redirect to login for security
                Auth::logout();
                return redirect()->route('login');
        }
    }
    return view('Client.welcome');
})->name('landing');

// ==============================
// AUTHENTICATION ROUTES - Client Portal (Default)
// ==============================
// Login routes moved to routes/auth.php (loaded at end of this file)

// ==============================
// PUBLIC ANNOUNCEMENTS (Citizen View)
// ==============================
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.public.index');

// ==============================
// AUTHENTICATED NON-ADMIN ANNOUNCEMENTS (Barangay, Clinic, etc.)
// ==============================
Route::middleware(['auth'])->group(function () {
    Route::get('/portal/announcements', [AnnouncementController::class, 'publicIndex'])->name('announcements.portal.index');
    Route::post('/portal/announcements/mark-read', [AnnouncementController::class, 'markAsRead'])->name('announcements.markAsRead');
});

// ==============================
// SUPER ADMIN PORTAL (Super Administrator)
// Role: Super Admin
// Access: Full system access with account management
// ==============================
Route::middleware(['auth', 'role:super_admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');

    // User Management (Full Access)
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // All Reports (City-wide View)
    Route::get('/all-reports', [AdminController::class, 'allReports'])->name('all-reports');

    // Animal Bite Reports (from Barangay)
    Route::get('/animal-bite-reports', [AdminController::class, 'indexBiteReports'])->name('bite-reports.index');
    Route::get('/animal-bite-reports/{report}', [AdminController::class, 'showBiteReport'])->name('bite-reports.show');
    Route::put('/animal-bite-reports/{report}', [AdminController::class, 'updateBiteReport'])->name('bite-reports.update');

    // Rabies Vaccination Reports (from Clinic)
    Route::get('/vaccination-reports', [AdminController::class, 'indexVaccinationReports'])->name('vaccination-reports.index');
    Route::get('/vaccination-reports/{report}', [AdminController::class, 'showVaccinationReport'])->name('vaccination-reports.show');

    // Meat Inspection Reports
    Route::get('/meat-inspection-reports', [AdminController::class, 'indexMeatInspectionReports'])->name('meat-inspection-reports.index');
    Route::get('/meat-inspection-reports/{report}', [AdminController::class, 'showMeatInspectionReport'])->name('meat-inspection-reports.show');

    // Announcements
    Route::get('/announcements', [AnnouncementController::class, 'list'])->name('announcements.index');
    Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');
    Route::get('/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    // System Logs
    Route::get('/system-logs', [SystemLogController::class, 'index'])->name('system-logs.index');
    Route::get('/system-logs/{log}', [SystemLogController::class, 'show'])->name('system-logs.show');
    Route::get('/system-logs/export', [SystemLogController::class, 'export'])->name('system-logs.export');
});

// ==============================
// ADMIN PORTAL (Administrator)
// Role: Admin
// Access: System management and user oversight
// ==============================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // User Management (Limited - can manage other admins)
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // All Reports (City-wide View)
    Route::get('/all-reports', [AdminController::class, 'allReports'])->name('all-reports');

    // Animal Bite Reports (from Barangay)
    Route::get('/animal-bite-reports', [AdminController::class, 'indexBiteReports'])->name('bite-reports.index');
    Route::get('/animal-bite-reports/{report}', [AdminController::class, 'showBiteReport'])->name('bite-reports.show');
    Route::put('/animal-bite-reports/{report}', [AdminController::class, 'updateBiteReport'])->name('bite-reports.update');

    // Rabies Vaccination Reports (from Clinic)
    Route::get('/vaccination-reports', [AdminController::class, 'indexVaccinationReports'])->name('vaccination-reports.index');
    Route::get('/vaccination-reports/{report}', [AdminController::class, 'showVaccinationReport'])->name('vaccination-reports.show');

    // Meat Inspection Reports
    Route::get('/meat-inspection-reports', [AdminController::class, 'indexMeatInspectionReports'])->name('meat-inspection-reports.index');
    Route::get('/meat-inspection-reports/{report}', [AdminController::class, 'showMeatInspectionReport'])->name('meat-inspection-reports.show');

    // Announcements
    Route::get('/announcements', [AnnouncementController::class, 'list'])->name('announcements.index');
    Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');
    Route::get('/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    // System Logs
    Route::get('/system-logs', [SystemLogController::class, 'index'])->name('system-logs.index');
    Route::get('/system-logs/{log}', [SystemLogController::class, 'show'])->name('system-logs.show');
    Route::get('/system-logs/export', [SystemLogController::class, 'export'])->name('system-logs.export');
});

// ==============================
// CITY VETERINARIAN PORTAL
// Role: City Veterinarian
// Access: Consolidated reports, planning, regulatory decision-making
// ==============================
Route::middleware(['auth', 'role:city_vet'])->prefix('city-vet')->name('city-vet.')->group(function () {
    Route::get('/dashboard', [CityVetController::class, 'dashboard'])->name('dashboard');

    // Vaccination Reports
    Route::get('/vaccination-reports', [AdminController::class, 'indexVaccinationReports'])->name('vaccination-reports.index');
    Route::get('/vaccination-reports/{report}', [AdminController::class, 'showVaccinationReport'])->name('vaccination-reports.show');

    // Rabies Cases
    Route::get('/rabies-cases', [RabiesCaseController::class, 'index'])->name('rabies-cases.index');
    Route::get('/rabies-cases/{case}', [RabiesCaseController::class, 'show'])->name('rabies-cases.show');

    // Animal Bite Reports
    Route::get('/bite-reports', [AdminController::class, 'indexBiteReports'])->name('bite-reports.index');
    Route::get('/bite-reports/{report}', [AdminController::class, 'showBiteReport'])->name('bite-reports.show');

    // All Reports
    Route::get('/all-reports', [AdminController::class, 'allReports'])->name('all-reports');
});

// ==============================
// ADMINISTRATIVE STAFF PORTAL
// Role: Administrative Staff (Admin Assistant IV)
// Access: Encoding, organizing, maintaining official records
// ==============================
Route::middleware(['auth', 'role:admin_staff'])->prefix('admin-staff')->name('admin-staff.')->group(function () {
    Route::get('/dashboard', [AdminStaffController::class, 'dashboard'])->name('dashboard');
});

// ==============================
// DISEASE CONTROL PERSONNEL PORTAL
// Role: Disease Control Personnel (Vet III, Livestock Inspector, Vet Tech, Liaison Officer)
// Access: Animal health programs, vaccination activities, rabies and animal bite reports
// ==============================
Route::middleware(['auth', 'role:disease_control'])->prefix('disease-control')->name('disease-control.')->group(function () {
    Route::get('/dashboard', [DiseaseControlController::class, 'dashboard'])->name('dashboard');

    // Rabies Cases
    Route::get('/rabies-cases', [DiseaseControlController::class, 'indexCases'])->name('rabies-cases.index');

    // Animal Bite Reports
    Route::get('/animal-bite-reports', [DiseaseControlController::class, 'indexBiteReports'])->name('animal-bite-reports.index');
});

// ==============================
// CITY POUND PERSONNEL PORTAL
// Role: City Pound Personnel
// Access: Stray animal records, impounding activities, population control, adoption
// ==============================
Route::middleware(['auth', 'role:city_pound'])->prefix('city-pound')->name('city-pound.')->group(function () {
    Route::get('/dashboard', [CityPoundController::class, 'dashboard'])->name('dashboard');
});

// ==============================
// MEAT INSPECTION OFFICER PORTAL
// Role: Meat Inspector / Post-Abattoir Inspector
// Access: Inspection results, compliance monitoring, regulatory reports
// ==============================
Route::middleware(['auth', 'role:meat_inspector'])->prefix('meat-inspection')->name('meat-inspection.')->group(function () {
    Route::get('/dashboard', [MeatInspectionController::class, 'dashboard'])->name('dashboard');

    // Meat Inspection Reports
    Route::get('/reports/create', [MeatInspectionController::class, 'createReport'])->name('reports.create');
    Route::post('/reports', [MeatInspectionController::class, 'storeReport'])->name('reports.store');
    Route::get('/reports', [MeatInspectionController::class, 'indexReports'])->name('reports.index');
    Route::get('/reports/{report}', [MeatInspectionController::class, 'showReport'])->name('reports.show');
});

// ==============================
// BARANGAY PORTAL
// Role: Barangay Encoder
// Access: Submit stray reports, manage impounds, adoption requests
// ==============================
Route::middleware(['auth'])->prefix('barangay')->name('barangay.')->group(function () {
    Route::get('/dashboard', [BarangayController::class, 'dashboard'])->name('dashboard');

    // Data Entry (choose report type)
    Route::get('/data-entry', [BarangayController::class, 'showDataEntry'])->name('data-entry');

    // Stray Reports
    Route::get('/reports', [BarangayController::class, 'indexStrayReports'])->name('reports.index');
    Route::get('/reports/create', [BarangayController::class, 'createStrayReport'])->name('reports.create');
    Route::post('/reports', [BarangayController::class, 'storeStrayReport'])->name('reports.store');

    // Impound Records
    Route::get('/impounds', [BarangayController::class, 'indexImpoundRecords'])->name('impounds.index');

    // Adoption Requests
    Route::get('/adoptions', [BarangayController::class, 'indexAdoptionRequests'])->name('adoptions.index');

    // Notifications
    Route::get('/notifications', [BarangayController::class, 'indexNotifications'])->name('notifications.index');
    Route::put('/notifications/{notification}/mark-read', [BarangayController::class, 'markNotificationRead'])->name('notifications.mark-read');
});

// ==============================
// CLINIC PORTAL
// Role: Veterinary Clinic User
// Access: Submit rabies vaccination reports
// ==============================
Route::middleware(['auth', 'role:clinic'])->prefix('clinic')->name('clinic.')->group(function () {
    Route::get('/dashboard', [ClinicController::class, 'dashboard'])->name('dashboard');

    // Data Entry (choose report type)
    Route::get('/data-entry', [ClinicController::class, 'showDataEntry'])->name('data-entry');

    // Rabies Vaccination Reports
    Route::get('/vaccination-reports/create', [ClinicController::class, 'createVaccinationReport'])->name('vaccination-reports.create');
    Route::post('/vaccination-reports', [ClinicController::class, 'storeVaccinationReport'])->name('vaccination-reports.store');
    Route::get('/vaccination-reports', [ClinicController::class, 'indexVaccinationReports'])->name('vaccination-reports.index');
});

// ==============================
// SPAY/NEUTER PROGRAM MODULE
// Roles: admin, city_vet, super_admin, disease_control
// Access: Spay and neuter procedure reports
// ==============================
Route::middleware(['auth', 'role:admin|city_vet|super_admin|disease_control'])->prefix('spay-neuter')->name('spay-neuter.')->group(function () {
    Route::get('/dashboard', [SpayNeuterController::class, 'dashboard'])->name('dashboard');

    // Spay/Neuter Reports
    Route::get('/reports', [SpayNeuterController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [SpayNeuterController::class, 'create'])->name('reports.create');
    Route::post('/reports', [SpayNeuterController::class, 'store'])->name('reports.store');
    Route::get('/reports/{report}', [SpayNeuterController::class, 'show'])->name('reports.show');
    Route::get('/reports/{report}/edit', [SpayNeuterController::class, 'edit'])->name('reports.edit');
    Route::put('/reports/{report}', [SpayNeuterController::class, 'update'])->name('reports.update');
    Route::delete('/reports/{report}', [SpayNeuterController::class, 'destroy'])->name('reports.destroy');
});

// ==============================
// INVENTORY MANAGEMENT MODULE
// Roles: admin, city_vet, super_admin, inventory_staff
// Access: Vaccine and supply inventory management
// ==============================
Route::middleware(['auth', 'role:admin|city_vet|super_admin|inventory_staff'])->prefix('inventory')->name('inventory.')->group(function () {
    Route::get('/dashboard', [InventoryController::class, 'dashboard'])->name('dashboard');

    // Inventory Items
    Route::get('/', [InventoryController::class, 'index'])->name('index');
    Route::get('/create', [InventoryController::class, 'create'])->name('create');
    Route::post('/', [InventoryController::class, 'store'])->name('store');
    Route::get('/{item}', [InventoryController::class, 'show'])->name('show');
    Route::get('/{item}/edit', [InventoryController::class, 'edit'])->name('edit');
    Route::put('/{item}', [InventoryController::class, 'update'])->name('update');
    Route::delete('/{item}', [InventoryController::class, 'destroy'])->name('destroy');

    // Stock Movements
    Route::get('/{item}/stock-in', [InventoryController::class, 'showStockIn'])->name('stock-in');
    Route::post('/{item}/stock-in', [InventoryController::class, 'stockIn'])->name('stock-in.process');
    Route::get('/{item}/stock-out', [InventoryController::class, 'showStockOut'])->name('stock-out');
    Route::post('/{item}/stock-out', [InventoryController::class, 'stockOut'])->name('stock-out.process');
    Route::get('/{item}/adjustment', [InventoryController::class, 'showAdjustment'])->name('adjustment');
    Route::post('/{item}/adjustment', [InventoryController::class, 'adjustment'])->name('adjustment.process');

    // Alerts
    Route::get('/alerts/low-stock', [InventoryController::class, 'lowStock'])->name('low-stock');
    Route::get('/alerts/expiring', [InventoryController::class, 'expiring'])->name('expiring');

    // Movements Log
    Route::get('/movements', [InventoryController::class, 'movements'])->name('movements');
});

// ==============================
// ESTABLISHMENT MANAGEMENT MODULE
// Roles: admin, city_vet, super_admin, meat_inspection
// Access: Meat shops, pet shops, vet clinics, livestock facilities
// ==============================
Route::middleware(['auth', 'role:admin|city_vet|super_admin|meat_inspector'])->prefix('establishments')->name('establishments.')->group(function () {
    Route::get('/', [EstablishmentController::class, 'index'])->name('index');
    Route::get('/create', [EstablishmentController::class, 'create'])->name('create');
    Route::post('/', [EstablishmentController::class, 'store'])->name('store');
    Route::get('/{establishment}', [EstablishmentController::class, 'show'])->name('show');
    Route::get('/{establishment}/edit', [EstablishmentController::class, 'edit'])->name('edit');
    Route::put('/{establishment}', [EstablishmentController::class, 'update'])->name('update');
    Route::delete('/{establishment}', [EstablishmentController::class, 'destroy'])->name('destroy');
});

// ==============================
// LIVESTOCK CENSUS MODULE
// Roles: admin, city_vet, super_admin, barangay_encoder, records_staff
// Access: Provincial livestock census data
// ==============================
Route::middleware(['auth', 'role:admin|city_vet|super_admin|barangay_encoder|records_staff'])->prefix('livestock-census')->name('livestock-census.')->group(function () {
    Route::get('/', [LivestockCensusController::class, 'index'])->name('index');
    Route::get('/create', [LivestockCensusController::class, 'create'])->name('create');
    Route::post('/', [LivestockCensusController::class, 'store'])->name('store');
    Route::get('/{census}', [LivestockCensusController::class, 'show'])->name('show');
    Route::get('/{census}/edit', [LivestockCensusController::class, 'edit'])->name('edit');
    Route::put('/{census}', [LivestockCensusController::class, 'update'])->name('update');
    Route::delete('/{census}', [LivestockCensusController::class, 'destroy'])->name('destroy');
    Route::get('/summary', [LivestockCensusController::class, 'summary'])->name('summary');
});

// ==============================
// RABIES CASE MANAGEMENT MODULE
// Roles: admin, city_vet, super_admin, disease_control
// Access: Rabies case tracking and management
// ==============================
Route::middleware(['auth', 'role:admin|city_vet|super_admin|disease_control'])->prefix('rabies-cases')->name('rabies-cases.')->group(function () {
    Route::get('/', [RabiesCaseController::class, 'index'])->name('index');
    Route::get('/create', [RabiesCaseController::class, 'create'])->name('create');
    Route::post('/', [RabiesCaseController::class, 'store'])->name('store');
    Route::get('/{case}', [RabiesCaseController::class, 'show'])->name('show');
    Route::get('/{case}/edit', [RabiesCaseController::class, 'edit'])->name('edit');
    Route::put('/{case}', [RabiesCaseController::class, 'update'])->name('update');
    Route::delete('/{case}', [RabiesCaseController::class, 'destroy'])->name('destroy');
    Route::get('/summary', [RabiesCaseController::class, 'summary'])->name('summary');
});

// ==============================
// RECORDS STAFF PORTAL
// Role: Records Staff
// Access: Pet registration, owner records, vaccination encoding, records search
// ==============================
Route::middleware(['auth', 'role:records_staff'])->prefix('records-staff')->name('records-staff.')->group(function () {
    Route::get('/dashboard', [RecordsController::class, 'dashboard'])->name('dashboard');

    // Pet Registration
    Route::get('/pets', [RecordsController::class, 'pets'])->name('pets.index');
    Route::get('/pets/create', [RecordsController::class, 'createPet'])->name('pets.create');
    Route::post('/pets', [RecordsController::class, 'storePet'])->name('pets.store');
    Route::get('/pets/{pet}', [RecordsController::class, 'showPet'])->name('pets.show');
    Route::get('/pets/{pet}/edit', [RecordsController::class, 'editPet'])->name('pets.edit');
    Route::put('/pets/{pet}', [RecordsController::class, 'updatePet'])->name('pets.update');

    // Owner Records
    Route::get('/owners', [RecordsController::class, 'owners'])->name('owners.index');
    Route::get('/owners/{owner}', [RecordsController::class, 'showOwner'])->name('owners.show');

    // Vaccination Encoding
    Route::get('/vaccinations/create', [RecordsController::class, 'createVaccination'])->name('vaccinations.create');
    Route::post('/vaccinations', [RecordsController::class, 'storeVaccination'])->name('vaccinations.store');
    Route::get('/vaccinations', [RecordsController::class, 'vaccinations'])->name('vaccinations.index');
    Route::get('/vaccinations/{report}', [RecordsController::class, 'showVaccination'])->name('vaccinations.show');

    // Global Search
    Route::get('/search', [RecordsController::class, 'search'])->name('search');
});

// ==============================
// VIEWER PORTAL
// Role: Viewer (Read-only access)
// Access: View reports and dashboards
// ==============================
Route::middleware(['auth', 'role:viewer'])->prefix('viewer')->name('viewer.')->group(function () {
    Route::get('/dashboard', [ViewerController::class, 'dashboard'])->name('dashboard');
});

// ==============================
// PUBLIC PAGES (Citizen Portal)
// ==============================
Route::prefix('pages')->name('pages.')->group(function () {
    Route::get('/pet-owner-info', function() {
        return view('pages.pet-owner-info');
    })->name('pet-owner-info');

    Route::get('/programs-schedules', function() {
        return view('pages.programs-schedules');
    })->name('programs-schedules');

    Route::get('/reports-safety', function() {
        return view('pages.reports-safety');
    })->name('reports-safety');
});

// ==============================
// DEVICE TOKEN ROUTES (Push Notifications)
// ==============================
Route::middleware(['auth'])->prefix('api')->name('api.')->group(function () {
    // Store device token
    Route::post('/device-tokens', [\App\Http\Controllers\DeviceTokenController::class, 'store'])->name('device-tokens.store');

    // Update token usage
    Route::put('/device-tokens/usage', [\App\Http\Controllers\DeviceTokenController::class, 'updateUsage'])->name('device-tokens.update-usage');

    // Deactivate token
    Route::delete('/device-tokens', [\App\Http\Controllers\DeviceTokenController::class, 'destroy'])->name('device-tokens.destroy');

    // Get user's tokens
    Route::get('/device-tokens', [\App\Http\Controllers\DeviceTokenController::class, 'index'])->name('device-tokens.index');
});

// ==============================
// CLIENT PORTAL (Pet Owner) - NEW
// ==============================
// Only 'citizen' role can access these routes
// Admin/staff roles should use their respective dashboards

// Landing page for client portal
Route::get('/client', function () {
    return view('Client.welcome');
});

// OTP Routes - Only for citizens/clients
Route::prefix('otp')->group(function () {
    Route::get('/verify', [OtpController::class, 'showVerifyForm'])->name('otp.verify.form');
    Route::post('/send', [OtpController::class, 'sendOtp'])->name('otp.send');
    Route::post('/verify', [OtpController::class, 'verifyOtp'])->name('otp.verify');
    Route::get('/resend', [OtpController::class, 'resendOtp'])->name('otp.resend');
});

// Password Reset OTP Routes - Only for citizens/clients
Route::prefix('password')->group(function () {
    Route::get('/otp/verify', [OtpController::class, 'showResetVerifyForm'])->name('password.otp.form');
    Route::post('/otp/send', [OtpController::class, 'sendResetOtp'])->name('password.otp.send');
    Route::post('/otp/verify', [OtpController::class, 'verifyResetOtp'])->name('password.otp.verify');
    Route::get('/otp/resend', [OtpController::class, 'resendResetOtp'])->name('password.otp.resend');
});

// Services Page Route - Public
Route::get('/services', function () {
    return view('Client.services');
});

// Kapon Page Route - Public
Route::get('/kapon', function () {
    return view('Client.kapon');
});

// Kapon Form Page Route - Public
Route::get('/kapon/form', function () {
    return view('Client.kapon_form');
});

// Adoption Page Route - Public
Route::get('/adoption', function () {
    return view('Client.adoption');
});

// Adoption Form Page Route - Public
Route::get('/adoption/form', function () {
    return view('Client.adoption_form');
});

// Animal Cruelty Page Route - Public
Route::get('/animal-cruelty', function () {
    return view('Client.animal_cruelty_page');
});

// Missing Pets Page Route - Public
Route::get('/missing-pets', function () {
    return view('Client.missing_pets_page');
});

// Pet Registration Page Route - Public
Route::get('/pet-registration', function () {
    return view('Client.pet_registration_page');
});

// Pet Registration Form Page Route - Public
Route::get('/pet-registration/form', function () {
    return view('Client.pet_registration_form');
});

// Pet Registration Form POST Route - Only citizens
Route::post('/pet-registration/form', [PetRegistrationController::class, 'store'])->name('pet.registration.store');

// Vaccination Page Route - Public
Route::get('/vaccination', function () {
    return view('Client.vaccination_page');
});

// Vaccination Form Page Route - Public
Route::get('/vaccination/form', function () {
    return view('Client.vaccination_form');
});

// Owner Dashboard Route - Protected (any authenticated user)
Route::get('/owner/dashboard', function () {
    return view('Client.owner_dashboard');
})->middleware(['auth'])->name('owner.dashboard');

// View Pets Route
Route::get('/owner/pets', function () {
    return view('Client.view_pets');
})->middleware(['auth'])->name('owner.pets');

// Edit Pet Route
Route::get('/owner/pets/{id}/edit', [PetController::class, 'edit'])->middleware(['auth'])->name('pet.edit');

// Update Pet Route
Route::put('/owner/pets/{id}', [PetController::class, 'update'])->middleware(['auth'])->name('pet.update');

// Delete Pet Route
Route::delete('/owner/pets/{id}', [PetController::class, 'destroy'])->middleware(['auth'])->name('pet.destroy');

// Client Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
