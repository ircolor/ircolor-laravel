<?php

namespace App\Services\Auth\Infrastructure\OneTimePassword\Contracts;

use App\Services\Auth\Model\Contracts\OneTimePasswordEntityInterface;
use App\Services\Base\Contracts\BaseServiceInterface;

interface OneTimePasswordVerifierServiceInterface extends BaseServiceInterface
{
    public function verify(OneTimePasswordEntityInterface $oneTimePasswordEntity, string $code): OneTimePasswordVerifyResultInterface;

    public function check(OneTimePasswordEntityInterface $oneTimePasswordEntity, string $code): bool;
}
