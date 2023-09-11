<?php

namespace App\Services\Auth\Infrastructure\OneTimePassword\Contracts;

use App\Services\Auth\Contracts\AuthIdentifierInterface;
use App\Services\Base\Contracts\BaseServiceInterface;

interface OneTimePasswordRateLimiterServiceInterface extends BaseServiceInterface
{
    public function pass(AuthIdentifierInterface $identifier): bool;
}
