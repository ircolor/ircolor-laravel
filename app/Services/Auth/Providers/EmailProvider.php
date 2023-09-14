<?php

namespace App\Services\Auth\Providers;

use App\Models\User;
use App\Services\Auth\Contracts\Providers\EmailProviderInterface;
use App\Services\Auth\Enums\AuthProviderSignInMethod;
use App\Services\Auth\Enums\AuthProviderType;
use App\Services\Auth\SignInMethods\PasswordSignInMethod;

class EmailProvider extends AuthProvider implements EmailProviderInterface
{
    public const ID = 'email';
    public const TYPE = AuthProviderType::INTERNAL;
    public const SUPPORTED_SIGN_IN_METHODS = [
        AuthProviderSignInMethod::PASSWORD,
        AuthProviderSignInMethod::LINK,
        AuthProviderSignInMethod::ONE_TIME_PASSWORD
    ];
    protected const SIGN_IN_METHODS = [
        'password' => PasswordSignInMethod::class
    ];

    public function createUserWithEmailAndPassword(string $email, string $password): User
    {
        // TODO: Implement createUserWithEmailAndPassword() method.
        return new User;
    }
}
