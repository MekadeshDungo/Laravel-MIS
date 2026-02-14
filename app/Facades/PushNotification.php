<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * PushNotification Facade
 * 
 * @method static bool sendToDevice(string $token, string $title, string $body, array $data = [])
 * @method static bool sendToDevices(array $tokens, string $title, string $body, array $data = [])
 * @method static bool sendToUser(\App\Models\User $user, string $title, string $body, array $data = [])
 * @method static bool sendToAll(string $title, string $body, array $data = [])
 * 
 * @see \App\Services\PushNotificationService
 */
class PushNotification extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'push-notification';
    }
}
