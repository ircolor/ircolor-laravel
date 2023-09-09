<?php

namespace App\Services\Auth\Contracts\Credentials\Base;

interface HasOneTimePasswordInterface
{
    public function getOneTimePassword(): ?string;

    public function getOneTimePasswordToken(): ?string;
}
