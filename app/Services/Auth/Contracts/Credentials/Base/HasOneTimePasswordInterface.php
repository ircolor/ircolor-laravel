<?php

namespace App\Services\Auth\Contracts\Credentials\Base;

use Illuminate\Contracts\Validation\ValidationRule;

interface HasOneTimePasswordInterface
{
    public function getOneTimePassword(): ?string;

    public function getOneTimePasswordToken(): ?string;

    /**
     * @return array<string, string|string[]|ValidationRule>
     */
    public static function getOneTimePasswordRule(): array;
}
