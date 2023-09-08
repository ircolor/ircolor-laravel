<?php

namespace App\Services\Auth\Providers;

use App\Models\User;
use App\Providers\AuthServiceProvider;
use App\Repositories\Auth\Contracts\UserRepositoryInterface;
use App\Services\Auth\Contracts\AuthCredentialInterface;
use App\Services\Auth\Contracts\AuthProviderInterface;
use App\Services\Auth\Contracts\AuthSignInMethodInterface;
use App\Services\Auth\Contracts\Exceptions\AuthException;
use App\Services\Auth\Enums\AuthProviderSignInMethod;
use App\Services\Auth\Enums\AuthProviderType;
use Illuminate\Container\Container;

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
    public const SUPPORTED_SIGN_IN_METHODS = null;

    /**
     * @type array<string, class-string<AuthSignInMethodInterface>>
     */
    protected const SIGN_IN_METHODS = [];

    public function __construct(protected UserRepositoryInterface $userRepository)
    {
        //
    }

    public static function createFromProviderId(string $id): AuthProviderInterface
    {
        return Container::getInstance()
            ->make(sprintf(AuthServiceProvider::CONTAINER_ALIAS_AUTH_PROVIDER_TEMPLATE, $id));
    }

    public function getProviderId(): string
    {
        if (self::ID === null)
            throw new \InvalidArgumentException('TYPE const is null');

        /**
         * @phpstan-ignore-next-line
         */
        return self::ID;
    }

    public function getProviderType(): AuthProviderType
    {
        if (self::TYPE === null)
            throw new \InvalidArgumentException('TYPE const is null');

        /**
         * @phpstan-ignore-next-line
         */
        return self::TYPE;
    }

    public function getProviderSignInMethods(): array
    {
        if (self::SUPPORTED_SIGN_IN_METHODS === null)
            throw new \InvalidArgumentException('TYPE const is null');

        /**
         * @phpstan-ignore-next-line
         */
        return self::SUPPORTED_SIGN_IN_METHODS;
    }

    public function authenticate(AuthCredentialInterface $credential): User
    {
        if (empty($signInMethodClass = static::SIGN_IN_METHODS[$signInMethodEnumValue = $credential->getSignInMethod()->value] ?? null)) {
            throw new \InvalidArgumentException(sprintf('sign in method %s not defined', $signInMethodEnumValue));
        }

        if (empty($user = $this->userRepository->getUserByIdentifier($credential->getIdentifier()))) {
            throw new AuthException('user_not_found');
        }

        /**
         * @var AuthSignInMethodInterface $signInMethod
         */
        $signInMethod = Container::getInstance()->make($signInMethodClass);

        return $signInMethod->__invoke($user, $credential);
    }
}
