<?php

namespace App\Services\Auth\Contracts\Providers;

use App\Models\User;
use App\Services\Auth\Contracts\AuthProviderInterface;

interface EmailProviderInterface extends AuthProviderInterface
{
    public function createUserWithEmailAndPassword(string $email, string $password): User;
}
