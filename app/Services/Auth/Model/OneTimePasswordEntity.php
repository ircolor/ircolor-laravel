<?php

namespace App\Services\Auth\Model;

use App\Services\Auth\Contracts\AuthIdentifierInterface;
use App\Services\Auth\Model\Builder\OneTimePasswordEntityBuilder;
use App\Services\Auth\Model\Contracts\OneTimePasswordEntityInterface;
use Carbon\CarbonInterface;
use Carbon\CarbonInterval;
use Faker\Container\Container;
use Illuminate\Support\Facades\Hash;

class OneTimePasswordEntity implements OneTimePasswordEntityInterface
{
    public function __construct(protected AuthIdentifierInterface $identifier, protected string $token, protected string $code, protected CarbonInterval $interval, protected CarbonInterface $createdAt)
    {
        //
    }

    public static function getBuilder(): OneTimePasswordEntityBuilder
    {
        return new OneTimePasswordEntityBuilder;
    }

    public function getKey(): string
    {
        return self::getKeyStatically($this->identifier, $this->token);
    }

    public static function getKeyStatically(AuthIdentifierInterface $identifier, string $token): string
    {
        return substr(hash('sha256', $identifier->getIdentifierValue()),0, 16) . ':' . $token;
    }

    public function getIdentifier(): AuthIdentifierInterface
    {
        return $this->identifier;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getValidInterval(): CarbonInterval
    {
        return $this->interval;
    }

    public function getCreatedAt(): CarbonInterface
    {
        return $this->createdAt;
    }

    public function isRecentlyCreated(): bool
    {
        return Hash::isHashed($this->code);
    }

    public function toArray(): array
    {
        return [
            'token' => $this->getToken(),
            'code' => !$this->isRecentlyCreated() ? Hash::make($this->getCode()) : $this->getCode(),
            'interval' => $this->interval->totalSeconds,
            'created_at' => $this->getCreatedAt()->timestamp
        ];
    }
}
