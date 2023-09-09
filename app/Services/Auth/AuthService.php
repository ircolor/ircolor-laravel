<?php

namespace App\Services\Auth;

use App\Repositories\Auth\Contracts\UserRepositoryInterface;
use App\Services\Auth\Contracts\AuthCredentialInterface;
use App\Services\Auth\Contracts\AuthExceptionInterface;
use App\Services\Auth\Contracts\AuthResultInterface;
use App\Services\Auth\Contracts\AuthServiceInterface;
use App\Services\Auth\Providers\AuthProvider;
use App\Services\Base\BaseService;

/**
 * @extends BaseService<UserRepositoryInterface>
 */
class AuthService extends BaseService implements AuthServiceInterface
{
    public function __construct(UserRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function loginWithCredential(AuthCredentialInterface $credential): AuthResultInterface
    {
        return $this
            ->tryAuthenticate(fn() => AuthProvider::createFromProviderId($credential->getProviderId())->authenticate($credential))
            ->as($credential->getIdentifier())
            ->build();
    }

    /**
     * @param callable $closure
     * @return AuthResultBuilder
     */
    private function tryAuthenticate(callable $closure): AuthResultBuilder
    {
        $result = AuthResult::getBuilder();

        try {
            $result->successful($closure());
        } catch (AuthExceptionInterface $e) {
            $result->failed($e);
        }

        return $result;
    }
}
