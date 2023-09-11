<?php

namespace App\Services\Auth\Infrastructure\OneTimePassword\Limiter;

use App\Services\Auth\Infrastructure\OneTimePassword\Contracts\OneTimePasswordLimiterInterface;
use Illuminate\Support\Facades\RateLimiter;

abstract class OneTimePasswordLimiter implements OneTimePasswordLimiterInterface
{
    private string $prefix = 'otp';

    protected function getKey(): string
    {
        return $this->prefix. '_' . $this->getName();
    }

    protected function defaultPass(): bool
    {
        if (RateLimiter::tooManyAttempts($this->getKey(), $this->maxAttempts()))
            return false;

        RateLimiter::hit($this->getKey(), intval($this->decayInterval()->totalSeconds));

        return true;
    }
}
