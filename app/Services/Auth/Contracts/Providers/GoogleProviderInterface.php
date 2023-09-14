<?php

namespace App\Services\Auth\Contracts\Providers;

use App\Models\User;
use App\Services\Auth\Contracts\AuthProviderInterface;

interface GoogleProviderInterface extends AuthProviderInterface
{
    public function createUserWithGoogleIdToken(string $idToken): User;
}
