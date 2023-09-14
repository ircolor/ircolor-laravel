<?php

namespace App\Notifications\Channels;

use App\Notifications\Contracts\NotificationChannelInterface;
use App\Notifications\Contracts\SMSNotificationInterface;
use App\Notifications\Messages\SMSMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class SMSChannel implements NotificationChannelInterface
{
    public function send(?object $notifiable, Notification $notification): mixed
    {
        if (! $notification instanceof SMSNotificationInterface) {
            throw new \InvalidArgumentException('$notification is not instance of SMSNotification');
        }

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
