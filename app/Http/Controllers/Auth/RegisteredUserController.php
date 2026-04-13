<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PetOwner;
use App\Mail\WelcomeMail;
use App\Mail\OtpMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'suffix' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'],
            'block_lot_phase_house_no' => ['required', 'string', 'max:255'],
            'street_name' => ['required', 'string', 'max:255'],
            'subdivision' => ['required', 'string', 'max:255'],
            'barangay' => ['required', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'province' => ['nullable', 'string', 'max:255'],
            'dob_year' => ['nullable', 'string'],
            'dob_month' => ['nullable', 'string'],
            'dob_day' => ['nullable', 'string'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create user as unverified
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'active',
        ]);

        // Combine date of birth (if provided)
        $dateOfBirth = null;
        if ($request->dob_year && $request->dob_month && $request->dob_day) {
            $dateOfBirth = $request->dob_year . '-' . str_pad($request->dob_month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($request->dob_day, 2, '0', STR_PAD_LEFT);
        }

        // Create PetOwner record with all fields
        PetOwner::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name ?? null,
            'suffix' => $request->suffix ?? null,
            'phone_number' => $request->phone_number,
            'house_no' => $request->block_lot_phase_house_no,
            'street' => $request->street_name,
            'subdivision' => $request->subdivision,
            'barangay' => $request->barangay,
            'city' => $request->city ?? 'Dasmariñas City',
            'province' => $request->province ?? 'Cavite',
            'date_of_birth' => $dateOfBirth,
            'email' => $request->email,
        ]);

        // Generate and send OTP for email verification
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10)
        ]);

        // Send OTP email for verification
        try {
            Mail::to($user->email)->send(new OtpMail($otp));
        } catch (\Exception $e) {
            Log::warning('OTP email could not be sent: ' . $e->getMessage());
        }

        // Store email in session for OTP verification
        session(['email' => $user->email, 'registration_pending' => true]);

        // Redirect to OTP verification page
        return redirect()->route('otp.verify.form')->with('info', 'Please verify your email. An OTP has been sent to your email.');
    }
}