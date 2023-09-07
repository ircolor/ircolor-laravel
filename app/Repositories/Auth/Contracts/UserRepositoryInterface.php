<?php

namespace App\Repositories\Auth\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getUserByEmail(string $email): ?User;
}
