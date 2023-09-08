<?php

namespace App\Repositories\Auth\Contracts;

use App\Models\User;
use App\Services\Auth\Contracts\AuthIdentifierInterface;

interface UserRepositoryInterface
{
    public function getUserByIdentifier(AuthIdentifierInterface $identifier): ?User;
}
