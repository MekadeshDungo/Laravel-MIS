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
use App\Http\Controllers\LivestockController;
use App\Http\Controllers\SpayNeuterController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\LivestockCensusController;
use App\Http\Controllers\RabiesCaseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\RecordsController;
use App\Http\Controllers\SystemLogController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\OtpController;
use App\Http\Controllers\Client\PetRegistrationController;
use App\Http\Controllers\Client\PetController;
use App\Http\Controllers\AdminAsst\CrueltyReportController;

// Include Breeze authentication routes
require __DIR__.'/auth.php';

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
| 5. Assistant Veterinary Personnel
| 6. City Pound Personnel
| 7. Meat Inspection Officer
|
*/


use App\Models\Animal;
use App\Models\Announcement;

// ... existing imports

Route::get('/', function () {
    // If user is authenticated, redirect to their role-based dashboard
    if (Auth::check()) {
        $user = Auth::user();
        switch ($user->role) {
            case 'super_admin':
                return redirect()->route('super-admin.dashboard');
            case 'city_vet':
                return redirect()->route('city-vet.dashboard');
            case 'admin_staff':
                return redirect()->route('admin-staff.dashboard');
            case 'assistant_vet':
                return redirect()->route('assistant-vet.dashboard');
            case 'livestock_inspector':
                return redirect()->route('livestock.dashboard');
            case 'meat_inspector':
                return redirect()->route('meat-inspection.dashboard');
            case 'citizen':
                return redirect()->route('owner.dashboard');
            default:
                // Unknown role - log out and redirect to login for security
                Auth::logout();
                return redirect()->route('login');
        }
    }
    // Get missing pets for the landing page
    $missingPets = Animal::where('is_missing', true)
        ->with('owner')
        ->orderBy('missing_since', 'desc')
        ->limit(5)
        ->get();
    
    // Get active announcements for public (all published, no audience filter)
    $announcements = Announcement::where('status', 'Published')
        ->where(function ($q) {
            $q->whereNull('publish_date')
                ->orWhere('publish_date', '<=', now());
        })
        ->where(function ($q) {
            $q->whereNull('expiry_date')
                ->orWhere('expiry_date', '>=', now());
        })
        ->orderByRaw("CASE priority WHEN 'Urgent' THEN 1 WHEN 'Important' THEN 2 ELSE 3 END")
        ->get();
    
    return view('Client.welcome', compact('missingPets', 'announcements'));
})->name('landing');

// ==============================
// AUTHENTICATION ROUTES - Client Portal (Default)
// ==============================
// Login routes moved to routes/auth.php (loaded at end of this file)

