<?php

namespace App\Services\Auth\Contracts\Credentials;

use App\Services\Auth\Contracts\AuthCredentialInterface;

interface GoogleCredentialInterface extends AuthCredentialInterface
{
    public function getEmail(): string;

    public function getIdToken(): string;

    public function getPlatform(): string;
}
