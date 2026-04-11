<?php

namespace App\Http\Controllers\Client;

use App\Mail\OtpMail;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;

class OtpController extends Controller
{
    /**
     * Show the OTP verification form
     */
    public function showVerifyForm()
    {
        $email = session('email');

        if (!$email) {
            return redirect()->route('login');
        }

        return view('auth.verify-otp', compact('email'));
    }

    /**
     * Send OTP to user's email
     */
    public function sendOtp(Request $request)
    {
        $email = $request->email;

        $user = User::where('email', $email)->first();

        // Always return success to prevent user enumeration
        // If user exists, send OTP; otherwise, silently fail
        if (!$user) {
            return response()->json([
                'success' => true,
                'message' => 'If an account exists with this email, an OTP has been sent.'
            ]);
        }

        // Generate 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Save OTP to user (expires in 10 minutes)
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10)
        ]);

        // Send OTP email
        Mail::to($email)->send(new OtpMail($otp));

        // Store email in session
        session(['email' => $email]);

        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully'
        ]);
    }

    /**
     * Verify the OTP entered by user
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $email = session('email');

        if (!$email) {
            return redirect()->route('login');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->with('error', 'User not found')->withInput();
        }

        // Check if OTP is expired
        if ($user->otp_expires_at && Carbon::now()->gt($user->otp_expires_at)) {
            return back()->with('error', 'OTP has expired. Please request a new one.')->withInput();
        }

        // Check if OTP matches - use trim() to remove any whitespace
        $dbOtp = trim($user->otp_code);
        $inputOtp = trim($request->otp);

        if ($dbOtp !== $inputOtp) {
            return back()->with('error', 'Invalid OTP code. Please try again.')->withInput();
        }

        // Mark user as verified and clear OTP
        $user->update([
            'is_verified' => true,
            'otp_code' => null,
            'otp_expires_at' => null,
            'email_verified_at' => Carbon::now()
        ]);

        // Log the user in
        Auth::login($user);

        // Clear session
        session()->forget('email');
        
        // Check if this was from registration
        $wasRegistration = session('registration_pending');
        session()->forget('registration_pending');

        if ($wasRegistration) {
            // Send welcome email after verification
            try {
                Mail::to($user->email)->send(new \App\Mail\WelcomeMail($user));
            } catch (\Exception $e) {
                \Log::warning('Welcome email could not be sent: ' . $e->getMessage());
            }
            return redirect()->route('owner.dashboard')->with('success', 'Email verified successfully! Welcome to Vet MIS.');
        }

        return redirect()->route('owner.dashboard')->with('success', 'Email verified successfully!');
    }

    /**
     * Resend OTP
     */
    public function resendOtp()
    {
        $email = session('email');

        if (!$email) {
            return redirect()->route('login');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('login');
        }

        // Generate new 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Save new OTP
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10)
        ]);

        // Send OTP email
        Mail::to($email)->send(new OtpMail($otp));

        return back()->with('message', 'New OTP has been sent to your email.');
    }

    /**
     * Show the OTP verification form for password reset
     */
    public function showResetVerifyForm()
    {
        $email = session('reset_password_email');

        if (!$email) {
            return redirect()->route('password.request');
        }

        return view('auth.verify-otp-reset', compact('email'));
    }

    /**
     * Send OTP for password reset
     */
    public function sendResetOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email']
        ]);

        $email = $request->email;
        $user = User::where('email', $email)->first();

        // Always return success to prevent user enumeration
        if (!$user) {
            return response()->json([
                'success' => true,
                'message' => 'If an account exists with this email, a verification code has been sent.'
            ]);
        }

        // Generate 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Save OTP to user (expires in 10 minutes)
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10)
        ]);

        // Send OTP email
        Mail::to($email)->send(new OtpMail($otp));

        // Store email in session
        session(['reset_password_email' => $email]);

        return response()->json([
            'success' => true,
            'message' => 'Verification code sent successfully!'
        ]);
    }

    /**
     * Verify OTP for password reset
     */
    public function verifyResetOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $email = session('reset_password_email');

        if (!$email) {
            return redirect()->route('password.request')->with('error', 'Session expired. Please try again.');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.request')->with('error', 'User not found.');
        }

        // Check if OTP is expired
        if ($user->otp_expires_at && Carbon::now()->gt($user->otp_expires_at)) {
            return back()->with('error', 'Verification code has expired. Please request a new one.');
        }

        // Check if OTP matches
        $dbOtp = trim($user->otp_code);
        $inputOtp = trim($request->otp);

        if ($dbOtp !== $inputOtp) {
            return back()->with('error', 'Invalid verification code. Please try again.');
        }

        // OTP is valid - clear it and generate a password reset token
        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null
        ]);

        // Generate password reset token
        $token = Password::createToken($user);

        // Clear session
        session()->forget('reset_password_email');

        return redirect()->route('password.reset', ['token' => $token, 'email' => $email])->with('success', 'Verification successful! Please set your new password.');
    }

    /**
     * Resend OTP for password reset
     */
    public function resendResetOtp()
    {
        $email = session('reset_password_email');

        if (!$email) {
            return redirect()->route('password.request');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.request');
        }

        // Generate new 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Save new OTP
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10)
        ]);

        // Send OTP email
        Mail::to($email)->send(new OtpMail($otp));

        return redirect()->route('password.otp.form')->with('success', 'A new verification code has been sent to your email.');
    }
}
