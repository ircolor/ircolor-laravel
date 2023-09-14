<?php

namespace App\Services\Auth\Model\Builder;

use App\Services\Auth\AuthIdentifier;
use App\Services\Auth\Contracts\AuthIdentifierInterface;
use App\Services\Auth\Enums\AuthIdentifierType;
use App\Services\Base\Contracts\EntityBuilderInterface;
use Illuminate\Validation\ValidationException;
use libphonenumber\PhoneNumberType;
use Propaganistas\LaravelPhone\PhoneNumber;

/**
 * @implements EntityBuilderInterface<AuthIdentifierInterface>
 */
class AuthIdentifierBuilder implements EntityBuilderInterface
{
    private ?AuthIdentifierType $identifierType = null;
    private ?string $value = null;

    /**
     * @param string $identifier
     * @return self
     * @throws ValidationException if unprocessable identifier passed
     */
    public function fromPlainIdentifier(string $identifier): self
    {
        $isPhone = ctype_digit(str_replace('+', '', $identifier));
        if ($isPhone) {
            $phone = new PhoneNumber($identifier, ['IR']);
            if (!$phone->isValid() || !$phone->isOfType(PhoneNumberType::MOBILE)) {
                throw ValidationException::withMessages([
                    'mobile' => __('auth.error.mobile')
                ]);
            }

            $this->identifierType = AuthIdentifierType::MOBILE;
            $this->value = str_replace(' ', '', $phone->formatNational());
        } else {
            throw ValidationException::withMessages([
                'identifier' => __('auth.error.identifier_not_supported')
            ]);
        }

        return $this;
    }

    public function build(): AuthIdentifierInterface
    {
        if ($this->identifierType === null || $this->value === null)
            throw new \InvalidArgumentException('$identifier or $value is null');

        return new AuthIdentifier($this->identifierType, $this->value);
    }
}
