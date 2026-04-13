<?php

namespace App\Services;

use App\Models\DeviceToken;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PushNotificationService
{
    /**
     * Firebase Cloud Messaging API endpoint
     */
    protected string $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

    /**
     * Firebase server key (should be in .env as FCM_SERVER_KEY)
     */
    protected string $serverKey;

    public function __construct()
    {
        $this->serverKey = config('services.fcm.server_key', env('FCM_SERVER_KEY', ''));
    }

    /**
     * Send push notification to a single device.
     */
    public function sendToDevice(DeviceToken $deviceToken, string $title, string $body, array $data = []): bool
    {
        if (empty($this->serverKey)) {
            Log::warning('FCM server key not configured');
            return false;
        }

        $payload = $this->buildPayload($title, $body, $data);

        if ($deviceToken->device_type === 'web') {
            return $this->sendWebPush($deviceToken->token, $payload);
        }

        return $this->sendFcm($deviceToken->token, $payload);
    }

    /**
     * Send push notification to multiple devices.
     */
    public function sendToDevices(array $deviceTokens, string $title, string $body, array $data = []): int
    {
        if (empty($this->serverKey)) {
            Log::warning('FCM server key not configured');
            return 0;
        }

        $payload = $this->buildPayload($title, $body, $data);
        $successCount = 0;

        foreach ($deviceTokens as $token) {
            if ($token->device_type === 'web') {
                if ($this->sendWebPush($token->token, $payload)) {
                    $successCount++;
                    $token->touchUsage();
                }
            } else {
                if ($this->sendFcm($token->token, $payload)) {
                    $successCount++;
                    $token->touchUsage();
                }
            }
        }

        return $successCount;
    }

    /**
     * Send push notification to all active tokens of a user.
     */
    public function sendToUser(int $userId, string $title, string $body, array $data = []): int
    {
        $deviceTokens = DeviceToken::where('user_id', $userId)->active()->get();
        return $this->sendToDevices($deviceTokens, $title, $body, $data);
    }

    /**
     * Send push notification to all users with active tokens.
     */
    public function sendToAll(string $title, string $body, array $data = []): int
    {
        $deviceTokens = DeviceToken::active()->get();
        return $this->sendToDevices($deviceTokens, $title, $body, $data);
    }

    /**
     * Build the FCM payload.
     */
    protected function buildPayload(string $title, string $body, array $data = []): array
    {
        return [
            'notification' => [
                'title' => $title,
                'body' => $body,
                'icon' => asset('images/notification-icon.png'),
                'click_action' => url('/dashboard'),
                'badge' => 1,
            ],
            'data' => array_merge($data, [
                'title' => $title,
                'body' => $body,
            ]),
            'priority' => 'high',
            'webpush' => [
                'headers' => [
                    'Urgency' => 'high',
                ],
            ],
        ];
    }

    /**
     * Send notification via FCM HTTP protocol.
     */
    protected function sendFcm(string $token, array $payload): bool
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'key=' . $this->serverKey,
                'Content-Type' => 'application/json',
            ])->post($this->fcmUrl, [
                'to' => $token,
                ...$payload,
            ]);

            if ($response->successful()) {
                $result = $response->json();
                if (isset($result['success']) && $result['success'] >= 1) {
                    return true;
                }
                Log::warning('FCM send failed', ['response' => $result, 'token' => substr($token, 0, 20) . '...']);
            } else {
                Log::error('FCM request failed', ['status' => $response->status(), 'body' => $response->body()]);
            }
        } catch (\Exception $e) {
            Log::error('FCM exception', ['error' => $e->getMessage()]);
        }

        return false;
    }

    /**
     * Send web push notification (FCM for web).
     */
    protected function sendWebPush(string $token, array $payload): bool
    {
        // For web push, we use the same FCM protocol but with different payload structure
        return $this->sendFcm($token, $payload);
    }

    /**
     * Check if FCM is configured.
     */
    public function isConfigured(): bool
    {
        return !empty($this->serverKey);
    }
}
