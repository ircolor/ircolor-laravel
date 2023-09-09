<?php

namespace App\Services\Auth\Contracts\Credentials\Base;

interface HasPasswordInterface
{
    public function getPassword(): ?string;
}
