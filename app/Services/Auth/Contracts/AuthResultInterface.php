<?php

namespace App\Services\Auth\Contracts;

use App\Models\User;

interface AuthResultInterface
{
    public function isSuccessful(): bool;

    public function getIdentifier(): AuthIdentifierInterface;

    public function getException(): ?AuthExceptionInterface;

    public function getUser(): ?User;

    /**
     * @return array<string, string>|null
     */
    public function getPayload(): ?array;
}
