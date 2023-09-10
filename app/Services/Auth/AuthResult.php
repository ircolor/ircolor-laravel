<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\Auth\Contracts\AuthExceptionInterface;
use App\Services\Auth\Contracts\AuthIdentifierInterface;
use App\Services\Auth\Contracts\AuthResultInterface;
use App\Services\Base\Contracts\HasBuilderInterface;
use Illuminate\Container\Container;

/**
 * @implements HasBuilderInterface<AuthResultInterface>
 */
class AuthResult implements AuthResultInterface, HasBuilderInterface
{
    /**
     * @param AuthIdentifierInterface $identifier
     * @param User|null $user
     * @param AuthExceptionInterface|null $exception
     * @param array<string,string>|null $payload
     */
    public function __construct(protected AuthIdentifierInterface $identifier, protected ?User $user = null, protected ?AuthExceptionInterface $exception = null, protected ?array $payload = null)
    {
        //
    }

    public static function getBuilder(): AuthResultBuilder
    {
        return Container::getInstance()
            ->make(AuthResultBuilder::class);
    }

    public function getIdentifier(): AuthIdentifierInterface
    {
        return $this->identifier;
    }

    public function getPayload(): ?array
    {
        return $this->payload;
    }

    public function isSuccessful(): bool
    {
        return $this->getException() === null;
    }

    public function getException(): ?AuthExceptionInterface
    {
        return $this->exception;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
}
