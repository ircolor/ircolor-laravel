<?php

namespace App\Services\Auth\Contracts;

interface AuthExceptionInterface extends \Throwable
{
    public function getErrorMessage(): string;
}
