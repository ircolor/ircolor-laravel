<?php

namespace App\Notifications\Contracts;

use Illuminate\Notifications\Notification;

interface NotificationChannelInterface
{
    public function send(mixed $notifiable, Notification $notification): mixed;
}
