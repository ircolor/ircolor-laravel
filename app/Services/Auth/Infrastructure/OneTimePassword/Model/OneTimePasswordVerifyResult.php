<?php

namespace App\Services\Auth\Infrastructure\OneTimePassword\Model;

use App\Services\Auth\Infrastructure\OneTimePassword\Contracts\OneTimePasswordVerifyResultInterface;
use App\Services\Auth\Infrastructure\OneTimePassword\Enum\OneTimePasswordVerifyError;
use App\Services\Auth\Infrastructure\OneTimePassword\Model\Builder\OneTimePasswordVerifyResultBuilder;
use App\Services\Base\Contracts\HasBuilderInterface;

/**
 * @implements HasBuilderInterface<OneTimePasswordVerifyResultInterface>
 */
class OneTimePasswordVerifyResult extends OneTimePasswordResult implements OneTimePasswordVerifyResultInterface, HasBuilderInterface
{
    /**
     * @param OneTimePasswordVerifyError|null $verifyError
     * @param array<string, mixed> $payload
     */
    public function __construct(protected ?OneTimePasswordVerifyError $verifyError, array $payload = [])
    {
        parent::__construct($this->verifyError, $payload);
    }

    /**
     * @inheritDoc
     */
    public static function getBuilder(): OneTimePasswordVerifyResultBuilder
    {
        return new OneTimePasswordVerifyResultBuilder;
    }

    public function getVerifierError(): ?OneTimePasswordVerifyError
    {
        return $this->verifyError;
    }
}
