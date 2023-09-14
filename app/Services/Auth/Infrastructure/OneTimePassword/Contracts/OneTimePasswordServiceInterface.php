<?php

namespace App\Services\Auth\Infrastructure\OneTimePassword\Contracts;

use App\Services\Auth\Contracts\AuthIdentifierInterface;
use App\Services\Auth\Model\Contracts\OneTimePasswordEntityInterface;
use App\Services\Base\Contracts\BaseServiceInterface;

interface OneTimePasswordServiceInterface extends BaseServiceInterface
{
    public function createOneTimePasswordWithIdentifier(AuthIdentifierInterface $identifier): OneTimePasswordEntityInterface;

    public function verifyOneTimePassword(AuthIdentifierInterface $identifier, string $token, string $code): OneTimePasswordResultInterface;
}
