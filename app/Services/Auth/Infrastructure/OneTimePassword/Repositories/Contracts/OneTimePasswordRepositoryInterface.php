<?php

namespace App\Services\Auth\Infrastructure\OneTimePassword\Repositories\Contracts;

use App\Repositories\Base\Contracts\BaseRepositoryInterface;
use App\Services\Auth\Contracts\AuthIdentifierInterface;
use App\Services\Auth\Model\Contracts\OneTimePasswordEntityInterface;

interface OneTimePasswordRepositoryInterface extends BaseRepositoryInterface
{
    public function createOneTimePasswordWithIdentifier(OneTimePasswordEntityInterface $entity): bool;

    public function getOneTimePasswordWithIdentifierAndToken(AuthIdentifierInterface $identifier, string $token): ?OneTimePasswordEntityInterface;

    public function isOneTimePasswordExists(AuthIdentifierInterface $identifier, string $token): bool;

    public function removeOneTimePassword(OneTimePasswordEntityInterface $entity): bool;
}
