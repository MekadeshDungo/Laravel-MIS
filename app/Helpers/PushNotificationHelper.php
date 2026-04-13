<?php

use App\Facades\PushNotification;

/**
 * Send a push notification to a user.
 *
 * @param \App\Models\User $user
 * @param string $title
 * @param string $body
 * @param array $data
 * @return bool
 */
function sendPushNotificationToUser($user, $title, $body, $data = [])
{
    return PushNotification::sendToUser($user, $title, $body, $data);
}

/**
 * Send a push notification to multiple users.
 *
 * @param array $users
 * @param string $title
 * @param string $body
 * @param array $data
 * @return bool
 */
function sendPushNotificationToUsers($users, $title, $body, $data = [])
{
    foreach ($users as $user) {
        sendPushNotificationToUser($user, $title, $body, $data);
    }
    return true;
}

/**
 * Broadcast a push notification to all users.
 *
 * @param string $title
 * @param string $body
 * @param array $data
 * @return bool
 */
function broadcastPushNotification($title, $body, $data = [])
{
    return PushNotification::sendToAll($title, $body, $data);
}
