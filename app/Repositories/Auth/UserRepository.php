<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\Repositories\Auth\Contracts\UserRepositoryInterface;
use App\Services\Auth\Contracts\AuthIdentifierInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getUserByIdentifier(AuthIdentifierInterface $identifier, array $columns = ['*']): ?User
    {
        return User::query()
            ->whereIdentifier($identifier)
            ->first($columns);
    }

    /**
     * @inheritDoc
     */
    public function isUserExist(AuthIdentifierInterface $identifier): bool
    {
        return User::query()
            ->selectRaw('1')
            ->whereIdentifier($identifier)
            ->exists();
    }
}
