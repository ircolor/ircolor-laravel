<?php

namespace App\Services\Auth\Infrastructure\OneTimePassword\Limiter\Contracts;

use App\Services\Auth\Contracts\AuthIdentifierInterface;
use App\Services\Auth\Infrastructure\OneTimePassword\Contracts\OneTimePasswordLimiterInterface;

interface OneTimePasswordRequestLimiterInterface extends OneTimePasswordLimiterInterface
{
    public function pass(AuthIdentifierInterface $identifier): bool;
}
