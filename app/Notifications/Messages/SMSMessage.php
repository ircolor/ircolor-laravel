<?php

namespace App\Notifications\Messages;

use App\Notifications\Contracts\NotificationMessageInterface;

class SMSMessage implements NotificationMessageInterface
{
    public function __construct(protected string $to,protected string $content)
    {
        //
    }

    public function toArray(): array
    {
        return [
            'to' => $this->to,
            'content' => $this->content
        ];
    }
}
