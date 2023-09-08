<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\Repositories\Auth\Contracts\UserRepositoryInterface;
use App\Services\Auth\Contracts\AuthIdentifierInterface;

class UserRepository implements UserRepositoryInterface
{
    public function getUserByIdentifier(AuthIdentifierInterface $identifier): ?User
    {
        return User::query()
            ->firstWhere($identifier->getIdentifierType()->value, $identifier->getIdentifierValue());
    }
}
