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

    public static function getOneTimePasswordRule(): array|string
    {
        return [
            'token' => ['required_if:credential.sign_in_method,otp', 'string', 'size:8'],
            'code' => ['required_if:credential.sign_in_method,otp', 'digits:6']
        ];
    }

    public static function getPasswordRule(): array|string
    {
        return [
            'password' => ['required_if:credential.sign_in_method,password', 'string', 'min:8', 'max:32']
        ];
    }
}
