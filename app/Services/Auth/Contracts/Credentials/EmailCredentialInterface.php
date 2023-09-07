<?php

namespace App\Services\Auth\Contracts\Credentials;

use App\Services\Auth\Contracts\AuthCredentialInterface;

interface EmailCredentialInterface extends AuthCredentialInterface
{
    public function getEmail(): string;

    public function getPassword(): ?string;
}
