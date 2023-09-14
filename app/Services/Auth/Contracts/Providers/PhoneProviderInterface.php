<?php

namespace App\Services\Auth\Contracts\Providers;

use App\Models\User;
use App\Services\Auth\Contracts\AuthProviderInterface;

interface PhoneProviderInterface extends AuthProviderInterface
{
    public function createUserWithPhoneAndPassword(string $phone, string $password): User;

    public function createUserWithPhone(string $phone): User;
}
