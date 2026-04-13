<?php

namespace App\Http\Controllers\Clients\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(route('owner.dashboard', absolute: false))
                    : view('Client.auth.verify-email');
    }
}
