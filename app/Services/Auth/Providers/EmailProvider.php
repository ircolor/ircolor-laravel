<?php

namespace App\Services\Auth\Providers;

use App\Models\User;
use App\Repositories\Auth\Contracts\UserRepositoryInterface;
use App\Services\Auth\Contracts\AuthCredentialInterface;
use App\Services\Auth\Contracts\AuthResult;
use App\Services\Auth\Contracts\Credentials\EmailCredentialInterface;
use App\Services\Auth\Contracts\Exceptions\AuthException;
use App\Services\Auth\Contracts\Providers\EmailProviderInterface;
use App\Services\Auth\Enums\AuthProviderSignInMethod;
use App\Services\Auth\Enums\AuthProviderType;

class EmailProvider extends AuthProvider implements EmailProviderInterface
{
    public const ID = 'email';
    public const TYPE = AuthProviderType::INTERNAL;
    public const SIGN_IN_METHODS = [
        AuthProviderSignInMethod::PASSWORD,
        AuthProviderSignInMethod::LINK,
        AuthProviderSignInMethod::ONE_TIME_PASSWORD
    ];

    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
        //
    }

    /**
     * @param EmailCredentialInterface $credential
     * @return User
     * @throws AuthException
     */
    public function authenticate(EmailCredentialInterface|AuthCredentialInterface $credential): User
    {
        $user = $this->userRepository->getUserByEmail($credential->getEmail());

        if ($user === null) {
            throw new AuthException('user_not_found');
        }

        return match ($credential->getSignInMethod()) {
            AuthProviderSignInMethod::PASSWORD => throw new \Exception('To be implemented'),
            AuthProviderSignInMethod::LINK => throw new \Exception('To be implemented'),
            AuthProviderSignInMethod::OAUTH => throw new \Exception('To be implemented'),
            AuthProviderSignInMethod::ONE_TIME_PASSWORD => throw new \Exception('To be implemented'),
        };
    }

    public function createUserWithEmailAndPassword(string $email, string $password): User
    {
        // TODO: Implement createUserWithEmailAndPassword() method.
        return new User;
    }
}
