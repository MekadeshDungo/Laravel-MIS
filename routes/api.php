<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\OtpController;
use App\Http\Controllers\Client\PetController;
use App\Http\Controllers\Client\PetRegistrationController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\DeviceTokenController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ServiceFormController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\RabiesCaseController;
use App\Http\Controllers\BarangayController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public Routes (No Authentication Required)
Route::prefix('public')->name('api.public.')->group(function () {
    // Landing page - API root returns JSON
    Route::get('/', function () {
        return response()->json([
            'message' => 'Vet MIS API',
            'version' => '1.0',
            'endpoints' => [
                'public/announcements',
                'public/certificates/verify/{series}',
                'public/service-forms',
                'auth/otp/*',
            ]
        ]);
    });

    // Public Announcements
    Route::get('/announcements', [AnnouncementController::class, 'publicIndex'])->name('announcements.index');
    Route::get('/announcements/{announcement}', [AnnouncementController::class, 'publicShow'])->name('announcements.show');
    
    // Public Barangays (for map display)
    Route::get('/barangays', function () {
        return response()->json(\App\Models\Barangay::select('barangay_id', 'barangay_name', 'latitude', 'longitude')->whereNotNull('latitude')->whereNotNull('longitude')->get());
    })->name('barangays.index');

    // Service Forms (Public submission)
    Route::post('/service-forms', [ServiceFormController::class, 'apiStore'])->middleware('throttle:5,1')->name('service-forms.store');

    // Certificate Verification
    Route::get('/certificates/verify/{certificateSeries}', [CertificateController::class, 'verify'])->name('certificates.verify');
});

// Authentication Routes (Mobile App)
Route::prefix('auth')->name('api.auth.')->group(function () {
    // Send OTP
    Route::post('/otp/send', [OtpController::class, 'sendOtp'])->middleware('throttle:3,1')->name('otp.send');

    // Verify OTP
    Route::post('/otp/verify', [OtpController::class, 'verifyOtp'])->middleware('throttle:5,1')->name('otp.verify');

    // Resend OTP
    Route::post('/otp/resend', [OtpController::class, 'resendOtp'])->middleware('throttle:3,1')->name('otp.resend');

    // Send OTP for Password Reset
    Route::post('/otp/reset/send', [OtpController::class, 'sendResetOtp'])->middleware('throttle:3,1')->name('otp.reset.send');

    // Verify OTP for Password Reset
    Route::post('/otp/reset/verify', [OtpController::class, 'verifyResetOtp'])->middleware('throttle:5,1')->name('otp.reset.verify');
});

// Protected Routes (Authentication Required)
Route::middleware('auth:sanctum')->group(function () {
    // Get authenticated user
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('api.user');

    // User Profile
    Route::prefix('profile')->name('api.profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Pet Management (for Pet Owners)
    Route::prefix('pets')->name('api.pets.')->group(function () {
        Route::get('/', [PetController::class, 'index'])->name('index');
        Route::post('/', [PetRegistrationController::class, 'store'])->name('store');
        Route::get('/{pet}', [PetController::class, 'show'])->name('show');
        Route::put('/{pet}', [PetController::class, 'update'])->name('update');
        Route::delete('/{pet}', [PetController::class, 'destroy'])->name('destroy');
    });

    // Device Token Routes (Push Notifications)
    Route::prefix('device-tokens')->name('api.device-tokens.')->group(function () {
        Route::post('/', [DeviceTokenController::class, 'store'])->name('store');
        Route::get('/', [DeviceTokenController::class, 'index'])->name('index');
        Route::put('/usage', [DeviceTokenController::class, 'updateUsage'])->name('update-usage');
        Route::delete('/', [DeviceTokenController::class, 'destroy'])->name('destroy');
    });

    // Authenticated Announcements
    Route::prefix('announcements')->name('api.announcements.')->group(function () {
        Route::get('/', [AnnouncementController::class, 'index'])->name('index');
        Route::post('/mark-read', [AnnouncementController::class, 'markAsRead'])->name('mark-read');
        Route::get('/{announcement}', [AnnouncementController::class, 'show'])->name('show');
    });

    // Rabies Heatmap Data (for visualizations)
    // Access: city_vet (full), super_admin (view-only)
    Route::prefix('rabies')->name('api.rabies.')->group(function () {
        Route::get('/heatmap', [RabiesCaseController::class, 'heatmap'])->name('heatmap');
        Route::get('/heatmap-data', [RabiesCaseController::class, 'getHeatmapData'])->name('heatmap-data');
        Route::get('/incidents', [RabiesCaseController::class, 'getIncidents'])->name('incidents');
        Route::get('/barangays', [RabiesCaseController::class, 'getBarangaysWithCaseCounts'])->name('barangays');
    });

    // Service Forms (Authenticated)
    Route::prefix('service-forms')->name('api.service-forms.')->group(function () {
        Route::get('/', [ServiceFormController::class, 'apiIndex'])->name('index');
        Route::get('/{serviceForm}', [ServiceFormController::class, 'apiShow'])->name('show');
    });
});

// Additional Public API endpoints can be added as needed
