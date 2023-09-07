<?php

namespace App\Services\Auth\Credentials;

use App\Services\Auth\Contracts\Credentials\EmailCredentialInterface;
use App\Services\Auth\Enums\AuthProviderSignInMethod;

class EmailCredential extends AuthCredential implements EmailCredentialInterface
{
    protected string $email;
    protected ?string $password;

    public function __construct(AuthProviderSignInMethod $signInMethod, array $payload)
    {
        $this->signInMethod = $signInMethod;

        $this->email = $payload['email'];
        $this->password = $payload['password'] ?? null;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
}
