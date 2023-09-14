<?php

namespace App\Services\Auth\Contracts;

interface AuthExceptionConverterInterface
{
    public function convert(AuthExceptionInterface $exception): AuthExceptionInterface;
}
