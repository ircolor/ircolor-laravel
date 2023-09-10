<?php

namespace App\Notifications\Channels;

use App\Notifications\Contracts\NotificationChannelInterface;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class SMSChannel implements NotificationChannelInterface
{
    public function send(mixed $notifiable, Notification $notification): mixed
    {
        $message = $notification->toSMS($notifiable);

        if (app()->isLocal()) {
            Storage::drive('local')
                ->append('sms.txt', json_encode($message));
        } else {
            //TODO: Implement this
        }

        return $message;
    }
}
