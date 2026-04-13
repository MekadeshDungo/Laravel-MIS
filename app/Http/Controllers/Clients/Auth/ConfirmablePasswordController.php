<?php

namespace App\Http\Controllers\Clients\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password view.
     */
    public function show()
    {
        return view('Client.auth.confirm-password');
    }

    /**
     * Confirm the user's password.
     */
    public function store(Request $request)
    {
        if (!Hash::check($request->password, $request->user()->password)) {
            throw ValidationException::withMessages([
                'password' => __('The provided password does not match our records.'),
            ]);
        }

        $request->session()->passwordConfirmed();

        return redirect()->intended();
    }
}
