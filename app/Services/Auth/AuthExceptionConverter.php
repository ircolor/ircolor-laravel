<?php

namespace App\Services\Auth;

use App\Services\Auth\Contracts\AuthExceptionConverterInterface;
use App\Services\Auth\Contracts\AuthExceptionInterface;
use App\Services\Auth\Contracts\Exceptions\AuthException;

class AuthExceptionConverter implements AuthExceptionConverterInterface
{
    private const EXCEPTION_MAPPER = [
        'credential_not_match' => [
            'user_not_found',
            'invalid_password'
        ],
        'token_not_found_or_expired' => [
            'token_not_found'
        ]
    ];

    public function convert(AuthExceptionInterface $exception): AuthExceptionInterface
    {
        foreach (self::EXCEPTION_MAPPER as $convertTo => $convertFrom) {
            if (in_array($exception->getErrorMessage(), $convertFrom)) {
                return new AuthException($convertTo, $exception->getCode(), ['e' => $exception]);
            }
        }

        return $exception;
    }
}
