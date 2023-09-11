<?php

namespace App\Notifications;

use App\Notifications\Channels\SMSChannel;
use App\Notifications\Contracts\MailNotificationInterface;
use App\Notifications\Contracts\NotificationMessageInterface;
use App\Notifications\Contracts\SMSNotificationInterface;
use App\Notifications\Messages\SMSMessage;
use App\Services\Auth\Contracts\AuthIdentifierInterface;
use App\Services\Auth\Enums\AuthIdentifierType;
use App\Services\Auth\Infrastructure\OneTimePassword\Repositories\Contracts\OneTimePasswordRepositoryInterface;
use App\Services\Auth\Model\Contracts\OneTimePasswordEntityInterface;
use Carbon\CarbonInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OneTimePasswordNotification extends Notification implements ShouldQueue, ShouldBeEncrypted, SMSNotificationInterface, MailNotificationInterface
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
     * @param object|null $notifiable
     * @param string $channel
     * @return array<string|class-string, CarbonInterface>|CarbonInterface|null
     */
    public function withDelay(?object $notifiable, string $channel): array|CarbonInterface|null
    {
        return match ($channel) {
            SMSChannel::class => now()->addSeconds(3),
            default => null
        };
    }

    public function shouldSend(?object $notifiable, string $channel): bool
    {
        return app(OneTimePasswordRepositoryInterface::class)
            ->isOneTimePasswordExists($this->identifier, $this->entity->getToken());
    }

    public function toMail(?object $notifiable): MailMessage
    {
        //TODO: This throw exception because $notifiable is null and mail channel try to get route from that
        return (new MailMessage)
            ->subject('OTP Code')
            ->line('You are receiving this email for OTP verification.')
            ->line('Your OTP code is: ' . $this->entity->getCode())
            ->line('If you did not request this OTP, no further action is required.');
    }

    public function toSMS(?object $notifiable): NotificationMessageInterface
    {
        return new SMSMessage(
            $this->identifier->getIdentifierValue(),
            __('auth.otp.sms.template', ['app_name' => __('global.app_name'), 'code' => $this->entity->getCode()])
        );
    }
}
