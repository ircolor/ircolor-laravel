<?php

namespace App\Notifications\Contracts;

interface SMSNotificationInterface extends NotificationMessageInterface
{
    public function toSMS(object $notifiable): NotificationMessageInterface;
}
