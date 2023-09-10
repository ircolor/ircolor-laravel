<?php

namespace App\Notifications\Channels;

use App\Notifications\Contracts\NotificationChannelInterface;
use App\Notifications\Messages\SMSMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class SMSChannel implements NotificationChannelInterface
{
    public function send(mixed $notifiable, Notification $notification): mixed
    {
        /**
         * @var SMSMessage $message
         */
        $message = $notification->toSMS($notifiable);

        if (app()->isLocal()) {
            Log::debug($message->content, $message->toArray());
        } else {
            //TODO: Implement this
        }

        return $message;
    }
}
