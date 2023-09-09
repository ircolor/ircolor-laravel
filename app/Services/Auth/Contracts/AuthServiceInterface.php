<?php

namespace App\Services\Auth\Contracts;

interface AuthServiceInterface
{
    public function loginWithCredential(AuthCredentialInterface $credential): AuthResultInterface;
}
