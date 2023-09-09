<?php

namespace App\Services\Auth\Credentials;

use App\Services\Auth\AuthIdentifier;
use App\Services\Auth\Contracts\AuthCredentialInterface;
use App\Services\Auth\Contracts\AuthIdentifierInterface;
use App\Services\Auth\Enums\AuthProviderSignInMethod;
use App\Services\Auth\Providers\EmailProvider;
use Illuminate\Container\Container;
use Illuminate\Http\Request;

abstract class AuthCredential implements AuthCredentialInterface
{
    /**
     * @type array<string, class-string<AuthCredentialInterface>>
     */
    public const CREDENTIAL_MAPPER = [
        EmailProvider::ID => EmailCredential::class
    ];

    /**
     * @param AuthIdentifierInterface $identifier
     * @param AuthProviderSignInMethod $signInMethod
     * @param array<string, string> $payload
     */
    public function __construct(protected AuthIdentifierInterface $identifier, protected AuthProviderSignInMethod $signInMethod, array $payload)
    {
        $this->throwIfIdentifierTypeNotSupported();
        $this->fillAttributes($payload);
    }

    public static function createFromRequest(Request $request): self
    {
        /**
         * @var array<string, string> $payload
         */
        $payload = $request->input('payload', []);

        return Container::getInstance()
            ->make(
                self::CREDENTIAL_MAPPER[$request->input('provider_id')],
                [
                    'identifier' => AuthIdentifier::createFromPayload($payload),
                    'signInMethod' => $request->enum('sign_in_method', AuthProviderSignInMethod::class),
                    'payload' => $payload
                ]
            );
    }

    public function getProviderId(): string
    {
        return array_flip(self::CREDENTIAL_MAPPER)[static::class];
    }

    public function getIdentifier(): AuthIdentifierInterface
    {
        return $this->identifier;
    }

    public function getSignInMethod(): AuthProviderSignInMethod
    {
        return $this->signInMethod;
    }

    /**
     * @return void
     */
    public function throwIfIdentifierTypeNotSupported(): void
    {
        if (!in_array($this->identifier->getIdentifierType(), $this->getSupportedIdentifiersTypes()))
            throw new \InvalidArgumentException(sprintf('Invalid identifier type [%s] in %s', $this->identifier->getIdentifierType()->name, class_basename(static::class)));
    }

    /**
     * @param array<string, string> $payload
     * @return void
     */
    private function fillAttributes(array $payload): void
    {
        $staticProperties = array_keys(get_class_vars(static::class));
        $staticProperties = array_diff($staticProperties, array_keys(get_object_vars($this)));

        foreach ($staticProperties as $property) {
            if (!empty($payload[$property])) {
                $this->{$property} = $payload[$property];
            }
        }
    }
}
