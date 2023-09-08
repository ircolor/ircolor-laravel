<?php

namespace App\Services\Auth;

use App\Services\Auth\Contracts\AuthIdentifierInterface;
use App\Services\Auth\Enums\AuthIdentifierType;

class AuthIdentifier implements AuthIdentifierInterface
{
    protected const PAYLOAD_NAME_IDENTIFIER_TYPE_MAPPER = [
        'email' => AuthIdentifierType::EMAIL,
        'phone' => AuthIdentifierType::PHONE
    ];

    protected AuthIdentifierType $type;
    protected string $value;

    /**
     * @param AuthIdentifierType $type
     * @param string $value
     */
    public function __construct(AuthIdentifierType $type, string $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * @param array<string, string> $payload
     * @return self
     */
    public static function createFromPayload(array $payload): self
    {
        /**
         * @type AuthIdentifierType|null $type
         */
        $type = null;

        foreach (self::PAYLOAD_NAME_IDENTIFIER_TYPE_MAPPER as $key => $value) {
            if (!empty($payload[$key])) {
                $type = $value;
                break;
            }
        }

        if ($type === null)
            throw new \InvalidArgumentException('$type is null');

        return new self($type, $payload[$type->value]);
    }

    public function getIdentifierType(): AuthIdentifierType
    {
        return $this->type;
    }

    public function getIdentifierValue(): string
    {
        return $this->value;
    }
}