<?php

namespace App\Services\Auth\Contracts;

use App\Services\Auth\Enums\AuthProviderSignInMethod;

interface AuthCredentialInterface
{
    public function __construct(AuthProviderSignInMethod $signInMethod, array $payload);

    public function getProviderId(): string;

    public function getSignInMethod(): AuthProviderSignInMethod;
}
