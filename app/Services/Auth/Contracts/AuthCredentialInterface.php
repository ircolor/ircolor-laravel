<?php

namespace App\Services\Auth\Contracts;

use App\Services\Auth\Enums\AuthIdentifierType;
use App\Services\Auth\Enums\AuthProviderSignInMethod;

interface AuthCredentialInterface
{
    /**
     * @param AuthIdentifierInterface $identifier
     * @param AuthProviderSignInMethod $signInMethod
     * @param array<string, string> $payload
     */
    public function __construct(AuthIdentifierInterface $identifier, AuthProviderSignInMethod $signInMethod, array $payload);

    public function getProviderId(): string;

    public function getIdentifier(): AuthIdentifierInterface;

    public function getSignInMethod(): AuthProviderSignInMethod;

    /**
     * @return AuthIdentifierType[]
     */
    public function getSupportedIdentifiersTypes(): array;
}
