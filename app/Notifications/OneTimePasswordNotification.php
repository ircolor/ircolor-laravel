<?php

namespace App\Notifications;

use App\Notifications\Channels\SMSChannel;
use App\Notifications\Contracts\MailNotificationInterface;
use App\Notifications\Contracts\NotificationMessageInterface;
use App\Notifications\Contracts\SMSNotificationInterface;
use App\Notifications\Messages\SMSMessage;
use App\Services\Auth\Contracts\AuthIdentifierInterface;
use App\Services\Auth\Enums\AuthIdentifierType;
use App\Services\Auth\Model\Contracts\OneTimePasswordEntityInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OneTimePasswordNotification extends Notification implements SMSNotificationInterface, MailNotificationInterface
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private readonly AuthIdentifierInterface $identifier, private readonly OneTimePasswordEntityInterface $entity)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(): array
    {
        return match ($this->identifier->getIdentifierType()) {
            AuthIdentifierType::EMAIL => ['mail'],
            AuthIdentifierType::PHONE => [SMSChannel::class],
        };
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            //
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toSMS(mixed $notifiable): NotificationMessageInterface
    {
        return new SMSMessage(
            $this->identifier->getIdentifierValue(),
            __('auth.otp.sms.template', ['app_name' => __('global.app_name'), 'code' => $this->entity->getCode()])
        );
    }
}
