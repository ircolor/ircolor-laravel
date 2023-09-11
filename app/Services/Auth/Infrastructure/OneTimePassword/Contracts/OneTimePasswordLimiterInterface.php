<?php

namespace App\Services\Auth\Infrastructure\OneTimePassword\Contracts;

use Carbon\CarbonInterval;

interface OneTimePasswordLimiterInterface
{
    public function getName(): string;

    public function decayInterval(): CarbonInterval;

    public function maxAttempts(): int;
}
