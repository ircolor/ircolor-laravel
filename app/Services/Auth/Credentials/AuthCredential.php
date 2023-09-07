<?php

namespace App\Services\Auth\Credentials;

use App\Services\Auth\Contracts\AuthCredentialInterface;
use App\Services\Auth\Enums\AuthProviderSignInMethod;
use App\Services\Auth\Providers\EmailProvider;
use Illuminate\Http\Request;

abstract class AuthCredential implements AuthCredentialInterface
{
    /**
     * @type array<string, class-string<AuthCredentialInterface>>
     */
    public const CREDENTIAL_MAPPER = [
        EmailProvider::ID => EmailCredential::class
    ];

    protected AuthProviderSignInMethod $signInMethod;

    /**
     * @var array<string, string>
     */
    protected array $payload;

    public static function createFromRequest(Request $request): self
    {
        $class = new \ReflectionClass(self::CREDENTIAL_MAPPER[$request->input('provider_id')]);

        return $class->newInstance(
            $request->enum('sign_in_method', AuthProviderSignInMethod::class),
            $request->input('payload', []),
        );
    }

    public function getProviderId(): string
    {
        return array_flip(self::CREDENTIAL_MAPPER)[static::class];
    }

    public function getSignInMethod(): AuthProviderSignInMethod
    {
        return $this->signInMethod;
    }
}
