<?php

namespace App\Notifications\Contracts;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @extends Arrayable<string, string>
 */
interface NotificationMessageInterface extends Arrayable
{
    //
}
