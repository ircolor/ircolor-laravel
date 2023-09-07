<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\Repositories\Auth\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function getUserByEmail(string $email): ?User
    {
        return User::query()
            ->firstWhere('email', $email);
    }
}
