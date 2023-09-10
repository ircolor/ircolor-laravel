<?php

namespace App\Services\Auth\Model\Contracts;

use App\Services\Auth\Contracts\AuthIdentifierInterface;
use Carbon\CarbonInterface;
use Carbon\CarbonInterval;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @extends Arrayable<string, string>
 */
interface OneTimePasswordEntityInterface extends Arrayable
{
    public function getKey(): string;

    public static function getKeyStatically(AuthIdentifierInterface $identifier, string $token): string;

    public function getIdentifier(): AuthIdentifierInterface;

    public function getToken(): string;

    public function getCode(): string;

    public function isRecentlyCreated(): bool;

    public function getValidInterval(): CarbonInterval;

    public function getCreatedAt(): CarbonInterface;
}
