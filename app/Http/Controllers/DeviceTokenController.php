<?php

namespace App\Http\Controllers;

use App\Models\DeviceToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceTokenController extends Controller
{
    /**
     * Store or update a device token for the authenticated user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string|max:500',
            'device_type' => 'nullable|string|in:web,android,ios',
            'device_name' => 'nullable|string|max:255',
        ]);

        // Check if token already exists
        $existingToken = DeviceToken::where('token', $validated['token'])->first();

        if ($existingToken) {
            // Update existing token
            $existingToken->update([
                'user_id' => Auth::id(),
                'device_type' => $validated['device_type'] ?? 'web',
                'device_name' => $validated['device_name'] ?? null,
                'is_active' => true,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Device token updated successfully',
                'token' => $existingToken,
            ]);
        }

        // Create new token
        $deviceToken = DeviceToken::create([
            'user_id' => Auth::id(),
            'token' => $validated['token'],
            'device_type' => $validated['device_type'] ?? 'web',
            'device_name' => $validated['device_name'] ?? null,
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Device token stored successfully',
            'token' => $deviceToken,
        ]);
    }

    /**
     * Update the last_used_at timestamp for a device token.
     */
    public function updateUsage(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string|max:500',
        ]);

        $deviceToken = DeviceToken::where('token', $validated['token'])->first();

        if ($deviceToken) {
            $deviceToken->touchUsage();
            return response()->json([
                'success' => true,
                'message' => 'Token usage updated',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Token not found',
        ], 404);
    }

    /**
     * Deactivate a device token.
     */
    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string|max:500',
        ]);

        $deviceToken = DeviceToken::where('token', $validated['token'])
            ->where('user_id', Auth::id())
            ->first();

        if ($deviceToken) {
            $deviceToken->update(['is_active' => false]);
            return response()->json([
                'success' => true,
                'message' => 'Device token deactivated',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Token not found',
        ], 404);
    }

    /**
     * Get all active device tokens for the authenticated user.
     */
    public function index()
    {
        $deviceTokens = DeviceToken::where('user_id', Auth::id())
            ->active()
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'tokens' => $deviceTokens,
        ]);
    }
}