// ==============================
// PUBLIC ANNOUNCEMENTS (Citizen View)
// ==============================
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.public.index');
Route::get('/announcements/{announcement}', [AnnouncementController::class, 'publicShow'])->name('announcements.show');

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

    // User Management (Full Access - Super Admin Only)
    // These routes are protected by super_admin role middleware
    Route::get('/users', [SuperAdminController::class, 'users'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/toggle-status', [SuperAdminController::class, 'toggleUserStatus'])->name('users.toggle-status');

    // System Statistics API
    Route::get('/stats', [SuperAdminController::class, 'systemStats'])->name('stats');
    Route::get('/user-stats', [SuperAdminController::class, 'userStats'])->name('user-stats');

    // Activity Logs
    Route::get('/activity-logs', [SuperAdminController::class, 'activityLogs'])->name('activity-logs');

    // Reports Export
    Route::get('/export', [SuperAdminController::class, 'exportReport'])->name('export');

    // System Settings
    Route::get('/settings', [SuperAdminController::class, 'settings'])->name('settings');
    Route::put('/settings', [SuperAdminController::class, 'updateSettings'])->name('settings.update');

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
Route::middleware(['auth', 'role:city_vet'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // User Management (Limited - can manage users below their level)
    // Protected by city_vet role and additional hierarchy check in controller
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // All Reports (City-wide View)
    Route::get('/all-reports', [AdminController::class, 'allReports'])->name('all-reports');

    // Bite & Rabies Reports
    Route::get('/bite-rabies-reports', [AdminController::class, 'indexBiteReports'])->name('bite-reports.index');
    Route::get('/bite-rabies-reports/{report}', [AdminController::class, 'showBiteReport'])->name('bite-reports.show');
    Route::put('/bite-rabies-reports/{report}', [AdminController::class, 'updateBiteReport'])->name('bite-reports.update');

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

    // Rabies Geomap
    Route::get('/rabies-geomap', [CityVetController::class, 'geomap'])->name('rabies-geomap');
    Route::get('/rabies-geomap/data', [CityVetController::class, 'geomapData'])->name('rabies-geomap.data');

    // All Reports
    Route::get('/all-reports', [AdminController::class, 'allReports'])->name('all-reports');

    // Impound Records
    Route::get('/impounds', [AdminController::class, 'indexImpoundRecords'])->name('impound.index');

    // Bite & Rabies Reports
    Route::get('/bite-rabies-reports', [AdminController::class, 'indexBiteReports'])->name('bite-reports.index');
    Route::get('/bite-rabies-reports/{report}', [AdminController::class, 'showBiteReport'])->name('bite-reports.show');
    Route::put('/bite-rabies-reports/{report}', [AdminController::class, 'updateBiteReport'])->name('bite-reports.update');

    // Rabies Vaccination Reports (from Clinic)
    Route::get('/vaccination-reports', [AdminController::class, 'indexVaccinationReports'])->name('vaccination-reports.index');
    Route::get('/vaccination-reports/{report}', [AdminController::class, 'showVaccinationReport'])->name('vaccination-reports.show');

    // Meat Inspection Reports
    Route::get('/meat-inspection-reports', [AdminController::class, 'indexMeatInspectionReports'])->name('meat-inspection-reports.index');
    Route::get('/meat-inspection-reports/{report}', [AdminController::class, 'showMeatInspectionReport'])->name('meat-inspection-reports.show');

    // Impound Records
    Route::get('/impounds', [AdminController::class, 'indexImpoundRecords'])->name('impound.index');

    // Rabies Bite Reports - VIEW ONLY (No actions)
    Route::get('/rabies-bite-reports', [DiseaseControlController::class, 'indexRabiesReports'])->name('rabies-bite-reports.index');
    Route::get('/rabies-bite-reports/{rabiesReport}', [DiseaseControlController::class, 'showRabiesReport'])->name('rabies-bite-reports.show');
});

// ==============================
// ADMINISTRATIVE STAFF PORTAL
// Role: Administrative Staff (Admin Assistant IV / Book Binder 4)
// Access: Encoding, organizing, maintaining official records, portal gatekeeper
// ==============================
Route::middleware(['auth', 'role:admin_staff'])->prefix('admin-staff')->name('admin-staff.')->group(function () {
    Route::get('/dashboard', [AdminStaffController::class, 'dashboard'])->name('dashboard');

    // Pet Registration & Records
    Route::get('/pets', [RecordsController::class, 'pets'])->name('pets.index');
    Route::get('/pets/create', [RecordsController::class, 'createPet'])->name('pets.create');
    Route::post('/pets', [RecordsController::class, 'storePet'])->name('pets.store');
    Route::get('/pets/{animal}', [RecordsController::class, 'showAnimal'])->name('pets.show');
    Route::get('/pets/{animal}/edit', [RecordsController::class, 'editAnimal'])->name('pets.edit');
    Route::put('/pets/{animal}', [RecordsController::class, 'updateAnimal'])->name('pets.update');

    // Owner Records
    Route::get('/owners', [RecordsController::class, 'owners'])->name('owners.index');
    Route::get('/owners/{user}', [RecordsController::class, 'showOwner'])->name('owners.show');

    // Vaccination Records Encoding
    Route::get('/vaccinations', [RecordsController::class, 'vaccinations'])->name('vaccinations.index');
    Route::get('/vaccinations/create', [RecordsController::class, 'createVaccination'])->name('vaccinations.create');
    Route::post('/vaccinations', [RecordsController::class, 'storeVaccination'])->name('vaccinations.store');

    // Search & Reports
    Route::get('/search', [RecordsController::class, 'search'])->name('search');

    // Missing Pets
    Route::get('/missing-pets', [App\Http\Controllers\AdminAsst\MissingPetController::class, 'index'])->name('missing-pets.index');
    Route::get('/missing-pets/create', [App\Http\Controllers\AdminAsst\MissingPetController::class, 'create'])->name('missing-pets.create');
    Route::post('/missing-pets', [App\Http\Controllers\AdminAsst\MissingPetController::class, 'store'])->name('missing-pets.store');
    Route::get('/missing-pets/{animal}', [App\Http\Controllers\AdminAsst\MissingPetController::class, 'show'])->name('missing-pets.show');
    Route::get('/missing-pets/{animal}/edit', [App\Http\Controllers\AdminAsst\MissingPetController::class, 'edit'])->name('missing-pets.edit');
    Route::put('/missing-pets/{animal}', [App\Http\Controllers\AdminAsst\MissingPetController::class, 'update'])->name('missing-pets.update');
    Route::post('/missing-pets/{animal}/found', [App\Http\Controllers\AdminAsst\MissingPetController::class, 'markFound'])->name('missing-pets.mark-found');

    // Announcements (view only)
    Route::get('/announcements', [AnnouncementController::class, 'list'])->name('announcements.index');
});


// ASSISTANT VETERINARIAN PORTAL
// Role: Assistant Veterinarian (Vet 3)
// Access: Animal health programs, vaccination activities, rabies and animal bite reports, clinical actions
// ==============================
Route::middleware(['auth', 'role:assistant_vet'])->prefix('assistant-vet')->name('assistant-vet.')->group(function () {
    Route::get('/dashboard', [DiseaseControlController::class, 'dashboard'])->name('dashboard');

    // Rabies Cases
    Route::get('/rabies-cases', [DiseaseControlController::class, 'indexCases'])->name('rabies-cases.index');
    Route::get('/rabies-cases/{case}', [DiseaseControlController::class, 'showCase'])->name('rabies-cases.show');
    Route::put('/rabies-cases/{case}/complete', [DiseaseControlController::class, 'markComplete'])->name('rabies-cases.complete');

    // Animal Bite Reports
    Route::get('/animal-bite-reports', [DiseaseControlController::class, 'indexBiteReports'])->name('animal-bite-reports.index');
    Route::get('/animal-bite-reports/{report}', [DiseaseControlController::class, 'showBiteReport'])->name('animal-bite-reports.show');
    Route::put('/animal-bite-reports/{report}/complete', [DiseaseControlController::class, 'markBiteComplete'])->name('animal-bite-reports.complete');

    // Vaccinations
    Route::get('/vaccinations', [DiseaseControlController::class, 'indexVaccinations'])->name('vaccinations.index');
    Route::get('/vaccinations/create', [DiseaseControlController::class, 'createVaccination'])->name('vaccinations.create');
    Route::post('/vaccinations', [DiseaseControlController::class, 'storeVaccination'])->name('vaccinations.store');

    // Spay/Neuter
    Route::get('/spay-neuter', [DiseaseControlController::class, 'indexSpayNeuter'])->name('spay-neuter.index');
    Route::get('/spay-neuter/create', [DiseaseControlController::class, 'createSpayNeuter'])->name('spay-neuter.create');
    Route::post('/spay-neuter', [DiseaseControlController::class, 'storeSpayNeuter'])->name('spay-neuter.store');

    // Bite & Rabies Reports
    Route::get('/bite-rabies-reports', [DiseaseControlController::class, 'indexRabiesReports'])->name('rabies-bite-reports.index');
    Route::get('/bite-rabies-reports/{rabiesReport}', [DiseaseControlController::class, 'showRabiesReport'])->name('rabies-bite-reports.show');
    Route::put('/bite-rabies-reports/{rabiesReport}/check', [DiseaseControlController::class, 'acceptRabiesReport'])->name('rabies-bite-reports.check');
    Route::put('/bite-rabies-reports/{rabiesReport}/accept', [DiseaseControlController::class, 'acceptRabiesReport'])->name('rabies-bite-reports.accept');
    Route::put('/bite-rabies-reports/{rabiesReport}/resolve', [DiseaseControlController::class, 'resolveRabiesReport'])->name('rabies-bite-reports.resolve');
    Route::put('/bite-rabies-reports/{rabiesReport}/decline', [DiseaseControlController::class, 'declineRabiesReport'])->name('rabies-bite-reports.decline');

    // Convert Report to Rabies Case
    Route::get('/bite-rabies-reports/{rabiesReport}/create-case', [DiseaseControlController::class, 'createRabiesCaseFromReport'])->name('rabies-bite-reports.create-case');
    Route::post('/bite-rabies-reports/{rabiesReport}/store-case', [DiseaseControlController::class, 'storeRabiesCaseFromReport'])->name('rabies-bite-reports.store-case');

    // Announcements
    Route::get('/announcements', [AnnouncementController::class, 'list'])->name('announcements.index');

    // ========== ADMIN ASST MODULES (merged into assistant_vet) ==========
    // Pet Registrations (Portal Gatekeeper)
    Route::get('/pet-registrations', [\App\Http\Controllers\AdminAsst\PetRegistrationController::class, 'index'])->name('pet-registrations.index');
    Route::get('/pet-registrations/create', [\App\Http\Controllers\AdminAsst\PetRegistrationController::class, 'create'])->name('pet-registrations.create');
    Route::post('/pet-registrations', [\App\Http\Controllers\AdminAsst\PetRegistrationController::class, 'store'])->name('pet-registrations.store');
    Route::get('/pet-registrations/{pet}', [\App\Http\Controllers\AdminAsst\PetRegistrationController::class, 'show'])->name('pet-registrations.show');
    Route::get('/pet-registrations/{pet}/edit', [\App\Http\Controllers\AdminAsst\PetRegistrationController::class, 'edit'])->name('pet-registrations.edit');
    Route::put('/pet-registrations/{pet}', [\App\Http\Controllers\AdminAsst\PetRegistrationController::class, 'update'])->name('pet-registrations.update');
    Route::delete('/pet-registrations/{pet}', [\App\Http\Controllers\AdminAsst\PetRegistrationController::class, 'destroy'])->name('pet-registrations.destroy');
    Route::post('/pet-registrations/{pet}/approve', [\App\Http\Controllers\AdminAsst\PetRegistrationController::class, 'approve'])->name('pet-registrations.approve');

    // Appointment/Service Requests
    Route::get('/appointments', [\App\Http\Controllers\AdminAsst\AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/{appointment}', [\App\Http\Controllers\AdminAsst\AppointmentController::class, 'show'])->name('appointments.show');
    Route::post('/appointments/{appointment}/approve', [\App\Http\Controllers\AdminAsst\AppointmentController::class, 'approve'])->name('appointments.approve');
    Route::post('/appointments/{appointment}/reject', [\App\Http\Controllers\AdminAsst\AppointmentController::class, 'reject'])->name('appointments.reject');
    Route::post('/appointments/{appointment}/complete', [\App\Http\Controllers\AdminAsst\AppointmentController::class, 'complete'])->name('appointments.complete');
    Route::post('/appointments/{appointment}/reset', [\App\Http\Controllers\AdminAsst\AppointmentController::class, 'reset'])->name('appointments.reset');

    // Business Profiles (Poultry & Livestock)
    Route::get('/business-profiles', [\App\Http\Controllers\AdminAsst\BusinessProfileController::class, 'index'])->name('business-profiles.index');
    Route::get('/business-profiles/create', [\App\Http\Controllers\AdminAsst\BusinessProfileController::class, 'create'])->name('business-profiles.create');
    Route::post('/business-profiles', [\App\Http\Controllers\AdminAsst\BusinessProfileController::class, 'store'])->name('business-profiles.store');
    Route::get('/business-profiles/{businessProfile}', [\App\Http\Controllers\AdminAsst\BusinessProfileController::class, 'show'])->name('business-profiles.show');
    Route::get('/business-profiles/{businessProfile}/edit', [\App\Http\Controllers\AdminAsst\BusinessProfileController::class, 'edit'])->name('business-profiles.edit');
    Route::put('/business-profiles/{businessProfile}', [\App\Http\Controllers\AdminAsst\BusinessProfileController::class, 'update'])->name('business-profiles.update');
    Route::delete('/business-profiles/{businessProfile}', [\App\Http\Controllers\AdminAsst\BusinessProfileController::class, 'destroy'])->name('business-profiles.destroy');
    Route::post('/business-profiles/{businessProfile}/approve', [\App\Http\Controllers\AdminAsst\BusinessProfileController::class, 'approve'])->name('business-profiles.approve');
    Route::post('/business-profiles/{businessProfile}/suspend', [\App\Http\Controllers\AdminAsst\BusinessProfileController::class, 'suspend'])->name('business-profiles.suspend');
    Route::get('/business-profiles/export', [\App\Http\Controllers\AdminAsst\BusinessProfileController::class, 'export'])->name('business-profiles.export');

    // Inventory (merged with city-pound)
    Route::get('/inventory', [\App\Http\Controllers\AdminAsst\InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/create', [\App\Http\Controllers\AdminAsst\InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory', [\App\Http\Controllers\AdminAsst\InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{inventory}', [\App\Http\Controllers\AdminAsst\InventoryController::class, 'show'])->name('inventory.show');
    Route::get('/inventory/{inventory}/edit', [\App\Http\Controllers\AdminAsst\InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{inventory}', [\App\Http\Controllers\AdminAsst\InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{inventory}', [\App\Http\Controllers\AdminAsst\InventoryController::class, 'destroy'])->name('inventory.destroy');
    Route::get('/inventory/low-stock', [\App\Http\Controllers\AdminAsst\InventoryController::class, 'lowStock'])->name('inventory.low-stock');

    // Cruelty Reports
    Route::get('/cruelty-reports', [\App\Http\Controllers\AdminAsst\CrueltyReportController::class, 'index'])->name('cruelty-reports.index');
    Route::get('/cruelty-reports/create', [\App\Http\Controllers\AdminAsst\CrueltyReportController::class, 'create'])->name('cruelty-reports.create');
    Route::post('/cruelty-reports', [\App\Http\Controllers\AdminAsst\CrueltyReportController::class, 'store'])->name('cruelty-reports.store');
    Route::get('/cruelty-reports/{crueltyReport}', [\App\Http\Controllers\AdminAsst\CrueltyReportController::class, 'show'])->name('cruelty-reports.show');
    Route::get('/cruelty-reports/{crueltyReport}/edit', [\App\Http\Controllers\AdminAsst\CrueltyReportController::class, 'edit'])->name('cruelty-reports.edit');
    Route::put('/cruelty-reports/{crueltyReport}', [\App\Http\Controllers\AdminAsst\CrueltyReportController::class, 'update'])->name('cruelty-reports.update');
    Route::delete('/cruelty-reports/{crueltyReport}', [\App\Http\Controllers\AdminAsst\CrueltyReportController::class, 'destroy'])->name('cruelty-reports.destroy');

    // Impound Records (merged with city-pound)
    Route::get('/impounds', [\App\Http\Controllers\AdminAsst\ImpoundController::class, 'index'])->name('impounds.index');
    Route::get('/impounds/{impound}', [\App\Http\Controllers\AdminAsst\ImpoundController::class, 'show'])->name('impounds.show');
    Route::put('/impounds/{impound}', [\App\Http\Controllers\AdminAsst\ImpoundController::class, 'updateDisposition'])->name('impounds.update');

    // Adoptions (merged with city-pound)
    Route::get('/adoptions', [\App\Http\Controllers\AdminAsst\AdoptionController::class, 'index'])->name('adoptions.index');
    Route::get('/adoptions/create', [\App\Http\Controllers\AdminAsst\AdoptionController::class, 'create'])->name('adoptions.create');
    Route::post('/adoptions', [\App\Http\Controllers\AdminAsst\AdoptionController::class, 'store'])->name('adoptions.store');
    Route::get('/adoptions/{adoption}', [\App\Http\Controllers\AdminAsst\AdoptionController::class, 'show'])->name('adoptions.show');
    Route::post('/adoptions/{adoption}/approve', [\App\Http\Controllers\AdminAsst\AdoptionController::class, 'approve'])->name('adoptions.approve');
    Route::post('/adoptions/{adoption}/reject', [\App\Http\Controllers\AdminAsst\AdoptionController::class, 'reject'])->name('adoptions.reject');
    Route::post('/adoptions/{adoption}/complete', [\App\Http\Controllers\AdminAsst\AdoptionController::class, 'complete'])->name('adoptions.complete');
    Route::post('/adoptions/{adoption}/reset', [\App\Http\Controllers\AdminAsst\AdoptionController::class, 'reset'])->name('adoptions.reset');

    // Clinical Actions
    Route::get('/clinical-actions', [\App\Http\Controllers\AdminAsst\ClinicalActionController::class, 'index'])->name('clinical-actions.index');
    Route::get('/clinical-actions/create', [\App\Http\Controllers\AdminAsst\ClinicalActionController::class, 'create'])->name('clinical-actions.create');
    Route::post('/clinical-actions', [\App\Http\Controllers\AdminAsst\ClinicalActionController::class, 'store'])->name('clinical-actions.store');
    Route::get('/clinical-actions/{clinicalAction}', [\App\Http\Controllers\AdminAsst\ClinicalActionController::class, 'show'])->name('clinical-actions.show');
    Route::get('/clinical-actions/{clinicalAction}/edit', [\App\Http\Controllers\AdminAsst\ClinicalActionController::class, 'edit'])->name('clinical-actions.edit');
    Route::put('/clinical-actions/{clinicalAction}', [\App\Http\Controllers\AdminAsst\ClinicalActionController::class, 'update'])->name('clinical-actions.update');
    Route::delete('/clinical-actions/{clinicalAction}', [\App\Http\Controllers\AdminAsst\ClinicalActionController::class, 'destroy'])->name('clinical-actions.destroy');

    // Medical Records
    Route::get('/medical-records', [\App\Http\Controllers\MedicalRecordController::class, 'index'])->name('medical-records.index');
    Route::get('/medical-records/create', [\App\Http\Controllers\MedicalRecordController::class, 'create'])->name('medical-records.create');
    Route::post('/medical-records', [\App\Http\Controllers\MedicalRecordController::class, 'store'])->name('medical-records.store');
    Route::get('/medical-records/{medicalRecord}', [\App\Http\Controllers\MedicalRecordController::class, 'show'])->name('medical-records.show');
    Route::get('/medical-records/{medicalRecord}/edit', [\App\Http\Controllers\MedicalRecordController::class, 'edit'])->name('medical-records.edit');
    Route::put('/medical-records/{medicalRecord}', [\App\Http\Controllers\MedicalRecordController::class, 'update'])->name('medical-records.update');
    Route::delete('/medical-records/{medicalRecord}', [\App\Http\Controllers\MedicalRecordController::class, 'destroy'])->name('medical-records.destroy');

    // Rabies Geomap (Geospatial Mapping)
    Route::get('/rabies-geomap', [CityVetController::class, 'geomap'])->name('rabies-geomap');
    Route::get('/rabies-geomap/data', [CityVetController::class, 'geomapData'])->name('rabies-geomap.data');
});

// ==============================
// MEAT INSPECTION OFFICER PORTAL
// Role: Meat Inspector / Post-Abattoir Inspector
// Access: Inspection results, compliance monitoring, regulatory reports
// ==============================
Route::middleware(['auth', 'role:meat_inspector'])->prefix('meat-inspection')->name('meat-inspection.')->group(function () {
    Route::get('/dashboard', [MeatInspectionController::class, 'dashboard'])->name('dashboard');

    // Meat Inspection Reports
    Route::get('/reports', [MeatInspectionController::class, 'indexReports'])->name('reports.index');
    Route::get('/reports/create', [MeatInspectionController::class, 'createReport'])->name('reports.create');
    Route::post('/reports', [MeatInspectionController::class, 'storeReport'])->name('reports.store');
    Route::get('/reports/{report}', [MeatInspectionController::class, 'showReport'])->name('reports.show');
    Route::get('/reports/{report}/edit', [MeatInspectionController::class, 'editReport'])->name('reports.edit');
    Route::put('/reports/{report}', [MeatInspectionController::class, 'updateReport'])->name('reports.update');
    Route::delete('/reports/{report}', [MeatInspectionController::class, 'destroyReport'])->name('reports.destroy');

    // Meat Shop Inspections
    Route::get('/meat-shop', [MeatInspectionController::class, 'indexMeatShopInspections'])->name('meat-shop.index');
    Route::get('/meat-shop/create', [MeatInspectionController::class, 'createMeatShopInspection'])->name('meat-shop.create');
    Route::post('/meat-shop', [MeatInspectionController::class, 'storeMeatShopInspection'])->name('meat-shop.store');
    Route::get('/meat-shop/{inspection}', [MeatInspectionController::class, 'showMeatShopInspection'])->name('meat-shop.show');
    Route::put('/meat-shop/{inspection}', [MeatInspectionController::class, 'updateMeatShopInspection'])->name('meat-shop.update');
    Route::get('/meat-shop/address', [MeatInspectionController::class, 'getMeatShopAddress'])->name('meat-shop.address');

    // Meat Establishment Registration
    Route::get('/establishments', [MeatInspectionController::class, 'indexEstablishments'])->name('establishments.index');
    Route::get('/establishments/create', [MeatInspectionController::class, 'createEstablishment'])->name('establishments.create');
    Route::post('/establishments', [MeatInspectionController::class, 'storeEstablishment'])->name('establishments.store');
    Route::get('/establishments/{establishment}', [MeatInspectionController::class, 'showEstablishment'])->name('establishments.show');
    Route::put('/establishments/{establishment}', [MeatInspectionController::class, 'updateEstablishment'])->name('establishments.update');
});

// ==============================
// SPAY/NEUTER PROGRAM MODULE
// Roles: admin, city_vet, super_admin, disease_control
// Access: Spay and neuter procedure reports
// ==============================
Route::middleware(['auth', 'role:city_vet|super_admin|assistant_vet'])->prefix('spay-neuter')->name('spay-neuter.')->group(function () {
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
// Roles: city_vet, super_admin, inventory_staff, assistant_vet (merged)
// Access: Vaccine and supply inventory management
// ==============================
Route::middleware(['auth', 'role:city_vet|super_admin|inventory_staff|assistant_vet'])->prefix('inventory')->name('inventory.')->group(function () {
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
// ESTABLISHMENT MANAGEMENT MODULE (Business Profiling)
// Roles: city_vet, super_admin, meat_inspector, livestock_inspector
// Access: Meat shops, pet shops, vet clinics, livestock facilities, grooming
// ==============================
Route::middleware(['auth', 'role:livestock_inspector'])->prefix('establishments')->name('establishments.')->group(function () {
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
// Roles: city_vet, super_admin, assistant_vet, livestock_inspector
// Access: Provincial livestock census data
// ==============================
Route::middleware(['auth', 'role:city_vet|super_admin|assistant_vet|livestock_inspector'])->prefix('livestock-census')->name('livestock-census.')->group(function () {
    Route::get('/dashboard', [LivestockCensusController::class, 'index'])->name('dashboard');
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
// LIVESTOCK MANAGEMENT MODULE (Individual Animals)
// Roles: livestock_inspector, city_vet, super_admin
// Access: Individual livestock records for tracking
// ==============================
Route::middleware(['auth', 'role:livestock_inspector'])->prefix('livestock')->name('livestock.')->group(function () {
    Route::get('/dashboard', [LivestockController::class, 'dashboard'])->name('dashboard');
    Route::get('/', [LivestockController::class, 'index'])->name('index');
    Route::get('/create', [LivestockController::class, 'create'])->name('create');
    Route::post('/', [LivestockController::class, 'store'])->name('store');
    Route::get('/{livestock}', [LivestockController::class, 'show'])->name('show');
    Route::get('/{livestock}/edit', [LivestockController::class, 'edit'])->name('edit');
    Route::put('/{livestock}', [LivestockController::class, 'update'])->name('update');
    Route::delete('/{livestock}', [LivestockController::class, 'destroy'])->name('destroy');
    Route::get('/census', [LivestockController::class, 'census'])->name('census');
});

// ==============================
// RABIES CASE MANAGEMENT MODULE
// Roles: city_vet (full), super_admin (view-only)
// Access: Rabies case tracking and management
// ==============================
Route::middleware(['auth', 'role:city_vet|super_admin|assistant_vet'])->prefix('rabies-cases')->name('rabies-cases.')->group(function () {
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
// RABIES HEATMAP (GEOMAPPING)
// Roles: city_vet, assistant_vet
// Access: Rabies hotspots visualization
// ==============================
Route::middleware(['auth', 'role:city_vet|assistant_vet'])->prefix('rabies')->name('rabies.')->group(function () {
    Route::get('/heatmap', [RabiesCaseController::class, 'heatmap'])->name('heatmap');
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

// About Us Page Route - Public
Route::get('/about-us', function () {
    return view('Client.about_us');
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
    $user = auth()->user();
    $client = $user ? \App\Models\Client::where('email', $user->email)->first() : null;
    $pets = $client ? $client->pets : collect([]);

    $petsArray = $pets->map(function ($pet) {
        return [
            'id' => $pet->id,
            'name' => $pet->name,
            'species' => $pet->species,
            'breed' => $pet->breed,
            'age' => $pet->age,
            'weight' => $pet->weight,
            'image' => $pet->photo_url,
        ];
    })->toArray();

    return view('Client.kapon_form', compact('user', 'client', 'petsArray'));
});

// Adoption Page Route - Public
Route::get('/adoption', function () {
    return view('Client.adoption');
});

// Adoption Form Page Route - Public
Route::get('/adoption/form', function () {
    $user = auth()->user();
    $client = $user ? \App\Models\Client::where('email', $user->email)->first() : null;
    return view('Client.adoption_form', compact('user', 'client'));
});

// Animal Cruelty Page Route - Public
Route::get('/animal-cruelty', function () {
    return view('Client.animal_cruelty_page');
});

// Animal Cruelty Form Page Route - Public
Route::get('/animal-cruelty/form', function () {
    $barangays = \App\Models\Barangay::orderBy('barangay_name')->get();
    return view('Client.animal_cruelty_form', compact('barangays'));
});

// Animal Cruelty Report Submission - Public
Route::post('/animal-cruelty/form', [CrueltyReportController::class, 'publicStore'])->name('cruelty-report.public.store');

// Animal Cruelty Thank You Page Route - Public
Route::get('/animal-cruelty/thank-you', function () {
    return view('Client.animal_cruelty_thank_you');
})->name('cruelty-report.thank-you');

// Missing Pets Page Route - Public
Route::get('/missing-pets', function () {
    $missingPets = Animal::where('is_missing', true)
        ->with('owner')
        ->orderBy('missing_since', 'desc')
        ->get();
    
    // Get active announcements for public (all published, no audience filter)
    $announcements = Announcement::where('status', 'Published')
        ->where(function ($q) {
            $q->whereNull('publish_date')
                ->orWhere('publish_date', '<=', now());
        })
        ->where(function ($q) {
            $q->whereNull('expiry_date')
                ->orWhere('expiry_date', '>=', now());
        })
        ->orderByRaw("CASE priority WHEN 'Urgent' THEN 1 WHEN 'Important' THEN 2 ELSE 3 END")
        ->get();
    
    return view('Client.missing_pets_page', compact('missingPets', 'announcements'));
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
    $user = auth()->user();
    $client = $user ? \App\Models\Client::where('email', $user->email)->first() : null;
    $pets = $client ? $client->pets : collect([]);

    $petsArray = $pets->map(function ($pet) {
        return [
            'id' => $pet->id,
            'name' => $pet->name,
            'species' => $pet->species,
            'breed' => $pet->breed,
            'age' => $pet->age,
            'weight' => $pet->weight,
            'image' => $pet->photo_url,
        ];
    })->toArray();

    return view('Client.vaccination_form', compact('user', 'client', 'petsArray'));
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

// ==============================
// PROFILE ROUTES (Authenticated Users)
// ==============================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\Client\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\Client\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\Client\ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==============================
// BITE & RABIES REPORT - PUBLIC FORM
// ==============================
Route::get('/bite-rabies-report', [\App\Http\Controllers\Client\BiteRabiesReportController::class, 'create'])->name('bite-rabies-report.create');
Route::post('/bite-rabies-report', [\App\Http\Controllers\Client\BiteRabiesReportController::class, 'store'])->name('bite-rabies-report.store');
Route::get('/bite-rabies-report/success', [\App\Http\Controllers\Client\BiteRabiesReportController::class, 'success'])->name('bite-rabies-report.success');

require __DIR__.'/auth.php';
