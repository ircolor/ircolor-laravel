<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\Auth\Contracts\AuthExceptionConverterInterface;
use App\Services\Auth\Contracts\AuthExceptionInterface;
use App\Services\Auth\Contracts\AuthIdentifierInterface;
use App\Services\Auth\Contracts\AuthResultInterface;
use App\Services\Base\Contracts\EntityBuilderInterface;

class AuthResultBuilder implements EntityBuilderInterface
{
    private AuthIdentifierInterface $identifier;

    /**
     * @var array<string, string>|null
     */
    private ?array $payload = null;

    private ?AuthExceptionInterface $exception = null;

    private ?User $user = null;

    public function __construct(private readonly AuthExceptionConverterInterface $exceptionConverter)
    {
        //
    }

    public function as(AuthIdentifierInterface $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function successful(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function failed(AuthExceptionInterface $exception): self
    {
        $this->exception = $this->exceptionConverter->convert($exception);

        return $this;
    }

    /**
     * @param array<string, string> $payload
     * @return $this
     */
    public function with(array $payload): self
    {
        $this->payload = $payload;

        return $this;
    }

    public function build(): AuthResultInterface
    {
        return new AuthResult($this->identifier, $this->user, $this->exception, $this->payload);
    }
}
