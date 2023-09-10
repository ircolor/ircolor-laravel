<?php

namespace App\Services\Auth\Infrastructure\OneTimePassword\Contracts;

use App\Services\Auth\Infrastructure\OneTimePassword\Enum\OneTimePasswordVerifyError;

interface OneTimePasswordVerifyResultInterface extends OneTimePasswordResultInterface
{
    public function getVerifierError(): ?OneTimePasswordVerifyError;
}
