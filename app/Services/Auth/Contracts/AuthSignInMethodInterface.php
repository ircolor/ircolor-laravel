<?php

namespace App\Services\Auth\Contracts;

use App\Models\User;
use App\Services\Auth\Contracts\Exceptions\AuthException;

interface AuthSignInMethodInterface
{
    /**
     * @param User $user
     * @param AuthCredentialInterface $credential
     * @return User
     * @throws AuthException
     */
    public function __invoke(User $user, AuthCredentialInterface $credential): User;
}
