<?php

namespace App\Services\Auth\Credentials;

use App\Services\Auth\Contracts\Credentials\PhoneCredentialInterface;
use App\Services\Auth\Enums\AuthIdentifierType;

class PhoneCredential extends AuthCredential implements PhoneCredentialInterface
{
    protected ?string $password;

    public function getSupportedIdentifiersTypes(): array
    {
        return [
            AuthIdentifierType::MOBILE
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

    public function getPassword(): ?string
    {
        // TODO: Implement getPassword() method.
        return $this->password;
    }

    public function getPhone(): string
    {
        // TODO: Implement getPhone() method.
        return $this->getIdentifier()->getIdentifierValue();
    }
}
