<?php

namespace App\Services\Auth\Providers;

use App\Models\User;
use App\Services\Auth\Contracts\Providers\GoogleProviderInterface;
use App\Services\Auth\Enums\AuthProviderSignInMethod;
use App\Services\Auth\Enums\AuthProviderType;
use App\Services\Auth\SignInMethods\OAuthSignInMethod;

class GoogleProvider extends AuthProvider implements GoogleProviderInterface
{
    public const ID = 'google';
    public const TYPE = AuthProviderType::OAUTH;
    public const SUPPORTED_SIGN_IN_METHODS = [
        AuthProviderSignInMethod::OAUTH,
    ];
    protected const SIGN_IN_METHODS = [
        'oauth' => OAuthSignInMethod::class
    ];

    public function createUserWithGoogleIdToken(string $idToken): User
    {
        // TODO: Implement createUserWithGoogleIdToken() method.
        return new User;
    }
}
