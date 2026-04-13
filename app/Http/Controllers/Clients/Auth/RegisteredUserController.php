<?php

namespace App\Http\Controllers\Clients\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('Client.auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admin_users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create user with 'citizen' role for client portal
        // Only citizen role is allowed to register through client portal
        $nameParts = explode(' ', $request->name, 2);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';

        $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'active',
        ]);

        event(new Registered($user));

        // Create pet owner record
        \App\Models\PetOwner::create([
            'user_id' => $user->id,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $request->email,
        ]);

        // System log for registration
        \App\Models\SystemLog::create([
            'user_id' => $user->id,
            'action' => 'register',
            'event' => 'create',
            'module' => 'Authentication',
            'description' => "New user registered via client portal",
            'ip_address' => request()->ip(),
            'status' => 'success',
        ]);

        Auth::login($user);

        return redirect()->to('/client');
    }
}
