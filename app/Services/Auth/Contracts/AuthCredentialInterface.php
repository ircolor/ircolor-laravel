<?php

namespace App\Services\Auth\Contracts;

use App\Services\Auth\Enums\AuthIdentifierType;
use App\Services\Auth\Enums\AuthProviderSignInMethod;
use Illuminate\Contracts\Validation\ValidationRule;

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

    /**
     * @return array<string, string|string[]|ValidationRule>
     */
    public static function getPayloadRules(): array;
}
