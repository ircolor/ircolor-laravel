<?php

namespace App\Notifications\Contracts;

use Illuminate\Notifications\Notification;

interface NotificationChannelInterface
{
    public function send(?object $notifiable, Notification $notification): mixed;
}
