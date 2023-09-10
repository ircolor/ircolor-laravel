<?php

namespace App\Services\Auth\SignInMethods;

use App\Models\User;
use App\Services\Auth\Contracts\AuthCredentialInterface;
use App\Services\Auth\Contracts\AuthSignInMethodInterface;

class OneTimePasswordSignInMethod implements AuthSignInMethodInterface
{
    public function __invoke(User $user, AuthCredentialInterface $credential): User
    {
        // TODO: Implement __invoke() method.
    }

    public function getUserRequiredColumns(): array
    {
        return [
            'phone'
        ];
    }
}
