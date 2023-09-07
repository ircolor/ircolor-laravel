<?php

namespace App\Services\Auth\Contracts;

use App\Models\User;
use App\Services\Auth\Enums\AuthProviderSignInMethod;
use App\Services\Auth\Enums\AuthProviderType;

interface AuthProviderInterface
{
    public function getProviderId(): string;

    public function getProviderType(): AuthProviderType;

    /**
     * @return AuthProviderSignInMethod[]
     */
    public function getProviderSignInMethods(): array;

    public function authenticate(AuthCredentialInterface $credential): User;
}
