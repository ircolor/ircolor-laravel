<?php

namespace App\Services\Auth\Contracts;

use App\Services\Auth\Enums\AuthProviderSignInMethod;

interface AuthCredentialInterface
{
    /**
     * @param AuthProviderSignInMethod $signInMethod
     * @param array<string, string> $payload
     */
    public function __construct(AuthProviderSignInMethod $signInMethod, array $payload);

    public function getProviderId(): string;

    public function getSignInMethod(): AuthProviderSignInMethod;
}
