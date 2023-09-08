<?php

namespace App\Services\Auth\SignInMethods;

use App\Models\User;
use App\Services\Auth\Contracts\AuthCredentialInterface;
use App\Services\Auth\Contracts\AuthSignInMethodInterface;
use App\Services\Auth\Contracts\Exceptions\AuthException;
use Illuminate\Support\Facades\Hash;

class PasswordSignInMethod implements AuthSignInMethodInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(User $user, AuthCredentialInterface $credential): User
    {
        if (!method_exists($credential, 'getPassword'))
            throw new \InvalidArgumentException('getPassword not found in given credential');

        if (!Hash::check($credential->getPassword(), $user->password))
            throw new AuthException('invalid_password');

        return $user;
    }
}
