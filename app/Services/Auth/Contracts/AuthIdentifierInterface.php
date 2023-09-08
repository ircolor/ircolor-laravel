<?php

namespace App\Services\Auth\Contracts;

use App\Services\Auth\Enums\AuthIdentifierType;

interface AuthIdentifierInterface
{
    public function getIdentifierType(): AuthIdentifierType;

    public function getIdentifierValue(): string;
}
