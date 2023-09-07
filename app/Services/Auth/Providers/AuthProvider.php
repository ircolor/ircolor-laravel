<?php

namespace App\Services\Auth\Providers;

use App\Services\Auth\Contracts\AuthProviderInterface;
use App\Services\Auth\Enums\AuthProviderSignInMethod;
use App\Services\Auth\Enums\AuthProviderType;

abstract class AuthProvider implements AuthProviderInterface
{
    /**
     * @type string|null
     */
    public const ID = null;

    /**
     * @type AuthProviderType|null
     */
    public const TYPE = null;

    /**
     * @type AuthProviderSignInMethod[]|null
     */
    public const SIGN_IN_METHODS = null;

    public function getProviderId(): string
    {
        if (self::ID === null)
            throw new \InvalidArgumentException('TYPE const is null');

        return self::ID;
    }

    public function getProviderType(): AuthProviderType
    {
        if (self::TYPE === null)
            throw new \InvalidArgumentException('TYPE const is null');

        return self::TYPE;
    }

    public function getProviderSignInMethods(): array
    {
        if (self::SIGN_IN_METHODS === null)
            throw new \InvalidArgumentException('TYPE const is null');

        return self::SIGN_IN_METHODS;
    }
}
