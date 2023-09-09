<?php

namespace App\Services\Auth\Credentials;

use App\Services\Auth\Contracts\AuthIdentifierInterface;
use App\Services\Auth\Contracts\Credentials\EmailCredentialInterface;
use App\Services\Auth\Enums\AuthIdentifierType;
use App\Services\Auth\Enums\AuthProviderSignInMethod;

class EmailCredential extends AuthCredential implements EmailCredentialInterface
{
    protected ?string $password;

    public function __construct(protected AuthIdentifierInterface $identifier, protected AuthProviderSignInMethod $signInMethod, array $payload)
    {
        parent::__construct($this->identifier, $this->signInMethod, $payload);
    }

    public function getEmail(): string
    {
        return $this->identifier->getIdentifierValue();
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getSupportedIdentifiersTypes(): array
    {
        return [
            AuthIdentifierType::EMAIL
        ];
    }

    public function getOneTimePassword(): ?string
    {
        // TODO: Implement getOneTimePassword() method.
        return null;
    }

    public function getOneTimePasswordToken(): ?string
    {
        // TODO: Implement getOneTimePasswordToken() method.
        return null;
    }
}
