<?php

namespace App\Services\Auth\Contracts\Credentials\Base;

interface HasEmailInterface
{
    public function getEmail(): string;
}
