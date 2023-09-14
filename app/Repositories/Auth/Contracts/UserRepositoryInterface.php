<?php

namespace App\Repositories\Auth\Contracts;

use App\Models\User;
use App\Repositories\Base\Contracts\BaseRepositoryInterface;
use App\Services\Auth\Contracts\AuthIdentifierInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param AuthIdentifierInterface $identifier
     * @return bool
     */
    public function isUserExist(AuthIdentifierInterface $identifier): bool;

    /**
     * @param AuthIdentifierInterface $identifier
     * @param string[] $columns
     * @return User|null
     */
    public function getUserByIdentifier(AuthIdentifierInterface $identifier, array $columns = ['*']): ?User;
}
