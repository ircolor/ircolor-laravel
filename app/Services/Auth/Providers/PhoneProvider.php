<?php

namespace App\Services\Auth\Providers;

use App\Models\User;
use App\Services\Auth\Contracts\Providers\PhoneProviderInterface;
use App\Services\Auth\Enums\AuthProviderSignInMethod;
use App\Services\Auth\Enums\AuthProviderType;
use App\Services\Auth\SignInMethods\OneTimePasswordSignInMethod;
use App\Services\Auth\SignInMethods\PasswordSignInMethod;

class PhoneProvider extends AuthProvider implements PhoneProviderInterface
{
    public const ID = 'phone';
    public const TYPE = AuthProviderType::INTERNAL;
    public const SUPPORTED_SIGN_IN_METHODS = [
        AuthProviderSignInMethod::PASSWORD,
        AuthProviderSignInMethod::LINK,
        AuthProviderSignInMethod::ONE_TIME_PASSWORD
    ];
    protected const SIGN_IN_METHODS = [
        'password' => PasswordSignInMethod::class,
        'otp' => OneTimePasswordSignInMethod::class
    ];

    public function createUserWithPhoneAndPassword(string $phone, string $password): User
    {
        // TODO: Implement createUserWithPhoneAndPassword() method.
    }

    public function createUserWithPhone(string $phone): User
    {
        // TODO: Implement createUserWithPhone() method.
    }


}
